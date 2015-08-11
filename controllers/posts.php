<?php

function index() {
	header("Location: ".BASE_URL."posts/live");
	exit;
}

function pre() {
	global $template;
	global $dbh;
	global $path;

	$current = 0;
	
	if (!empty($path[2])) {
		$current = intval($path[2]);
	}

	if ($_SESSION['user']['type'] != 1) {
		$query = $dbh->prepare("select accounts.* from accounts join users_accounts on accounts.id = users_accounts.accountid where users_accounts.userid = ? and accounts.active = 1");
		$query->execute(array($_SESSION['user']['loggedin']));
		$accounts = $query->fetchAll();
	} else {
		$query = $dbh->prepare("select * from accounts where accounts.active = 1");
		$query->execute(array());
		$accounts = $query->fetchAll();
	}

	$currentpermission = 0;
	$currenttype = '';

	foreach ($accounts as $no => $account) {
		
		// If no account selected, redirect to first account
		if (empty($current)) {
			header("Location: ".BASE_URL."posts/live/".$account['id']);
			exit;
		}

		if ($account['type'] == 'facebook') {
			$image = 'https://graph.facebook.com/'.$account['data1'].'/picture';
			$accounts[$no]['image'] = $image;
		}

		if ($account['type'] == 'twitter') {
			$image = $account['data4'];
			$accounts[$no]['image'] = $image;
		}

		if ($account['type'] == 'zendesk') {
			$image = BASE_URL.'assets/img/zendesk.png';
			$accounts[$no]['image'] = $image;
		}

		if ($account['type'] == 'custom') {
			$image = BASE_URL.'assets/img/custom.png';
			$accounts[$no]['image'] = $image;
		}

		if ($current == $account['id']) {
			$accounts[$no]['current'] = 1;
			$currentpermission = 1;
			$currenttype = $account['type'];
		}
	}

	// If no account found, give a friendly error message
	if (empty($current)) {
		if ($_SESSION['user']['type'] == 1) {
			header("Location: ".BASE_URL."connect");
			exit;
		} else {
			header("Location: ".BASE_URL."oops/no-accounts");
			exit;
		}
	}

	// If no permission
	if (empty($currentpermission)) {
		header("Location: ".BASE_URL."oops/permissions");
		exit;
	}

	$template->set('current',$current);
	$template->set('currenttype',$currenttype);
	$template->set('accounts',$accounts);

}


function live() {
	global $dbh;
	global $template;
	global $path;
	
 	$accountId = intval($path[2]);

	$query = $dbh->prepare("select * from inbox where visible = 1 and approved = 1 and accountid = ? order by id desc");
	$query->execute(array($accountId));
	$comments = $query->fetchAll();

	foreach ($comments as &$comment) {

		if(filter_var($comment['user_avatar'], FILTER_VALIDATE_EMAIL)) {
			$comment['user_avatar'] = '//www.gravatar.com/avatar/'.md5($comment['user_avatar']).'?d=mm';
		}

	}

	$template->set('comments',$comments);

}


function inbox() {
	global $dbh;
	global $template;
	global $path;
	
 	$accountId = intval($path[2]);

	$query = $dbh->prepare("select * from inbox where visible = 1 and approved = 0 and accountid = ? order by id desc limit 100");
	$query->execute(array($accountId));
	$comments = $query->fetchAll();

	foreach ($comments as &$comment) {

		if(filter_var($comment['user_avatar'], FILTER_VALIDATE_EMAIL)) {
			$comment['user_avatar'] = '//www.gravatar.com/avatar/'.md5($comment['user_avatar']).'?d=mm';
		}

	}

	$template->set('comments',$comments);
	
}

function makelive() {
	global $dbh;
	global $template;
	global $path;
	
	$accountId = intval($path[2]);

	if (!empty($path[3])) {
		$postId = $path[3];		
	} else {
		$_SESSION['notification']['type'] = 'error';
		$_SESSION['notification']['message'] = '<b>Oops!</b> Something went wrong.';
		header("Location: ".$_SERVER['HTTP_REFERER']);
		exit;
	}

	$query = $dbh->prepare("update inbox set visible = 1, approved = 1 where accountid = ? and id = ? limit 1");
	$query->execute(array($accountId, $postId));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		exit;
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

function makehide() {
	global $dbh;
	global $template;
	global $path;
	
	$accountId = intval($path[2]);

	if (!empty($path[3])) {
		$postId = $path[3];		
	} else {
		$_SESSION['notification']['type'] = 'error';
		$_SESSION['notification']['message'] = '<b>Oops!</b> Something went wrong.';
		header("Location: ".$_SERVER['HTTP_REFERER']);
		exit;
	}

	$query = $dbh->prepare("update inbox set visible = 0 where accountid = ? and id = ? limit 1");
	$query->execute(array($accountId, $postId));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		exit;
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;

}

function moveinbox() {
	global $dbh;
	global $template;
	global $path;
	
	$accountId = intval($path[2]);

	if (!empty($path[3])) {
		$postId = $path[3];		
	} else {
		$_SESSION['notification']['type'] = 'error';
		$_SESSION['notification']['message'] = '<b>Oops!</b> Something went wrong.';
		header("Location: ".$_SERVER['HTTP_REFERER']);
		exit;
	}

	$query = $dbh->prepare("update inbox set visible = 1, approved = 0 where accountid = ? and id = ? limit 1");
	$query->execute(array($accountId, $postId));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		exit;
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;

}

function edit() {
	global $dbh;
	global $template;
	global $path;


	$accountId = intval($path[2]);

	if (!empty($path[3])) {
		$postId = $path[3];		
	} else {
		$_SESSION['notification']['type'] = 'error';
		$_SESSION['notification']['message'] = '<b>Oops!</b> Something went wrong.';
		header("Location: ".$_SERVER['HTTP_REFERER']);
		exit;
	}

	$query = $dbh->prepare("update inbox set message = ? where accountid = ? and id = ? limit 1");
	$query->execute(array($_POST['comment'],$accountId, $postId));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		exit;
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;

}

function add() {
	global $dbh;
	global $template;
	global $path;
	
 	$accountId = intval($path[2]);
	$template->set('accountid',$accountId);
}

function addnow() {
	global $dbh;
	global $template;
	global $path;

	$accountId = intval($path[2]);

	$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
	$query->execute(array($accountId,uniqid(),'custom',$_POST['name'],$_POST['description'],$_POST['avatar'],'',$_POST['comment'],time()));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		exit;
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}