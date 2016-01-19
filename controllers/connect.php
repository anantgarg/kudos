<?php

ini_set('max_execution_time', 300); 
set_time_limit(0);


checkPermission(1); // Owners Only

function index() {
	global $dbh;
	global $template;
	global $integrations;

	$query = $dbh->prepare("select * from accounts where active = 1 order by name asc");
	$query->execute(array());
	$accounts = $query->fetchAll();

	$template->set('integrations',$integrations);
	$template->set('accounts',$accounts);
}

function facebook() {

	global $template;
	
	$facebook = new Facebook(array('appId'  => FB_APPID,'secret' => FB_APPSECRET));	
	$user = $facebook->getUser();

	if ($user) {
	  try {

		$pages = $facebook->api('/me/accounts');
		$template->set('pages',$pages);

		$permissions = $facebook->api("/me/permissions");
	
		$publish_actions = 0;
		$manage_pages = 0;

		foreach ($permissions['data'] as $permission) {
			if ($permission['permission'] == 'publish_actions') {
				$publish_actions = 1;
			}
			if ($permission['permission'] == 'manage_pages') {
				$manage_pages = 1;
			}
		}

		if ($publish_actions == 0 || $manage_pages == 0) {
			throw new Exception("Oops");
		}


	  } catch (Exception $e) {

		$url = $facebook->getLoginUrl(array("scope" => "publish_actions,manage_pages"));
		header("Location: ".$url);
		exit;
	  }

	} else {
		$url = $facebook->getLoginUrl(array("scope" => "publish_actions,manage_pages"));
		header("Location: ".$url);
		exit;
	}
	  
}

function twitter() {
	global $template;
	
	$twitter = new TwitterOAuth(TWITTER_APIKEY, TWITTER_APISECRET);
	$request_token = $twitter->getRequestToken(BASE_URL."connect/twitter-callback");
	
	$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	 
	switch ($twitter->http_code) {
	  case 200:
		/* Build authorize URL and redirect user to Twitter. */
		$url = $twitter->getAuthorizeURL($token);
		header('Location: ' . $url); 
		exit;
	  default:
		$_SESSION['notification']['type'] = 'error';
		$_SESSION['notification']['message'] = 'Unable to connect to Twitter. Please try again later.';
		header("Location: ".BASE_URL."connect");
		exit;
	}

}


function twittercallback() {
	
	$twitter = new TwitterOAuth(TWITTER_APIKEY, TWITTER_APISECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);

	$account = $twitter->get('account/verify_credentials');

	header('Location: '.BASE_URL.'connect/add/twitter/'.base64_encode($token['user_id']).'/'.base64_encode($token['screen_name']).'/'.base64_encode($token['oauth_token']).'/'.base64_encode($token['oauth_token_secret']).'/'.base64_encode($account->profile_image_url_https)); 
	exit;


}

function zendesk() {

}

function import() {
	global $path;
	global $template;

	$accountId = $path[2];
	$template->set('accountId',$accountId);
}

function importdata() {
	global $path;
	global $template;
	global $dbh;

	$accountId = $path[2];
	eval($_POST['data']);

	if (!empty($testimonials)) {
		foreach ($testimonials as $t) {

			if (empty($t['email'])) { $t['email'] = ''; }

			$comment = $t['testimonial'];
			$avatar = $t['email'];
			$name = $t['author'];
			$description = $t['company'];
			$date = strtotime(str_replace('/', '/',$t['date']));

			$uuid = md5($comment.$avatar.$name.$description);

			$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
			$query->execute(array($accountId,$uuid,'form',$name,$description,$avatar,'',$comment,$date));
		}
	}


	$_SESSION['notification']['type'] = 'success';
	$_SESSION['notification']['message'] = 'Data has been successfully imported.';
	header("Location: ".BASE_URL."posts/live/".$accountId);
	exit;

}

