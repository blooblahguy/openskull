<?
	class admin extends app {

		public function __construct() {
			global $user;
			global $view;
			global $controller;

			// make things secure
			if ( ! $user->loggedIn() ) {
				if ($controller !== "login") {
					parent::log("You must be logged in to view the admin area", "error");
					redirect("/admin/login");
				}
			} elseif (! $user->isAdmin()) {
				parent::log("You're not an admin!", "error");
				redirect("/");
			} else {
				if (! isset($controller)) {
					$view->set("dashboard");
					$view->setTitle("Dashboard");
				}

				queue_script("/atl_admin/js/jquery-3.3.1.min.js");
				queue_script("/atl_admin/js/admin_scripts.js");				

				queue_style("/atl_admin/css/openskull.css");
				queue_style("/atl_admin/css/admin_css.php");

				atl_admin_menu("Dashboard", '/admin/dashboard');
				atl_admin_menu("Posts", '/admin/posts');
				atl_admin_menu("Pages", '/admin/pages');
				atl_admin_menu("New Page", '/admin/pages', "Pages");
				atl_admin_menu("Forms", '/admin/forms');
				atl_admin_menu("html", '<hr>');
				atl_admin_menu("Entries", '/admin/entries');
				atl_admin_menu("Contacts", '/admin/contacts');
				atl_admin_menu("Projects", '/admin/projects');
				atl_admin_menu("html", '<hr>');
				atl_admin_menu("Users", '/admin/users');
				atl_admin_menu("Settings", '/admin/settings');
				// atl_admin_menu_remove()
			}
		}
	}
?>