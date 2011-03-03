<?php
	
	class Convore {
		
		private $username;
		private $password;
		private $url_base;
		
		public function __construct($user, $pass) {
			$this->username = $user;
			$this->password = $pass;
			
			$this->url_base = "https://convore.com/api";
		}
		
		public function send_request($url, $action) {
			// extract curl request
		}
		
		public function verify_account() {
			$curl_conn = curl_init();
			
			//Set up the URL 
			$verify = $this->url_base.'/account/verify.json';
			
			//Set cURL options
			curl_setopt($curl_conn, CURLOPT_URL, $verify); 
			curl_setopt($curl_conn, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_conn, CURLOPT_USERPWD, $this->username.':'.$this->password); 
			curl_setopt($curl_conn, CURLOPT_GET, 1); 
			
			$output = curl_exec($curl_conn);

			curl_close($curl_conn);
			
			return $output;
			
		}
		
	}
	
?>