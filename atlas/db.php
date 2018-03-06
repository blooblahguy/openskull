<?php
	$db = @new mysqli("localhost", "blooblah_dev", "pocpas!23", "blooblah_grimporium");
	$db->query("SET time_zone = 'America/Chicago' ");
	date_default_timezone_set('America/Chicago');
?>