<?
	class account extends user {
		public function __contstruct() {
			global $log;
		}
		public function login() {
			global $log;
			global $user;
			global $secret;
			global $db;

			$redirect = "/";
			if (isset($_POST['redirect'])) {
				$redirect = sanitize($_POST['redirect']);
			}

			$email = sanitize($_POST['email']);
			$password = md5(sanitize($_POST['password']));

			$check = $db->query("SELECT * FROM atl_users WHERE email = '{$email}' AND password = '{$password}' ");

			if ($check->num_rows > 0) {
				$user = $check->fetch_assoc();

				// store this login
				$token = random_bytes(32); // random 32 length number
				$cookie = $token . time(); // additional level of obscurity
				$token = crypt($cookie, $secret); // final level of obscurity, the "secret" is just a salt, can be anything, and the same one can be used every time. Just uses it as part of the algorithm. 
				$cookie = $user['id'] . ":" . $token; // sets the cookie string
				setcookie('rememberme', $cookie, time()+60*60*24*30,"/"); // stores the cookie for 30 days
				
				$num_cooks = $db->query("SELECT id FROM login_cookies WHERE user_id = {$user['id']}");
				echo $db->error;
				if ($num_cooks->num_rows >= 3) { // counts how many cookies are stored in the database for this user, allowing 3 seperate devices here. 
					$db->query("UPDATE login_cookies 
						SET token = '{$token}', created = NOW()
						WHERE user_id = {$user['id']}
						ORDER BY created ASC
						LIMIT 1
					");
					echo $db->error;
				} else { // create new records if fewer than 3 devices have been logged in to
					$db->query("INSERT INTO login_cookies (token, user_id, created)
					VALUES (
						'{$token}',
						{$user['id']},
						NOW()
					)");
					echo $db->error;
				}
				
				// destroy any cookies that are older than 30 days
				$db->query("DELETE FROM login_cookies WHERE created < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 DAY)) "); 
				echo $db->error;

				// now log them in
				$db->query("UPDATE users SET last_login = NOW() WHERE email = '".$email."' ");
				$log->success("Successfully logged in, welcome back ".$user['name']."");
			} else {
				$log->error("Invalid username or password");
				redirect($redirect);
			}
		}
	}
?>