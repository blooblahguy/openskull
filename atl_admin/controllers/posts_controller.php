<?
	class posts extends admin {
		public function __construct() {
			parent::__construct();
			global $view;

			$view->set('posts');
			$view->setTitle('Posts');
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