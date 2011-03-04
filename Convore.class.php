<?php
	
	class Convore {
		
		private $credentials;
		private $url_base;
		
		public function __construct($user, $pass) {
			$this->credentials = sprintf('%s:%s', $user, $pass);
			$this->url_base = "https://convore.com/api/";
		}
		
		public function sendRequest($url, $action) {
			// extract curl request
		}
		
		public function verifyAccount() {
			return $this->methodCall('/account/verify.json', 'get');
		}
		
		public function markAllRead() {
			return $this->methodCall('/account/mark_read.json', 'get');
		}
		
		public function usersOnline() {
			return $this->methodCall('/account/online.json', 'get');
		}
		
		private function methodCall($convore_method, $action, $auth_required = true, $params) {
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, sprintf($this->base_url.'%s', $convore_method));
			
			if ($auth_required) {
				curl_setopt($ch, CURLOPT_USERPWD, $this->credentials);
			}
			
			if ($action == 'post' && !is_null($params)) {
				curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			}
			
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$convore_data = curl_exec($ch);
				
				$this->http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				curl_close($ch);
				return json_decode($convore_data);
			}
		}		
	}
	
?>