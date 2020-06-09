<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\lib\twitteroauth\TwitterOAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;

class LoginController extends Controller
{
        private $key;
	private $secret;
    	private $token;
    	private $token_secret;
	private $callback;

	public function __construct()
    	{
    		$this->key = env('TWITTER_API_KEY', null);
    		$this->secret = env('TWITTER_API_SECRET', null);
    		$this->token = env('TWITTER_API_TOKEN', null);
    		$this->token_secret = env('TWITTER_API_TOKEN_SECRET', null);
    		$this->callback = env('TWITTER_API_CALLBACK', null);
    	}	

	public function index()
	{
		if(Session::has('user')) {
			return redirect('home');
		}else {
			return view('login');
		}
	}

	public function toTwitter()
	{
		$connection = new TwitterOAuth($this->key, $this->secret);
		$request_token = $connection->getRequestToken($this->callback);
		Storage::disk('local')->put(md5($_SERVER['REMOTE_ADDR']).'.txt', $request_token['oauth_token'].';'.$request_token['oauth_token_secret']);
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
		redirect()->to($twitter_url)->send();
	}

	public function getUserIpAddr(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

	public function twAccessToken(Request $request)
	{
		$contents = Storage::get(md5($_SERVER['REMOTE_ADDR']).'.txt');
		$contents = explode(';', $contents);
		Storage::delete(md5($_SERVER['REMOTE_ADDR']).'.txt');
		$connection   = new TwitterOAuth($this->key, $this->secret, $contents[0], $contents[1]);
	    $access_token = $connection->getAccessToken($request->input('oauth_verifier'));

	    $user_info  = $connection->get('account/verify_credentials', array('include_email' => 'true'));

	    $exist = DB::table('users')->where(['userId' => $user_info->id], ['provider' => 'twitter'])->first();
	    $user = [
				'user_name' => $user_info->name,
				'userId' => $user_info->id,
				'access_token' => $access_token['oauth_token'],
				'twitter_oauth' => NULL,
				'created' => time(),
				'modified' => time(),
				'picture' => $user_info->profile_image_url_https,
				'provider' => 'twitter',
				'email' => NULL,
				'screen_name' => $user_info->screen_name,
				'oauth_token_secret' => $access_token['oauth_token_secret']
		];

		Session::put('user', (object)$user);
		Session::put('login', 'true');
		Session::forget('request_token');

	    if (!$exist) {
	    	$res = DB::table('users')->insert($user);
	    } else {
	    	unset($user['created']);
	    	DB::table('users')
                ->where(['userId' => $user_info->id], ['provider' => 'twitter'])
                ->update($user);
	    }

	    return redirect('home');
	}

	public function logout()
	{
		Session::forget('user');
		return redirect('');
	}
}
