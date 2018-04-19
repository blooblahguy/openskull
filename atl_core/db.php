<?php
	$db = @new mysqli(ATL_DB_HOST, ATL_DB_USER, ATL_DB_PASSWORD, ATL_DB_NAME);
	$db->query("SET time_zone = 'America/Chicago' ");
	date_default_timezone_set('America/Chicago');
?>