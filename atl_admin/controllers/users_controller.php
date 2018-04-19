<?
	class users extends admin {
		public function __construct() {
			parent::__construct();
			global $view;

			$view->setTitle("Users");
			$view->set('users');
		}

		public function create() {

		}

		public function retrieve() {

		}

		public function update() {

		}

		public function delete() {

		}
	}
?>