function add() {
	global $dbh;
	global $path;

	$type = $path[2];

	if ($type == 'facebook') {

		$query = $dbh->prepare("select * from accounts where type = ? and data1 = ?");
		$query->execute(array('facebook',base64_decode($path[3])));
		$existing = $query->fetch();

		if ($existing['id'] > 0) {
			$sql = "update accounts set active = ?, name = ?, data2 = ? where type = ? and data1 = ?";
			$query = $dbh->prepare($sql);
			$query->execute(array(1,base64_decode($path[4]),base64_decode($path[5]),'facebook',base64_decode($path[3])));
		} else {
			$sql = "insert into accounts (type,name,data1,data2,active) VALUES (?,?,?,?,?)";
			$query = $dbh->prepare($sql);
			$query->execute(array('facebook',base64_decode($path[4]),base64_decode($path[3]),base64_decode($path[5]),1));
		}
	}

	if ($type == 'twitter') {

		$query = $dbh->prepare("select * from accounts where type = ? and data1 = ?");
		$query->execute(array('twitter',base64_decode($path[3])));
		$existing = $query->fetch();

		if ($existing['id'] > 0) {
			$sql = "update accounts set active = ?, name = ?, data2 = ?, data3 = ?, data4 = ? where type = ? and data1 = ?";
			$query = $dbh->prepare($sql);
			$query->execute(array(1,base64_decode($path[4]),base64_decode($path[5]),base64_decode($path[6]),base64_decode($path[7]),'twitter',base64_decode($path[3])));
		} else {

			$sql = "insert into accounts (type,name,data1,data2,data3,data4,active) VALUES (?,?,?,?,?,?,?)";
			$query = $dbh->prepare($sql);
			$query->execute(array('twitter',base64_decode($path[4]),base64_decode($path[3]),base64_decode($path[5]),base64_decode($path[6]),base64_decode($path[7]),1));

		}

	}

	if ($type == 'zendesk') {

		$username = $_POST['username'];
		$apikey = $_POST['apikey'];
		$url = $_POST['url'];
		$name = $_POST['name'];

		$url = rtrim($url, '/');
		$url = str_replace('https','http',$url);
		$url = str_replace('http','https',$url);
		
		$url .= '/api/v2';

		if (substr( $url, 0, 8 ) === "https://") {		} else {
			$url = 'https://'.$url;
		}

		$query = $dbh->prepare("select * from accounts where type = ? and data1 = ?");
		$query->execute(array('zendesk',$url));
		$existing = $query->fetch();

		if ($existing['id'] > 0) {
			$sql = "update accounts set active = ?, name = ?, data2 = ?, data3 = ? where type = ? and data1 = ?";
			$query = $dbh->prepare($sql);
			$query->execute(array(1,$name,$username,$apikey,'zendesk',$url));
		} else {

			$sql = "insert into accounts (type,name,data1,data2,data3,active) VALUES (?,?,?,?,?,?)";
			$query = $dbh->prepare($sql);
			$query->execute(array('zendesk',$name,$url,$username,$apikey,1));

		}

	}

	if ($type == 'appstore') {

		$name = $_POST['name'];

		$sql = "insert into accounts (type,name,active) VALUES (?,?,?)";
		$query = $dbh->prepare($sql);
		$query->execute(array('appstore',$name,1));

	}
	
	if ($type == 'form') {

		$name = $_POST['name'];

		$sql = "insert into accounts (type,name,active) VALUES (?,?,?)";
		$query = $dbh->prepare($sql);
		$query->execute(array('form',$name,1));

	}
		
	if ($type == 'showcase') {

		$name = $_POST['name'];

		$sql = "insert into accounts (type,name,active) VALUES (?,?,?)";
		$query = $dbh->prepare($sql);
		$query->execute(array('showcase',$name,1));

	}

	$_SESSION['notification']['type'] = 'success';
	$_SESSION['notification']['message'] = 'Account has been successfully added.';

	header("Location: ".BASE_URL."connect");
	exit;

}

function remove() {
	global $dbh;
	global $path;

	$accountId = intval($path[2]);

	$query = $dbh->prepare("update accounts set active = ? where id = ?");
	$query->execute(array(0,$accountId));

	$_SESSION['notification']['type'] = 'success';
	$_SESSION['notification']['message'] = 'Account has been successfully removed.';

	header("Location: ".BASE_URL."connect");
	exit;
}