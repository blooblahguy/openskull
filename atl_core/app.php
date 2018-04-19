<?
	class app {
		protected $title;
		
		public function __construct() {
			$_SESSION['logs'] = isset($_SESSION['logs']) ? $_SESSION['logs'] : array();
			$title = "HAL Extraction";
		}

		public function formsubmit() {
			$REF = $_SERVER['HTTP_REFERER'];
			$URL_REF = parse_url($REF);
			$URL_PATH = $URL_REF['path'];

			triggerAction("form_submission");
			if (isset($_POST['formname'])) {
				triggerAction("form_submission_{$_POST['formname']}");
			}
			triggerAction("form_submission_{$URL_PATH}");
		}

		/////////////////////////////////////////////
		// Logging
		/////////////////////////////////////////////
		public function log($log, $type = "message") {
			$_SESSION['logs'][] = array($type, $log);
		}
		public function displayLogs() {
			echo '<div class="log_window">';
			$this->getLogs();
			echo '</div>';
		}
		public function getLogs($type = false) {
			if (! isset($_SESSION['logs'])) { return; }
			if ( ! $type ) {
				// unpack all messages in order
				foreach ($_SESSION['logs'] as $k => $log) {
					$m_type = $log[0];
					$message = $log[1];
					echo "<div class='message {$m_type}'>{$message}</div>";
				}
			} else {
				foreach ($_SESSION['logs'] as $log) {
					$m_type = $log[0];
					if ($m_type !== $type) {
						continue;
					}
					$message = $log[1];
					echo "<div class='message {$m_type}'>{$message}</div>";
				}
			}
			unset($_SESSION['logs']);
		}

		public function fetchJson($resultSet) {
			global $db;

			$array = array();
			while ($row = $resultSet->fetch_assoc()) {
				$array[] = $row;
			}

			return json_encode($array);
		}
	}
?>