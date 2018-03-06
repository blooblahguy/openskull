<?php
	session_start();
	header('X-Frame-Options: GOFORIT'); 
	header('Vary: Accept-Encoding'); 
	include("atl_config.php");

	$base_dir = getcwd();
	$secret = "gp_12020716";
	$cururl = strtok(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),"?");
	$path = explode("/", $cururl);
	
	// load everyting first
	require("atlas/init.php");
	
	$extend = $path[1];
	$action = $path[2];
	$action_id = $path[3];
	
	$bodyClass = array();
	$bodyClass[] = $extend;
	$bodyClass[] = $action;

	// activates the autoloader
	spl_autoload_register(function($className) {
		global $base_dir;
		
		if (file_exists($base_dir . "/atlas/" . $className . '.php')) {
			require_once($base_dir . "/atlas/" . $className . '.php');
		} elseif (file_exists($base_dir . "/controllers/" . $className . '_controller.php')) {
			require_once($base_dir . "/controllers/" . $className . '_controller.php');
		} elseif (file_exists($base_dir . "/models/" . $className . '.php')) {
			require_once($base_dir . "/models/" . $className . '.php');
		} elseif (file_exists($base_dir . "/views/" . $className . '.php')) {
			require_once($base_dir . "/views/" . $className . '.php');
		}
	});

	// atlas core classes
	$model = new model();
	$view = new view();
	$controller = new controller();
	$page = new page();
	$user = new user();

	// Set Default Title
	$page->setTitle(ATL_DEFAULT_TITLE);

	// initialize the extended controller
	if (file_exists('controllers/'.$extend.'_controller.php')) {
		include('controllers/'.$extend.'_controller.php');
		$$extend = new $extend;
		if (method_exists($$extend, $action)) {
			$$extend->{$action}($action_id);
		}
	}
	
	// View
	$bodyClass[] = $view->get();
	include(includeView("header", true));
	if ($view) {
		include(includeView($view->get()));
	}
	include(includeView("footer", true));
		
	// just for safety
	mysqli_close($db);
	session_write_close();
?>