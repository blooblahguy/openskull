<?
	class view {
		private $view;
		private $directory;
		private $page_title;
		private $meta_title;

		public function __construct() {
			global $base_dir;

			$this->view = "404";
			$this->setDirectory($base_dir);
		}

		// for multiple different view folders
		public function getDirectory($directory) {
			return $this->directory;
		}
		public function setDirectory($directory) {
			$this->directory = $directory;
			return $directory;
		}

		// automatic get view function
		public function set($path) {
			$this->view = $path;
		}
		public function get() {
			global $base_dir;

			return $this->fetch($this->view);
		}

		// specific view fetching
		public function fetch($path, $hideOnAjax = false) {
			if ($hideOnAjax && isAjax()) {return;}
			
			// if that doesn't exist then lets bring in default view directory
			if (file_exists($this->directory."/views/".$path.".php")) {
				return ( $this->directory."/views/".$path.".php" );
			}
			// if none of that is real, 404 page
			return ( $this->directory."/views/"."404.php" );
		}

		/////////////////////////////////////////
		// Page Functions
		/////////////////////////////////////////
		public function setTitle($page_title) {
			$this->page_title = $page_title;
		}

		public function getMetaTitle() {
			$smart = $this->page_title;
			global $action;
			global $extra;

			if ($smart == "HAL Extraction" && (isset($action) || isset($extra))) {
				$page_title = isset($action) ? $action : $extra;
				$page = str_replace("_", " ", $page_title);
				$page = str_replace("-", " ", $page_title);
				$smart = ucwords($page);
			}
			if (strlen($smart) > 0) {$smart .= " - ";}
			$smart .= "HAL Extraction";

			return $smart;
		}

		public function getTitle() {
			return $this->page_title;
		}
	}
?>