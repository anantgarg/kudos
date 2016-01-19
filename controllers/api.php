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

	if (!empty($_GET['limit'])) {
		$limit = 'limit '.$_GET['limit'];
	}

	$query = $dbh->prepare("select * from inbox where visible = 1 and approved = 1 and accountid IN (?) order by `time` desc ".$limit);
	$query->execute(array($accountId));
	$comments = $query->fetchAll();

	foreach ($comments as &$comment) {

		if(filter_var($comment['user_avatar'], FILTER_VALIDATE_EMAIL)) {
			$comment['user_avatar'] = '//www.gravatar.com/avatar/'.md5($comment['user_avatar']).'?d=mm';
		}

		if (is_file(BASE_DIR.'/data/'.$comment['user_avatar'])) {
			$comment['user_avatar'] = BASE_URL.'data/'.$comment['user_avatar'];
		}


	}



	$comments = json_encode($comments);
	echo $comments;
	exit;
}