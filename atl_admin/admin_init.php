<?
	@list($atl_admin, $controller, $action, $paramters) = explode("/", $path, 4);

	require_once("admin_controller.php");

	// try to include children controllers
	if (isset($controller)) {
		$view->setTitle(ucwords($controller));
		if ( file_exists('atl_admin/controllers/'.$controller.'_controller.php') ) {
			$controller = new $controller;
		}
	}

	// if not then include just admin
	if (! is_object($controller)) { 
		$controller = new admin();
	}

	// try to execute the action
	if (isset($action) && method_exists($controller, $action)) {
		$controller->{$action}($params);
	}

	// View
	$view->setDirectory($base_dir."/atl_admin");
	include($view->fetch("header", true));
	include($view->get());
	include($view->fetch("footer", true));
?>