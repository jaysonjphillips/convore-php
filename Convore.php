<?php
	
	class Convore {
		
		private $credentials;
		private $base_url;
		private $http_response;
		
		public function __construct() {
			$this->base_url = "https://convore.com/api";
		}
		
		function setCredentials($user, $pass) {
			$this->credentials = vsprintf('%s:%s', array($user, $pass));
		}
		
		function getCredentials() {
			return $this->credentials;
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
		
		function getAllGroups() {
			return $this->methodCall('/groups.json', 'get');
		}
		
		// Groups methods
		
		function createGroup($name, $kind, $desc = null, $slug = null) {
			
			$params = array('name' => $name, 
											'kind' => $kind, 
											'description' => $desc, 
											'slug' => $slug);
			
			return $this->methodCall('/groups/create.json', 'post', $params);
		}
		
		function getGroup($group_id) {
				return $this->methodCall('/groups/'.$group_id.'.json', 'get');
		}
		
		function getGroupMembers($group_id, $filter = null) {
			$params = array('filter' => sprintf('%s', $filter));
			return $this->methodCall('/groups/'.$group_id.'/members.json', 'get', $params);
			
		}
		
		function joinGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$group_id.'/join.json', 'post', $params);
		}
		
		function joinPrivateGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$group_id.'/request.json', 'post', $params);
			
		}
		
		
		function methodCall($convore_method, $action, $params = null, $auth_required = true) {
			$ch = curl_init();
			$request = sprintf($this->base_url.'%s', $convore_method);
			
			if($action == 'get' && isset($params)) {
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				$request = $request.'?'.http_build_query($params);
			}
			
			curl_setopt($ch, CURLOPT_URL, $request);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $this->credentials);
			
			if ($action == 'post') {
				curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			}
			
				$convore_data = curl_exec($ch);				
				$this->http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				return json_decode($convore_data);
				
		}		
	}
	
?>