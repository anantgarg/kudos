<?php

function index() {
	header("Location: ".BASE_URL."posts/live");
	exit;
}

function pre() {
	global $template;
	global $dbh;
	global $path;
	global $integrations;

	$current = 0;

	if (!empty($path[2])) {
		$current = intval($path[2]);
	}

	if ($_SESSION['user']['type'] != 1) {
		$query = $dbh->prepare("select accounts.* from accounts join users_accounts on accounts.id = users_accounts.accountid where users_accounts.userid = ? and accounts.active = 1 order by name asc");
		$query->execute(array($_SESSION['user']['loggedin']));
		$accounts = $query->fetchAll();
	} else {
		$query = $dbh->prepare("select * from accounts where accounts.active = 1 order by name asc");
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

	$template->set('integrations',$integrations);
	$template->set('current',$current);
	$template->set('currenttype',$currenttype);
	$template->set('accounts',$accounts);

}


function live() {
	global $dbh;
	global $template;
	global $path;

 	$accountId = intval($path[2]);

	$query = $dbh->prepare("select * from inbox where visible = 1 and approved = 1 and accountid = ? order by `time` desc");
	$query->execute(array($accountId));
	$comments = $query->fetchAll();

	foreach ($comments as &$comment) {
		$comment['user_avatar'] = strstr($comment['user_avatar'], '?', true) ?: $comment['user_avatar'];

		if (is_file(BASE_DIR.'/data/'.$comment['user_avatar'])) {
			$comment['user_avatar'] = BASE_URL.'data/'.$comment['user_avatar'];
		}


	}

	$template->set('comments',$comments);

}


function inbox() {
	global $dbh;
	global $template;
	global $path;

 	$accountId = intval($path[2]);

	$query = $dbh->prepare("select * from inbox where visible = 1 and approved = 0 and accountid = ? order by `time` desc limit 100");
	$query->execute(array($accountId));
	$comments = $query->fetchAll();

	foreach ($comments as &$comment) {

		$comment['user_avatar'] = strstr($comment['user_avatar'], '?', true) ?: $comment['user_avatar'];

		if (is_file(BASE_DIR.'/data/'.$comment['user_avatar'])) {
			$comment['user_avatar'] = BASE_URL.'data/'.$comment['user_avatar'];
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

function regenerateavatar() {
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

	$image = '';
	$random = json_decode(file_get_contents("http://uifaces.com/api/v1/random"));

	if (!empty($random->image_urls->epic)) {
		$avatar = $random->image_urls->epic;
		file_put_contents(BASE_DIR.'/data/'.$postId.".jpg", file_get_contents($avatar));
		$avatar = $postId.".jpg?v=".time();
	}

	$query = $dbh->prepare("update inbox set user_avatar = ? where accountid = ? and id = ? limit 1");
	$query->execute(array($avatar,$accountId, $postId));

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		echo BASE_URL.'data/'.$avatar;
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

	$query = $dbh->prepare("select * from accounts where id = ?");
	$query->execute(array($accountId));
	$account = $query->fetch();

	$template->set('acc',$account);
	$template->set('accountid',$accountId);
}

function addnow() {
	global $dbh;
	global $template;
	global $path;

	$accountId = intval($path[2]);

	$query = $dbh->prepare("select * from accounts where id = ?");
	$query->execute(array($accountId));
	$account = $query->fetch();

	if ($account['type'] == 'appstore') {

		if (!empty($_POST['url'])) {
			if (strpos($_POST['url'],'apple') !== false) {

				$id = 0;

				if (strpos($_POST['url'],'/id') !== false) {

					$location = strpos($_POST['url'],'/id');
					$string = substr($_POST['url'], $location+3);

					preg_match('/(\d+)/', $string, $match);

					if (intval($match[0])) {
						$id = $match[0];
					}
				}

				if (!empty($id)) {
					$content = file_get_contents("https://itunes.apple.com/lookup?id=".$id);
					$json = json_decode($content, true);

					$logo = $json['results'][0]['artworkUrl100'];
					$name = $json['results'][0]['trackName'];
					$seller = $json['results'][0]['sellerName'];
					$url = $json['results'][0]['trackViewUrl'];
					$description = $json['results'][0]['description'];

					file_put_contents(BASE_DIR.'/data/'.'itunes_'.$id.".jpg", file_get_contents($logo));

					$logo = 'itunes_'.$id.".jpg";

					if (!empty($logo) && !empty($name) && !empty($seller) && !empty($url)) {
						$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
						$query->execute(array($accountId,'itunes_'.$id,'appstore',$name,$url,$logo,$seller,$description,time()));

					}

				}
			}

			if (strpos($_POST['url'],'google') !== false) {

				$id = 0;

				$parts = parse_url($_POST['url']);
				parse_str($parts['query'], $query);
				$id = $query['id'];

				$content = file_get_contents($_POST['url']);

				$doc = new DOMDocument();
				libxml_use_internal_errors(true);
				$doc->loadHTML($content);
				$xpath = new DOMXPath($doc);

				$nodes = $xpath->query("//img[@class='cover-image']");
				$logo = $nodes->item(0)->getAttribute('src');

				$nodes = $xpath->query("//div[@class='id-app-title']");
				$name = $nodes->item(0)->nodeValue;

				$nodes = $xpath->query("//div[@class='content']");
				$seller = $nodes->item(6)->nodeValue;

				$url = $_POST['url'];
				$description = '';

				file_put_contents(BASE_DIR.'/data/'.'google_'.$id.".jpg", file_get_contents('http:'.$logo));
				$logo = 'google_'.$id.".jpg";



				if (!empty($logo) && !empty($name) && !empty($seller) && !empty($url)) {
					$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
					$query->execute(array($accountId,'google_'.$id,'appstore',$name,$url,$logo,$seller,$description,time()));
				}

			}
		}
	}

	if ($account['type'] == 'form') {
		$uuid = md5($_POST['comment'].$_POST['avatar'].$_POST['name'].$_POST['description']);

		if(filter_var($_POST['avatar'], FILTER_VALIDATE_EMAIL)) {
			$_POST['avatar'] = 'http://www.gravatar.com/avatar/'.md5($_POST['avatar']).'?d=mm';

			if (!is_file(BASE_DIR.'/data/'.$uuid.".jpg")) {
				file_put_contents(BASE_DIR.'/data/'.$uuid.".jpg", file_get_contents($_POST['avatar']));
			}

			$_POST['avatar'] = $uuid.".jpg";
		}

		$id = uniqid();
		$imageFileType = pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION);
		$target_file = BASE_DIR."/data/".$id.".".$imageFileType;
		$file = $id.".".$imageFileType;

		if (!empty($_FILES["image"]["tmp_name"])) {
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check !== false) {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					$_POST['avatar'] = $file;
				}
			}
		}
		$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
		$query->execute(array($accountId,$uuid,'form',$_POST['name'],$_POST['description'],$_POST['avatar'],'',$_POST['comment'],time()));
	}

	if ($account['type'] == 'showcase') {
		$id = uniqid();
		$imageFileType = pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION);
		$target_file = BASE_DIR."/data/".$id.".".$imageFileType;
		$file = $id.".".$imageFileType;

		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if($check !== false) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time,rating,category) values (?,?,?,?,?,?,?,?,?,?,?)");
				$query->execute(array($accountId,$id,'form',$_POST['name'],$_POST['description'],$file,'',$_POST['comment'],time(),$_POST['rating'],$_POST['category']));
			}
		}

	}

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		exit;
	}

	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}
