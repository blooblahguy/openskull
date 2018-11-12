<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	session_start();
	include("atl_config.php");

	// Tell PHP that we're using UTF-8 strings until the end of the script
	mb_internal_encoding('UTF-8');
	// Tell PHP that we'll be outputting UTF-8 to the browser
	mb_http_output('UTF-8');

	$base_dir = getcwd();
	$secret = "hal_3122018_cpc_15342";
	$path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
	
	// load everyting first
	require("atl_core/init.php");
	
	@list($controller, $action, $parameters) = explode("/", $path, 3);

	$bodyClass = array();
	$bodyClass[] = $controller;
	$bodyClass[] = $action;

	// activates the autoloader
	// atlas core classes
	spl_autoload_register(function($className) {
		global $base_dir;
		global $atl_admin;
		
		if (file_exists($base_dir . "/atl_core/" . $className . '.php')) {
			require_once($base_dir . "/atl_core/" . $className . '.php');
		}
		if ($atl_admin == "admin") {
			if (file_exists($base_dir . "/atl_admin/controllers/" . $className . '_controller.php')) {
				require_once($base_dir . "/atl_admin/controllers/" . $className . '_controller.php');
			}
		} else {
			if (file_exists($base_dir . "/atl_app/controllers/" . $className . '_controller.php')) {
				require_once($base_dir . "/atl_app/controllers/" . $className . '_controller.php');
			}
		}
		
	});
	
	$view = new view();
	$user = new user();

	if ($controller == "admin") {
		require_once("atl_admin/admin_init.php");
	} else {
		require_once("atl_app/app_init.php");
	}
		
	// just for safety
	mysqli_close($db);
	session_write_close();
?>