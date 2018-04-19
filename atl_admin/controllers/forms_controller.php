<?
	class forms extends admin {
		public function __construct() {
			parent::__construct();
			global $view;

			$view->setTitle('Forms');
			$view->set('forms/main');
		}

		public function create() {
			global $db;

			$qry = "INSERT INTO atl_posts (
				post_type
				, post_title
			) VALUES (
				'form'
				, 'New Form'
			)";
			$db->query($qry);

			redirect("/admin/forms/view/".$db->insert_id);
		}

		public function retrieve($id = false) {
			global $db;
			if (! $id) {
				$forms = $db->query("SELECT * FROM atl_posts WHERE post_type = 'form' ORDER BY modified DESC");
			} else {

			}
			return $forms;
		}

		public function update() {

		}

		public function delete() {

		}
	}
?>