<?
	class guides extends page {

		public function __construct() {
			// global $page;
			global $view;
			$this->setTitle = "Guides";
			$view->set("guides/home");
		}

		public function view($action_id) {
			global $view;
			$view->set("guides/home");
		}
	}
?>