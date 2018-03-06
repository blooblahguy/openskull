<?
	class view {
		private $view;

		public function __construct() {
			$this->view = "404";
		}

		public function get() {
			return $this->view;
		}

		public function set($path) {
			$this->view = $path;
		}
	}
?>