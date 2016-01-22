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