<?
	class user extends app {
		private $user;
		private $logged_in;

		public function __construct() {
			global $db;

			$this->logged_in = false;
			$this->user = array('id'=>0,'rank_id'=>0);
			$this->admin = true;
			
			if ($this->rememberMe()) {
				$this->admin = true;
				$this->logged_in = true;
				$this->user = $db->query("SELECT * FROM atl_users WHERE id = {$_SESSION['userid']} ")->fetch_assoc();
				$db->query("UPDATE atl_users SET last_login = NOW() WHERE id = {$user['id']}");
			}
		}

		private function rememberMe() {
			global $db;
			$cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
			list ($user_id, $token) = explode(':', $cookie); // fetch the cookie then turn it into 2 vars
			$pass = false; // return this
			
			// using session to see if they're logged in
			if (isset($_SESSION['userid']) && trim($_SESSION['userid']) != '') { 
				$pass = true;
			}
			
			if ($cookie) { // only if the cookie is set
				// matches token and user to records
				$db_cookies = $db->query("SELECT * FROM login_cookies WHERE token = '{$token}' AND user_id = {$user_id}"); 
				while ($saved = $db_cookies->fetch_assoc()) {
					// essentially just "if ($saved['token'] == $token)"
					if ($this->timingSafeCompare($saved['token'],$token)) { 
						$_SESSION['userid'] = $saved['user_id'];
						setcookie('rememberme', $user_id.":".$token, time()+60*60*24*30,"/"); // reup the cookie
						$db->query("UPDATE login_cookies SET created = NOW() WHERE token = '{$token}' AND user_id = {$user_id}"); // reup the database save date
						echo $db->error;
						$pass = true;
						break; // end the loop, we found a match
					}
				}
			}
			
			return $pass; // true or false (logged in or not)
		}

		private function timingSafeCompare($safe, $user) {
			// Prevent issues if string length is 0
			$safe .= chr(0);
			$user .= chr(0);

			$safeLen = strlen($safe);
			$userLen = strlen($user);

			// Set the result to the difference between the lengths
			$result = $safeLen - $userLen;

			// Note that we ALWAYS iterate over the user-supplied length
			// This is to prevent leaking length information
			for ($i = 0; $i < $userLen; $i++) {
				// Using % here is a trick to prevent notices
				// It's safe, since if the lengths are different
				// $result is already non-0
				$result |= (ord($safe[$i % $safeLen]) ^ ord($user[$i]));
			}

			// They are only identical strings if $result is exactly 0...
			return $result === 0;
		}

		public function isAdmin() {
			return $this->admin;
		}
		public function loggedIn() {
			return $this->logged_in;
		}
	}
?>