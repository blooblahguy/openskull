<?php 
	// style our website
	queue_style("/css/openskull.css", 0);
	queue_style("/css/style.php", 5);

	queue_script("/js/jquery-3.3.1.min.js", 0);
	queue_script("/js/scripts.js", 5);

	// $this->breadcrumbs = array();

	if ($controller == "") {
		$app->setTitle("");
		$view->set("pages/home");
	}

?>