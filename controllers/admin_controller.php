<?
	class admin extends page {

		public function __construct() {
			global $user;
			if (! $user->loggedIn()) {
				
			}
			if (! $user->isAdmin()) {

			}

		}
	}
?>