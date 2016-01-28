<?php

function index() {
	exit;
}

function posts() {
	global $dbh;
	global $template;
	global $path;
	
	$api_key = $path[2];
 	$accountId = $_GET['id'];

	if ($api_key != API_KEY) {
		echo "Incorrect API key";
		exit;
	}

	$limit = '';
	$offset = '';

	if (!empty($_GET['limit'])) {
		$limit = ' limit '.$_GET['limit'];
	}

	if (!empty($_GET['offset'])) {
		$offset = ' offset '.$_GET['offset'];
	}

	if (!empty($_GET['orderby'])) {
		$orderby = ' order by '.$_GET['orderby'];
	} else {
		$orderby = 'order by `time` desc';
	}

	$query = $dbh->prepare("select *, inbox.id as aid from inbox left join accounts on accounts.id = inbox.accountid where visible = 1 and approved = 1 and accountid IN (".$accountId.")".$orderby.$limit.$offset);
	$query->execute(array());
	$comments = $query->fetchAll();

	foreach ($comments as &$comment) {

		if (is_file(BASE_DIR.'/data/'.$comment['user_avatar'])) {
			$comment['user_avatar'] = BASE_URL.'data/'.$comment['user_avatar'];
		}


	}



	$comments = json_encode($comments);
	echo $comments;
	exit;
}

function postscount() {
	global $dbh;
	global $template;
	global $path;
	
	$api_key = $path[2];
 	$accountId = $_GET['id'];

	if ($api_key != API_KEY) {
		echo "Incorrect API key";
		exit;
	}

	$limit = '';
	$offset = '';

	if (!empty($_GET['limit'])) {
		$limit = ' limit '.$_GET['limit'];
	}

	if (!empty($_GET['offset'])) {
		$offset = ' offset '.$_GET['offset'];
	}

	$query = $dbh->prepare("select count(*) as cnt from inbox left join accounts on accounts.id = inbox.accountid where visible = 1 and approved = 1 and accountid IN (".$accountId.") order by `time` desc".$limit.$offset);
	$query->execute(array());
	$comments = $query->fetch();

	$comments = json_encode($comments);
	echo $comments;
	exit;
}

function resize() {
	$image = $_GET['image'];
	$height = $_GET['height'];
	$width = $_GET['width'];

	$file = md5($image.$height.$width);

	$ext = parse_url($image);
	$ext = pathinfo($ext['path'], PATHINFO_EXTENSION);

	if (!file_exists(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $file.".".$ext)) {	
		$output = resizeImage(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $file.".".$ext,file_get_contents($image),$width,$height,1,'file');
	}

	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: ".BASE_URL."cache/".$file.".".$ext."\r\n");
	exit;
}

function addpost() {
	global $dbh;
	global $template;
	global $path;
	
	$api_key = $path[2];
 	$accountId = $_GET['id'];

	if ($api_key != API_KEY) {
		echo "Incorrect API key";
		exit;
	}

	$uuid = md5($_GET['comment'].$_GET['avatar'].$_GET['name'].$_GET['description']);

	if(filter_var($_GET['avatar'], FILTER_VALIDATE_EMAIL)) {
		$_GET['avatar'] = 'http://www.gravatar.com/avatar/'.md5($_GET['avatar']).'?d=mm';

		if (!is_file(BASE_DIR.'/data/'.$uuid.".jpg")) {
			file_put_contents(BASE_DIR.'/data/'.$uuid.".jpg", file_get_contents($_GET['avatar']));
		}

		$_GET['avatar'] = $uuid.".jpg";
	}

	$query = $dbh->prepare("insert ignore into inbox (accountid,id,type,user_name,user_description,user_avatar,user_handle,message,time) values (?,?,?,?,?,?,?,?,?)");
	$query->execute(array($accountId,$uuid,'form',$_GET['name'],$_GET['description'],$_GET['avatar'],'',$_GET['comment'],time()));

	echo "1";
	exit;
}