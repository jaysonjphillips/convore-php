<?php
	
	class Convore {
		
		private $credentials;
		private $base_url;
		private $http_response;
		
		public function __construct($user, $pass) {
			$this->credentials = vsprintf('%s:%s', array($user, $pass));
			$this->base_url = "https://convore.com/api";
		}
		
		function verifyAccount() {
			return $this->methodCall('/account/verify.json', 'get');
		}
		
		function markAllRead() {
			return $this->methodCall('/account/mark_read.json', 'get');
		}
		
		function usersOnline() {
			return $this->methodCall('/account/online.json', 'get');
		}
		
		function getGroups() {
			return $this->methodCall('/groups.json', 'get');
		}
		
		function methodCall($convore_method, $action, $auth_required = true, $params = null) {
			$ch = curl_init();
			$request = sprintf($this->base_url.'%s', $convore_method);
			
			curl_setopt($ch, CURLOPT_URL, $request);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $this->credentials);
			
			if ($action == 'post') {
				curl_setopt($ch, CURLOPT_HTTPPOST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			}
			
			if($action == 'get') {
				curl_setopt($ch, CURLOPT_HTTPGET, true);
			}
			
				$convore_data = curl_exec($ch);				
				$this->http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				return json_decode($convore_data);
				
		}		
	}
	
?>