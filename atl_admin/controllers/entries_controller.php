<?
	class entries extends admin {
		public function __construct() {
			parent::__construct();
			global $view;

			$view->setTitle("Entries");
			$view->set('entries');
		}

		public function create() {
			global $db;

			// collect post information
			$first_name = sanitize($_POST['first_name']);
			$last_name = sanitize($_POST['last_name']);
			$email = sanitize($_POST['email']);
			$phone = sanitize($_POST['phone']);
			$message = sanitize($_POST['message']);
			$unique = $first_name." ".$last_name." ".$email; 

			// first, lets create this person as a contact if they don't exist
			$contact_check = $db->query("SELECT 
					*
				FROM contacts
				WHERE unique = '{$unique}' 
			");

			$contact = false;
			if ($contact_check && $contact_check->num_rows > 0) {
				// found at least 1
				if ($contact_check->num_rows == 1) {
					// found 1, we don't need to create, just fetch the ID
					$contact = $contact_check->fetch_assoc();
				} else {
					// found multiple
					while ($c = $contact_check->fetch_assoc() && !$contact) {
						if ($c['phone'] == $phone) {
							$contact = $c;
							return;
						}
						if ($c['email'] == $email) {
							$contact = $c;
							return;
						}
					}

					if (! $best) {
						// couldn't really match on anything, we'll just snag the first one
						$contact = $contact_check->fetch_assoc();
					}
				}
			}

			// didn't find any that match, let's go ahead and create one
			if (! $contact) {
				$qry = "INSERT INTO contacts (
					first_name
					, last_name
					, email
					, phone
					, unique
					, message
				) VALUES (
					'{$first_name}'
					, '{$last_name}'
					, '{$email}'
					, '{$phone}'
					, '{$unique}'
					, '{$message}'
				) ";
			}

			print_r($_POST);
			exit();
		}

		public function retrieve() {

		}

		public function update() {

		}

		public function delete() {

		}
	}
?>