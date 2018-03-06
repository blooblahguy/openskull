<?
	if (! $base_dir) {exit();}

	$atl_options = array();
	function getOption($name) {
		global $atl_options;
		if (empty($atl_options)) {
			$ops = $db->query("SELECT * FROM ".ATL_DB_PREFIX."options");
			while ($o = $ops->fetch_assoc()) {
				$atl_options[$o['name']] = $o['value'];
			}
		}

		return $atl_options[$name];
	}

	function updateOption($name, $value) {
		global $atl_options;
		$atl_options[$name] = $value;
		$db->query("UPDATE ".ATL_DB_PREFIX."options SET value = '$value' WHERE name = '$name' ");
	}

	$atl_events = array();

	// ex add_action(eventName, function(any, number, of, paramters) {})
	function add_action($event, $fn, $priority = 10) {
		global $atl_events;
		$atl_events[$event] = isset($atl_events[$event]) ? $atl_events[$event] : array();
		$atl_events[$event][$priority] = isset($atl_events[$event][$priority]) ? $atl_events[$event][$priority] : array();
		$atl_events[$event][$priority][] = $fn;
	}

	// ex do_action(eventName, any, number, of, parameters)
	function do_action($event) {
		global $atl_events;

 		$vars = func_get_args();
		unset($vars[0]);

		$atl_events[$event] = isset($atl_events[$event]) ? $atl_events[$event] : array();

		foreach ($atl_events[$event] as $event => $fns) {
			foreach ($fns as $priority => $fn) {
				call_user_func_array($fn, $vars);
			}
		}
	}

	function fetchAll($rs) {
		$all = array();
		while ($v = $rs->fetch_assoc()) {
			$all[] = $v;
		}

		return $all;
	}

	function hashArray($array) {
		return md5(serialize($array));
	}

	function atlas_header() {
		global $queued_styles;
		// print out queued styles
		if (isset($queued_styles)) {
			foreach ($queued_styles as $priority => $styles) {
				foreach ($styles as $k => $path) { ?>
					<link rel="stylesheet" href="<? echo $path; ?>">
				<? }
			}
		}
	}

	function atlas_footer() {
		global $queued_scripts;
		
		// print out queued scripts
		if (isset($queued_scripts)) {
			foreach ($queued_scripts as $priority => $scripts) {
				foreach ($scripts as $k => $path) { ?>
					<script type="text/javascript" src="<? echo $path; ?>"></script>
				<? }
			}
		}

		// message reporting
	}

	function includeView($filename, $hideOnAjax = false) {
		global $base_dir;
		global $view;
		
		if ($hideOnAjax && isAjax()) {return;}

		// View
		$foundview = false;
		// if that doesn't exist then lets bring in default view directory
		if (file_exists($base_dir."/views/".$filename.".php")) {
			$foundview = $base_dir."/views/".$filename.".php";
		}
		// if none of that is real, 404 page
		if (! $foundview) {
			return ($base_dir."/views/"."404.php");			
		}
		
		return $foundview;
	}

	function isAjax() {

		if (isset($_POST['ajax']) && $_POST['ajax'] == true) {
			return true;
		}
		if (isset($_GET['ajax']) && $_GET['ajax'] == true) {
			return true;
		}

		return false;
	}

	$queued_styles = array();
	$queued_scripts = array();
	function queue_style($path, $priority) {
		global $queued_styles;

		if (! isset($queued_styles[$priority])) {
			$queued_styles[$priority] = array();
		}

		$queued_styles[$priority][] = $path;
	}

	function queue_script($path, $priority) {
		global $queued_scripts;

		if (! isset($queued_scripts[$priority])) {
			$queued_scripts[$priority] = array();
		}

		$queued_scripts[$priority][] = $path;
	}

	function redirect($path) {
		header("Location: ".$path);
		exit();
	}

	function sanitize($i) {
		// sanitize any input
  		$i = trim($i);
		$i = mysql_real_escape_string($i);
		$i = htmlspecialchars($i, ENT_IGNORE, 'utf-8');

		return $i;
	}

	function debug($i) {
		echo "<pre>";
		print_r($i);
		echo "</pre>";
	}
?>