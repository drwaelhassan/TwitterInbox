<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphNodeFactory;
class FacebookController extends Controller
{
    // FB 
    private $appId     = '1895853557226516';
    private $appSecret = '2e45e2b6e317018d608050b10b848a7a';
    private $fbCallback  = 'https://inbox.ki.social/fbRedirect';
    private $fb;

    function __construct(){
        $this->fb = new Facebook([
            'app_id' => $this->appId,
            'app_secret' => $this->appSecret,
        ]);
    }
    /*------------------------------------------------------------------------------------LOGIN AND REDIRECT--------------------------------------------------------------------*/
    public function fbRedirect(Request $request)
    {
        $user = Session::get('user');
        $helper = $this->fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return redirect('/home')->with('error', 'Facebook Login Error');  ;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return redirect('/home')->with('error', 'Facebook Login Error');  ;
        }
        if (! isset($accessToken)) {
            return redirect('/home')->with('error', 'Facebook Login Error');  ;
        }
        $oAuth2Client = $this->fb->getOAuth2Client();
        // $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        // $tokenMetadata->validateAppId($this->appId);
        // $tokenMetadata->validateExpiration();
        if (isset($accessToken)) {
            $response = $this->fb->get('/me?fields=id,name,email,accounts',$accessToken);
            $this->setFbUserData($response->getDecodedBody(),$accessToken);
            return redirect('/home')->with('success', 'Logged in Facebook');
        }else{
            return redirect('/home')->with('error', 'Facebook Login error');
        }
    }
    // public function fbRedirect(Request $request)
    // {
    //     $accessToken = 'EAAa8RM3THBQBAORoI0PAeAGy5sbSIC5wQwMLK1DuKeD0n1ZA3INKDyCrFSK8C5CaDoC6UTMgDBxnxzNfOozrU8IpNhpDy3ovToVfiZC6NUhRs0aI3JafSCGc9HdUzlMZArWT9QC0qp42EZBHDLhXXRtxZAfOligIa0hUhq3yTkQtHn22UiGIwoeyRGgDM9M1zdVRci7iePgZDZD';
    //     $user = Session::get('user');
    //     $response = $this->fb->get('/me?fields=id,name,email,accounts',$accessToken);
    //     if (isset($accessToken)) {
    //         $this->setFbUserData($response->getDecodedBody(),$accessToken);
    //         return redirect('/home')->with('success', 'Logged in Facebook');
    //     }else{
    //         return redirect('/home')->with('error', 'Facebook Login error');
    //     }    
    // }
    
    protected function setFbUserData( $fbUser,$fbAccessToken ) :void {




        $user     = Session::get('user'); 
        
        $userId   = $fbUser['id'];
        $exist    = DB::table('users')->where(['userId' => $userId,'provider' => 'facebook'])->first();
        $userData = [
            'userId'        => $fbUser['id'],
            'email'         => isset($fbUser['email']) ? $fbUser['email'] : NULL,
            'user_name'     => $fbUser['name'],
            'access_token'  => $fbAccessToken,
            'twitter_oauth' => $user->userId,
            'provider'      => 'facebook',
            'modified'      => strtotime(date('Y-m-d'))
        ];
        if (is_null($exist)) {
            $userData['created'] = strtotime(date('Y-m-d'));
            DB::table('users')->insert($userData);
        }else{
            DB::table('users')->where(['userId' => $userId,'provider' => 'facebook'])->update($userData);
        }
        $userAccounts = [];
        if (isset($fbUser['accounts'])) {
            $fbPages = $fbUser['accounts'];
            if (isset($fbPages['data']) && !empty($fbPages['data'])) {
                foreach ($fbPages['data'] as $page) {
                    $pageSession = ['id'=>$page['id'],'accessToken'=>$page['access_token'],'pageName'=>$page['name']];
                    $accounts[]  = $pageSession; 
                    $exist    = DB::table('facebook_pages')->where(['user_id'=>$userId,'page_id'=>$page['id']])->first();
                    $pageData = [
                        'page_id'           => $page['id'],
                        'page_name'         => $page['name'],
                        'page_access_token' => $page['access_token'],
                        'user_id'           => $userId,
                        'category'          => $page['category']
                    ];
                    if (is_null($exist)) {
                        DB::table('facebook_pages')->insert($pageData);    
                    }else{
                        DB::table('facebook_pages')->where('id',$exist->id)->update($pageData);
                    }
                }
            }
        }
        $fbUser['accounts'] = $accounts;
        $user->facebook     = $fbUser;
        Session::put('user',$user);
    }
    /*------------------------------------------------------------------------------------END LOGIN AND REDIRECT--------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------MESSAGES--------------------------------------------------------------------*/

    public function getPageMessages($url,$accessToken = false)
    {
        if ($accessToken) {
            $response = $this->fb->get($url,$accessToken);
        }else{
            $response = $this->fb->get($url);
        }
        $messages = $response->getDecodedBody();
        $end      = $this->insertPageMessages($messages);
        if ($end) {
            return 1;
        }
    }

    public function insertPageMessages($data)
    {
        $feeds = $data['data'];
        if (empty($feeds)) {
            return 1;
        }
        foreach ($feeds as $feed) {
            $this->insertFeedMessages($feed);   
        }
        if (isset($data['paging']['next'])) {
            $this->getPageMessages($data['paging']['next']);
        }else{
            return 1;
        }
    }
    public function insertFeedMessages( $feed )
    {
        $nextMessages = false;
        if (isset($feed['messages']['paging']['next'])) {
            $nextMessages = $feed['messages']['paging']['next'];
        }
        $messages = $feed['messages']['data'];
        if (empty($messages)) {
            return 1;
        }
        foreach ($messages as $message) {
            $exist    = DB::table('facebook_messages')->where('message_id',$message['id'])->first();
            if (!is_null($exist)) {
                break;
            }
            $insertData = [

                'from_id'      => $message['from']['id'],
                'from_name'    => $message['from']['name'],
                'from_email'   => isset($message['from']['email']) ? $message['from']['email'] : NULL,
                'to_id'        => $message['to']['data'][0]['id'],
                'to_name'      => $message['to']['data'][0]['name'],
                'to_email'     => isset($message['to']['data'][0]['email']) ? $message['to']['data'][0]['email'] : NULL,
                'message'      => $message['message'],
                'created_date' => strtotime($message['created_time']),
                'message_id'   => $message['id']
            ];
            DB::table('facebook_messages')->insert($insertData);
        }
        if ($nextMessages) {
            $this->recFeedMessages( $nextMessages );
        }else{
            return 1;
        }
    }

    public function recFeedMessages( $url )
    {
        $feed = file_get_contents($url);
        $feed = json_decode($feed,true);
        $data['messages'] = $feed;
        $this->insertFeedMessages( $data );
    }
    /*------------------------------------------------------------------------------------END MESSAGES--------------------------------------------------------------------*/
    /*------------------------------------------------------------------------------------POSTS--------------------------------------------------------------------*/

    public function getPagePosts( $url,$accessToken,$pageId )
    {
        if ($accessToken) {
            $response = $this->fb->get($url,$accessToken);
            $posts    = $response->getDecodedBody();
        }else{
            $response = file_get_contents($url);    
            $response = json_decode($response,true);
            $posts    = [];
            $posts['posts'] = $response; 
        }
        $end = $this->insertPagePosts($posts,$pageId);

        if ($end) {
            return 1;
        }
    }

    public function insertPagePosts( $posts,$pageId )
    {

        $nextPosts = false;
        if (isset($posts['posts']['paging']['next'])) {
            $nextPosts = $posts['posts']['paging']['next'];
        }
        if (!empty($posts['posts']['data'])) {
            foreach ($posts['posts']['data'] as $post) {
                $exist    = DB::table('facebook_posts')->where(['post_id'=>$post['id'],'page_id'=>$pageId])->first();
                if (!is_null($exist)) {
                    break;
                }
                $insertData = [
                    'post_id'      => $post['id'],
                    'page_id'      => $pageId,
                    'created_time' => strtotime($post['created_time'])
                ];
                DB::table('facebook_posts')->insert($insertData);
            }
        }else{
            // dd('if else 1');
            return 1;
        }
        if ($nextPosts) {
            $this->getPagePosts($nextPosts,false,$pageId);
        }else{
            // dd('if else 2');
            return 1;
        }

    }
    /*------------------------------------------------------------------------------------END POSTS--------------------------------------------------------------------*/

    /*------------------------------------------------------------------------------------COMMENTS--------------------------------------------------------------------*/

    public function getPostComments($accessToken,$pageId)
    {
        $posts = DB::table('facebook_posts')->where('page_id',$pageId)->get()->toArray();
        foreach ($posts as $post) {
            $this->setPostComments($post->post_id,$pageId,$accessToken);
        }
    }

    public function setPostComments( $postId,$pageId,$accessToken = false,$url = false )
    {
        if (!$url) {
            $response = $this->fb->get("$postId/comments",$accessToken);
            $comments = $response->getDecodedBody();
        }else{
            $comments = file_get_contents($url);
        }

        $this->insertPostCOmments($comments,$pageId,$postId);
    }

    public function insertPostCOmments( $comments,$pageId,$postId )
    {
        if (!empty($comments)) {
            if (isset($comments['data']) && !empty($comments['data']) ) {
                foreach ($comments['data'] as $comment) {
                    $exist    = DB::table('facebook_comments')->where(['post_id'=>$postId,'page_id'=>$pageId,'comment_id'=>$comment['id']])->first();
                    if (!is_null($exist)) {
                        break;
                    }
                    $insertData = [
                        'page_id'      => $pageId,
                        'post_id'      => $postId,
                        'comment_id'   => $comment['id'],
                        'from_id'      => $comment['from']['id'],
                        'created_date' => strtotime($comment['created_time']),
                    ];
                    DB::table('facebook_comments')->insert($insertData);
                }
            }else{
                return 1;
            }
            if (isset($comments['paging']) && isset($comments['paging']['next']) ) {
                $this->setPostComments($postId,$pageId,false,$comments['paging']['next']);
            }
        }else{
            return 1;
        }
    }
    /*------------------------------------------------------------------------------------END COMMENTS--------------------------------------------------------------------*/

    public function getPagePostsLikes( $fb,$pageId,$accessToken )
    {
        $pagePosts = DB::table('facebook_posts')->where('page_id',$pageId)->get()->toArray();
        foreach ($pagePosts as $post) {
            $postId = $post->post_id;

            try {
                // Returns a `FacebookFacebookResponse` object
                $response = $fb->get(
                    "/$postId/likes",
                    $accessToken
                );
            } catch(FacebookExceptionsFacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(FacebookExceptionsFacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $postLikes = $response->getDecodedBody();



            dd($postLikes);
        }
        dd($pagePosts);
    }

    public function getFbData(Request $request)
    {

        $user   = Session::get('user');
        if (!isset($user->facebook)) {
            echo json_encode(['success'=>false,'message'=>'Not Logged In.']);die;
        }

        $fbUser = $user->facebook;
        $userId = $user->facebook['id'];
        $pageId = $request->id;
        $type   = $request->type;
        $page   = DB::table('facebook_pages')->where(['user_id'=>$userId,'page_id'=>$pageId])->first();
        if (!empty($page)) {

            $userAccounts = $fbUser['accounts'];
            $fetched = true;
            foreach ($userAccounts as &$account) {
                if ($account['id'] == $pageId) {
                    if (!isset($account[$type])) {
                        $fetched = false;
                        $account[$type] = true;
                    }
                }else{
                    echo json_encode(['success'=>false,'message'=>'No page Id']);die;
                }
            }
            $fbUser['accounts'] = $userAccounts;
            $user->facebook = $fbUser;
            Session::put('user',$user);
            $accessToken = $page->page_access_token;
            if (!$fetched) {
                switch ($type) {
                    case 'messages':
                        $end = $this->getPageMessages("$pageId/conversations?fields=messages{created_time,message,from,to,id}",$accessToken);
                        break;
                    case 'posts':
                        $this->getPagePosts("/$pageId?fields=posts",$accessToken,$pageId);
                        $this->getPostComments($accessToken,$pageId);
                    default:
                        break;
                }
            }
            $end = true;
            if ($end) {
                switch ($type) {
                    case 'messages':
                        $response = DB::select("SELECT to_id AS recipient, from_id AS sender, created_date AS created_timestamp  FROM facebook_messages WHERE `to_id` = '110272667131181'  OR  from_id = '110272667131181'");
                        $response = array_reverse($response);
                        break;
                    case 'posts':
                        $response = [];
                        $response['posts']    = array_reverse(DB::table('facebook_posts')->get()->toArray());                     
                        $response['comments'] = array_reverse(DB::table('facebook_comments')->get()->toArray());                    
                    default:
                        break;
                }
                echo json_encode(['success'=>true,'data'=>$response,'pageId'=>$pageId]);
            }else{
                echo json_encode(['success'=>false,'messages'=>'Fb Error']);
            }
        }
    }
}
