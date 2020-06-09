<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\lib\twitteroauth\TwitterOAuth;
use Session;
use DB;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphNodeFactory;
class HomeController extends Controller
{
    // FB 
    private $appId = '1895853557226516';
    private $appSecret = '2e45e2b6e317018d608050b10b848a7a';
    private $fbCallback = 'https://inbox.ki.social/fbRedirect';
    private $fb;
    // Twitter
    private $twitterApi;
    private $key;
    private $secret;
    private $token;
    private $token_secret;
    private $callback;
    private $posts;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct()
    {
        set_time_limit(0);
        ini_set('memeory_limit', '-1');
        $this->key = env('TWITTER_API_KEY', null);
        $this->secret = env('TWITTER_API_SECRET', null);
        $this->token = env('TWITTER_API_TOKEN', null);
        $this->token_secret = env('TWITTER_API_TOKEN_SECRET', null);
        $this->callback = env('TWITTER_API_CALLBACK', null);
    }

    public function index()
    {

        $user = Session::get('user');
	    $fbLoginUrl = $this->setFbLOginUrl();
        if(Session::get('login')) {
            $this->useranalytics();
            Session::forget('login');
        }
        return view('home',['fbLoginUrl'=>$fbLoginUrl]);
    }

    public function useranalytics()
    {
        $this->twitterApi = new TwitterOAuth($this->key, $this->secret, Session::get('user')->access_token, Session::get('user')->oauth_token_secret);

        $res  = $this->twitterApi->get('direct_messages/events/list');

        return $this->checkNext($res);
    }

    public function checkNext($res)
    {
        if (isset($res->events)) {
            foreach ($res->events as $value) {
                $message = [
                    'messageId' => $value->id,
                    'message' => $value->message_create->message_data->text,
                    'recipient' => $value->message_create->target->recipient_id,
                    'sender' => $value->message_create->sender_id,
                    'userId' => Session::get('user')->userId,
                    'created_timestamp' => $value->created_timestamp
                ];

                if($this->addMessage($message)) {
                    return redirect('home');
                }
            }

            if(isset($res->next_cursor)) {
                $res = $this->twitterApi->get('direct_messages/events/list', ['cursor' => $res->next_cursor]);
                $this->checkNext($res);
            }else {
                return redirect('/home');
            }
        }else {
            return redirect('home');
        }
    }

    public function setFbLOginUrl()
    {
        $fb = new Facebook([
          'app_id' => $this->appId,
          'app_secret' => $this->appSecret,
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; 
        return $helper->getLoginUrl($this->fbCallback, $permissions);
    }
    
    public function addMessage($message)
    {
        $data = DB::table('twitter_messages')->where(['messageId' => $message['messageId']])->first();
        if (!$data) {
            DB::table('twitter_messages')->insert($message);
        } else {
            return false;
        }
    }

    public function get_twitter_data(Request $req) {
        if ($req->input('type') == 'messages') {
            $data = DB::table('twitter_messages')
                ->select('recipient', 'sender', 'created_timestamp', 'userId')
                ->where(['userId' => Session::get('user')->userId])
                ->get()
                ->toArray();

            $data = array_reverse($data);
            echo json_encode(['userId' => Session::get('user')->userId, 'data' => $data, 'type' => 'message']);
        }else {
            $this->twitterApi = new TwitterOAuth($this->key, $this->secret, Session::get('user')->access_token, Session::get('user')->oauth_token_secret);

            if (!isset(Session::get('user')->twPostStatus)) {
                $this->get_pmr('statuses/user_timeline', array('user_id' => Session::get('user')->userId), 'tw_posts');
                $this->get_pmr('statuses/retweets_of_me', array('count' => 100), 'tw_retweets');
                $this->get_pmr('statuses/mentions_timeline', array('count' => 200), 'tw_mentions');

                $session = Session::get('user');
                $session->twPostStatus = true;
                Session::put('user', $session);
            }

            $data = DB::table('tw_posts')
                        ->select('created_at')
                        ->where(['userId' => Session::get('user')->userId])
                        ->get()
                        ->toArray();
            $this->posts['posts'] = $data;
            $data = DB::table('tw_retweets')
                        ->select('created_at')
                        ->where(['userId' => Session::get('user')->userId])
                        ->get()
                        ->toArray();
            $this->posts['retweets'] = $data;
            $data = DB::table('tw_mentions')
                        ->select('created_at')
                        ->where(['userId' => Session::get('user')->userId])
                        ->get()
                        ->toArray();
            $this->posts['mentions'] = $data;
            $this->posts['userId'] = Session::get('user')->userId;
            echo json_encode($this->posts);
        }
    }

    public function get_pmr($req_url, $params, $table)
    {
        $res    = $this->twitterApi->get($req_url, $params);
        $status = $this->insertData($table, $res);

        if($res) {
            $max_id = $res[count($res) - 1]->id;
        }else {
            return true;
        }if($status) {
            return true;
        }
        sleep(10);
        $params['max_id'] = $max_id;
        $this->get_pmr($req_url, $params, $table);
    }

    public function insertData($table, $res)
    {
        $key = ($table == 'tw_posts') ? 'postId' : (($table == 'tw_retweets') ? 'rtId' : 'mentionId');
        $last = DB::table($table)
                    ->select('created_at')
                    ->where(['userId' => Session::get('user')->userId])
                    ->first();
        $last = $last ? $last->created_at : $last;
        foreach ($res as $value) {
            if ((int)$last < (int)strtotime($value->created_at)) {
                $posts = [
                    $key => $value->id,
                    'text' => $value->text,
                    'userId' => Session::get('user')->userId,
                    'created_at' => strtotime($value->created_at)
                ];
                DB::table($table)->insert($posts);
            }else {
                return true;
            }
        }
    }



}
