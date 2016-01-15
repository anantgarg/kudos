<?php

ini_set('max_execution_time', 300); 
set_time_limit(0);

function getcomments($accountId) {
	global $dbh;

	$query = $dbh->prepare("select accounts.type, accounts.data1, accounts.data2, accounts.data3 from accounts where id = ?");
	$query->execute(array($accountId));
	$post = $query->fetch();

	$queue = array();
	$error = '';

	if ($post['type'] == 'facebook') {
		try {

			$params = array(
			);

			$facebook = new Facebook(array('appId'  => FB_APPID,'secret' => FB_APPSECRET));
			
			$comments = $facebook->api('/'.$post['data1'].'/tagged', 'GET', $params);

			foreach ($comments['data'] as $comment) {
				
				$avatar = $facebook->api('/'.$comment['from']['id'].'/picture', 'GET', array('redirect' => false));

				$q = array();
				$q['type'] = 'facebook';
				$q['id'] = $comment['id'];
				$q['user_name'] = $comment['from']['name'];
				$q['user_description'] = '';
				$q['user_avatar'] = $avatar['data']['url'];
				$q['user_handle'] = $comment['from']['id'];
				$q['message'] = $comment['message'];
				$q['time'] = strtotime($comment['created_time']);
				$q['accountid'] = $accountId;
				
				if (!is_file(BASE_DIR.'/data/'.$q['id'].".jpg")) {
					file_put_contents(BASE_DIR.'/data/'.$q['id'].".jpg", file_get_contents($q['user_avatar']));					
				}

				$q['user_avatar'] = $q['id'].".jpg";

				$queue[] = $q;
 
			}
			

		} catch(Exception $e) {
		   $error = print_r($e,true);
		}

	}

	if ($post['type'] == 'zendesk') {
	
		try {

		$comments = zdapi("/satisfaction_ratings.json?score=good_with_comment", null, "GET", $post['data3'],$post['data1'], $post['data2']);

		foreach ($comments->satisfaction_ratings as $comment) {

			$user = zdapi("/users/".$comment->requester_id.".json", null, "GET", $post['data3'],$post['data1'], $post['data2']);

			$q = array();
			$q['type'] = 'zendesk';
			$q['id'] = $comment->ticket_id;
			$q['user_name'] = $user->user->name;
			$q['user_description'] = '';
			$q['user_avatar'] = $user->user->email;
			$q['user_handle'] = $comment->requester_id;
			$q['message'] = $comment->comment;
			$q['time']= strtotime($comment->created_at);
			$q['accountid'] = $accountId;
		
			$queue[] = $q;

		}

		} catch(Exception $e) {
		   $error = print_r($e,true);
		}

	}

	if ($post['type'] == 'twitter') {
		
		try {

		$params = array(
			'count' => 200
		);
					
		$twitter = new TwitterOAuth(TWITTER_APIKEY, TWITTER_APISECRET, $post['data2'], $post['data3']);
		$comments = $twitter->get('statuses/mentions_timeline',$params);

		foreach ($comments as $comment) {
			
			$q = array();
			$q['type'] = 'twitter';
			$q['id'] = $comment->id_str;
			$q['user_name'] = $comment->user->name;
			$q['user_description'] = $comment->user->description;
			$q['user_avatar'] = str_replace('normal','bigger',$comment->user->profile_image_url);
			$q['user_handle'] = $comment->user->screen_name;
			$q['message'] = $comment->text;
			$q['time']= strtotime($comment->created_at);
			$q['accountid'] = $accountId;

			if (!is_file(BASE_DIR.'/data/'.$q['id'].".jpg")) {
				file_put_contents(BASE_DIR.'/data/'.$q['id'].".jpg", file_get_contents($q['user_avatar']));
			}

			$q['user_avatar'] = $q['id'].".jpg";
		
			if (substr($q['message'], 0, 3) != 'RT ') {
				$queue[] = $q;
			}

		}

		} catch(Exception $e) {
		   $error = print_r($e,true);
		}

	}

	return $queue;

}

function run() {
	global $dbh;

	$query = $dbh->prepare("select accounts.id, accounts.type, accounts.data1, accounts.data2, accounts.data3 from accounts where active = 1");
	$query->execute(array());
	$accounts = $query->fetchAll();

	$comments = array();

	foreach ($accounts as $account) {
		$c = getcomments($account['id']);
		$comments = array_merge($comments,$c);
	}

	foreach ($comments as $comment) {

		$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
		$query->execute(array($comment['accountid'],$comment['id'],$comment['type'],$comment['user_name'],$comment['user_description'],$comment['user_avatar'],$comment['user_handle'],$comment['message'],$comment['time']));
 
	}

}

run();
echo "Done";

exit;