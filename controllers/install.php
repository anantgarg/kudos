<?php

function index() {

	global $dbh;

	$dbversion = 1;

	while (file_exists(dirname(dirname(__FILE__)).'/db/'.($dbversion).'.txt')) {
		$content = file_get_contents(dirname(dirname(__FILE__)).'/db/'.($dbversion).'.txt');

		$q = preg_split('/;[\r\n]+/',$content);

		foreach ($q as $query) {
			if (strlen($query) > 4) {
				$queryE = $dbh->prepare($query);
				$queryE->execute(array());
			}
		}

		$dbversion++;
	}

	
}