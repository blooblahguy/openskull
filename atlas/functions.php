<?
	if (! $base_dir) {exit();}

	$events = array();
	function triggerEvent() {

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