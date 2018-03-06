<?
	class page extends controller {
		public $breadcrumbs;
		public $title;

		public function __construct() {
			global $cururl;
			global $view;

			// style our website
			queue_style("/css/openskull.css", 0);
			queue_style("/css/style.php", 5);

			queue_script("/js/jquery-3.3.1.min.js", 0);
			queue_script("/js/scripts.js", 5);

			$this->breadcrumbs = array();

			if ($cururl == "/") {
				$this->title = "";
				$view->set("pages/news");
			}
		}

		public function setTitle($smart) {
			global $action;
			global $extra;

			if ($smart == "Grimporium" && (isset($action) || isset($extra))) {
				$title = isset($action) ? $action : $extra;
				$page = str_replace("_", " ", $title);
				$page = str_replace("-", " ", $title);
				$smart = ucwords($page);
			}
			if (strlen($smart) > 0) {$smart .= " - ";}
			$smart .= "Grimporium - Grim Dawn Guides, Tools, and Items";

			$this->title = $smart;
		}

		public function getTitle() {
			return $this->title;
		}

	}
?>