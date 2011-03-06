<?php
	
	/**
	*
	* @package Convore-PHP
	* @version $Id$
	* @copyright (c) 2011 Chronium Labs LLC
	* @license http://opensource.org/licenses/mit-license.php MIT License
	*
	*/
	
	class Convore {
		
		private $credentials;
		private $base_url;
		
		/**
		 * Constructor method for Convore
		 * @param String $user Username
		 * @param String $pass Password
		 **/
		public function __construct($user, $pass) {
			$this->credentials = vsprintf('%s:%s', array($user, $pass));
			$this->base_url = "https://convore.com/api";
		}
		
		/**
		 * Verify your account credentials
		 * @return Object json
		 **/
		function verifyAccount() {
			return $this->methodCall('/account/verify.json', 'get');
		}
		
		/**
		 * Mark all unread topic messages as read
		 * @return Object json
		 **/
		
		function markAllRead() {
			return $this->methodCall('/account/mark_read.json', 'get');
		}
		
		/**
		 * Get a list of all users currently online
		 * @return Object json
		 **/
		function getUsersCurrentlyOnline() {
			return $this->methodCall('/account/online.json', 'get');
		}
		
		// Groups methods
		
		/**
		 * Get all groups user is currently a part of
		 * @return Object json
		 **/
		function getAllGroups() {
			return $this->methodCall('/groups.json', 'get');
		}
		
		/**
		 * Create a group for authenticated user
		 * @param String $name Name of group
		 * @param String $kind either public or private
		 * @param String $desc Optional description for group (defaults to null)
		 * @param String $slug Optional custom slug for created group (defaults to null) 
		 * @return Object json
		 **/		
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
		
		function joinGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$group_id.'/join.json', 'post', $params);
		}
		
		function joinPrivateGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$group_id.'/request.json', 'post', $params);
			
		}
		
		function leaveGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$params['group_id'].'/leave.json', 'post', $params);
			
		}
		
		function getMembersByGroup($group_id, $filter = null) {
			$params = array('filter' => sprintf('%s', $filter));
			return $this->methodCall('/groups/'.$group_id.'/members.json', 'get', $params);
			
		}
		
		function getMembersOnlineByGroup($group_id) {
			return $this->methodCall('/groups/'.$group_id.'/online.json', 'get');
		}
		
		// Groups - Topics
		function getToipcsByGroup($group_id) {
			return $this->methodCall('/groups/'.$params['group_id'].'/topics.json');
		}
		
		
		function methodCall($convore_method, $action, $params = null, $auth_required = true) {
			$ch = curl_init();
			$request = sprintf($this->base_url.'%s', $convore_method);
			
			if($action == 'get') {
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				
				if(isset($params)) {
					$request = $request.'?'.http_build_query($params);
				}
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