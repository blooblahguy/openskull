<?php

	require_once("web_controller.php");

	// try to include children controllers
	if (isset($controller)) {
		$view->setTitle(ucwords($controller));
		if ( file_exists($base_dir . '/atl_web/controllers/'.$controller.'_controller.php') ) {
			$controller = new $controller;
		}
	}

	// if not then include just admin
	if (! is_object($controller)) { 
		$controller = new web();
	}

	// try to execute the action
	if (isset($action) && method_exists($controller, $action)) {
		$controller->{$action}($params);
	}

	// we're on the front end, lets instantiate the "theme"
	include_once("atl_app/functions.php");

	// View
	$view->setDirectory($base_dir."/atl_web");
	include($view->fetch("header", true));
	include($view->get());
	include($view->fetch("footer", true));

?>