<?php
 /**
  * @package ChroniumLabs
	* @copyright (c) 2011 Chronium Labs LLC
	* @license http://opensource.org/licenses/mit-license.php MIT License
	*
	*/	
 /**
	* The Convore Class 
	* @package ChroniumLabs.convore-php
	*/
	class Convore {				
		/**
		 * Private variable to store credentials
		 * @var Private $credentials
		 **/
			
		private $credentials;
		
		/**
		 * Private var for base api url (to support future versioning)
		 * @var Private $base_url
		 **/

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
		
		/**
		 * Get a list of user's mentions
		 * @return Object json
		 **/
		function getUserMentions() {
			return $this->methodCall('account/mentions.json', 'get');
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
		
		/**
		 * Retrieve particular group
		 * @param Integer $group_id
		 * @return Object json
		 **/
		function getGroupById($group_id) {
				return $this->methodCall('/groups/'.$group_id.'.json', 'get');
		}
		
		/**
		 * Join a particular group 
		 * @param Integer $group_id 
		 * @return Object json
		 **/
		function joinGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$group_id.'/join.json', 'post', $params);
		}
		
		/**
		 * Request to join a private group
		 * @param Integer $group_id
		 * @return Object json
		 **/
		function requestToJoinGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$group_id.'/request.json', 'post', $params);
			
		}
		
		/**
		 * Leave a particular group
		 * @param Integer $group_id 
		 * @return Object json
		 **/
		function leaveGroup($group_id) {
			$params = array('group_id' => sprintf('%d', $group_id));
			return $this->methodCall('/groups/'.$params['group_id'].'/leave.json', 'post', $params);
			
		}
		
		/**
		 * Retrieve the members of a particular group
		 * @param Integer $group_id 
		 * @param String $filter (optional parameter. 'admin' filters member list for admins of the group)
		 * @return Object json
		 **/
		function getMembersByGroup($group_id, $filter = null) {
			$params = array('filter' => sprintf('%s', $filter));
			return $this->methodCall('/groups/'.$group_id.'/members.json', 'get', $params);
			
		}
		
		/**
		 * Retrieve the members of a group that's currently online
		 * @param Integer $group_id 
		 * @return Object json
		 **/
		function getMembersOnlineByGroup($group_id) {
			return $this->methodCall('/groups/'.$group_id.'/online.json', 'get');
		}
		
		/**
		 * Mark all messages as read for a particular group		 
		 * @param Integer $group_id 
		 * @return Object json
		 **/
		function markReadByGroup($group_id) {
			return $this->methodCall('/groups/'.$group_id.'/mark_read.json', 'get');
		}
		
		/**
		 * Retrieve the topics for a particular group		 
		 * @param Integer $group_id 
		 * @param Integer $until_id
		 * @return Object json
		 **/
		function getTopicsByGroup($group_id, $until = null) {
			$params['until_id'] = $until;
			return $this->methodCall('/groups/'.$group_id.'/topics.json', 'get', $params);
		}
		
		/**
		 * Create a new topic for a particular group		 
		 * @param Integer $group_id
		 * @param String $name
		 * @return Object json
		 **/
		function createTopic($group_id, $name) {
			$params['name'] = sprintf('%s', $name);
			return $this->methodCall('/groups/'.$group_id.'/topics/create.json', 'post', $params);
		}
		
		/**
		 * Track or mute a group	 
		 * @param Integer $group_id 
		 * @return Object json
		 **/
		function trackGroup($group_id) {
			return $this->methodCall('/groups/'.$group_id.'/track.json', 'get');
		}
		
		// Topics
				
		/**
		 * Get detailed information about the topic.	 
		 * @param Integer $topic_id 
		 * @return Object json
		 **/
		function getTopic($topic_id) {
			return $this->methodCall('/topics/'.$topic_id.'.json', 'get', null);
		}
		
		/**
		 * Delete a topic. You must be the creator of the topic or a group admin in order to delete the topic	 
		 * @param Integer $topic_id 
		 * @return Object json
		 **/
		function deleteTopic($topic_id) {
			return $this->methodCall('/topics/'.$topic_id.'/delete.json', 'post');
		}
		
		/**
		 * Edit a topic. You must be the creator of the topic or a group admin in order to delete the topic	 
		 * @param Integer $topic_id 
		 * @param String  $name 
		 * @return Object json
		 **/
		function editTopic($topic_id, $name) {
			$params['name'] = sprintf('%s', $name);
			return $this->methodCall('/topics/'.$topic_id.'/edit.json', 'post', $params);
		}
		
		/**
		 * Track or mute a topic	 
		 * @param Integer $topic_id 
		 * @return Object json
		 **/
		function trackTopic($topic_id) {
			return $this->methodCall('/topics/'.$topic_id.'/track.json', 'get');
		}
		
		/**
		 * Mark all messages in a topic as read.	 
		 * @param Integer $topic_id 
		 * @return Object json
		 **/
		function markReadByTopic($topic_id) {
			return $this->methodCall('/topics/'.$topic_id.'/mark_read.json', 'post');
		}
		
		/**
		 * Get the latest messages in a topic. Use the optional until_id parameter to paginate and get prior messages. 
		 * Set the optional mark_read parameter to false to leave the messages as unread.		 
		 * @param Integer $topic_id 
		 * @param Integer $until_id 
		 * @param Boolean $mark_read
		 * @return Object json
		 **/
		function getMessagesByTopic($topic_id, $until_id = null, $mark_read = false) {
			$params = array(
				'until_id' => $until_id,
				'mark_read' => $mark_read
			);
			return $this->methodCall('/topics/'.$topic_id.'/messages.json', 'get', $params);
		}
		
		//  Messages
		
		/**
		 * Post a new message	 
		 * @param Integer $topic_id 
		 * @param String $message
		 * @return Object json
		 **/
		function createMessage($topic_id, $message) {
			$params['message'] = sprintf('%s', $message);
			return $this->methodCall('/topics/'.$topic_id.'/messages/create.json', 'post', $params);
		}
		
		/**
		 * Star a message. If the message has already been starred by this user, this endpoint will then unstar the message
		 * @param Integer $message_id
		 * @return Object json
		 **/
		function starMessage($message_id) {
			return $this->methodCall('/messages/'.$message_id.'/star.json', 'post');
		}
		
		/**
		 * Delete a message. You must be the creator of the message or a group admin in order to delete the message.
		 * @param Integer $message_id
		 * @return Object json
		 **/
		function deleteMessage($message_id) {
			return $this->methodCall('/messages/'.$message_id.'/delete.json', 'post');
		}
		
		// Users
		
		/**
		 * Get detailed information about the user by user_id.
		 * @param Integer $user_id
		 * @return Object json
		 **/
		function getUserById($user_id) {
			return $this->methodCall('/users/'.$user_id.'.json', 'get');
		}
		
		/**
		 * Get detailed information about the user by username.
		 * @param String $username
		 * @return Object json
		 **/
		function getUserByName($username) {
			return $this->methodCall('/users/'.$username.'.json', 'get');
		}
		
		// Users - messages
		
		/**
		 * Get direct messages for current user. Use until_id (optional) to paginate/get prior
		 * @param Integer $until_id
		 * @return Object json
		 **/
		function getDirectMessages($until_id = null) {
			$params['until_id'] = $until_id;
			return $this->methodCall('/users/messages.json', 'get', $params);
		}
		
		/**
		 * Get messages between specified user & current user. Use until_id (optional) to paginate/get prior
		 * @param Integer $user_id
		 * @param Integer $until_id
		 * @return Object json
		 **/
		function getPrivateConversations($user_id, $until_id = null) {
			$params['until_id'] = $until_id;
			return $this->methodCall('/messages/'.$user_id.'.json', 'get', $params);
		}
		
		/**
		 * Create Direct Message
		 * @param Integer $user_id
		 * @param Integer $message
		 * @return Object json
		 **/
		function createDirectMessage($user_id, $message) {
			$params['message'] = sprintf('%s', $message);
			return $this->methodCall('/messages/'.$user_id.'create.json', 'post', $params);
		}
		
		/**
		 * Star a direct message. 
		 * @param Integer $message_id
		 * @return Object json
		 **/
		function starDirectMessage($message_id) {
			$params['message_id'] = $message_id;
			return $this->methodCall('/messages/message/'.$message_id.'/star.json', 'post', $params);
		}
		
		/**
		 * Delete a direct message. 
		 * @param Integer $message_id
		 * @return Object json
		 **/
		function deleteDirectMessage($message_id) {
			$params['message_id'] = $message_id;
			return $this->methodCall('/messages/message/'.$message_id.'/delete.json', 'post', $params);
		}
		
		
		//  Group Discovery
		
		/**
		 * Get list of all groups authenticated user is a member of
		 * @return Object json
		 **/
		function discoverGroups() {
			return $this->methodCall('/groups/discover/friend.json', 'get');
		}
		
		/**
		 * Get list of all group categories
		 * @return Object json
		 **/
		function discoverGroupCategories() {
			return $this->methodCall('/groups/discover/category.json', 'get');
		}
		
		/**
		 * Gets a list of groups in the given category.
		 * @param String $slug
		 * @return Object json
		 **/
		function discoverGroupsByCategory($slug) {
			$category_slug = sprintf('%s', $slug);
			return $this->methodCall('/groups/discover/category/'.$category_slug.'.json', 'get');
		}
		
		/**
		 * Gets a list of groups matching the given search.
		 * Note: The required q parameter should be the term to be searched for.
		 * @param String $q
		 * @return Object json
		 **/
		function discoverGroupsByQuery($q) {
			$params = array(
				'q' => sprintf('%s', $q)
			);
			return $this->methodCall('groups/discover/explore/search.json', 'get', $params);
		}
		
		/**
		 * Gets a list of all groups, sorted either by popularity, recency, or alphabetically.
		 * Note: The required sort parameter should be set to one of popular, recent, or alphabetical.
		 * @param String $sort_by
		 * @return Object json
		 **/
		function discoverGroupsBySort($sort_by) {
			$sort = sprintf('%s', $sort_by);
			return $this->methodCall('groups/discover/explore/'.$sort.'.json', 'get');
		}
		
		/**
		 * Get list of groups with very recent activity
		 * @return Object json
		 **/
		function discoverTrendingGroups() {
			return $this->methodCall('groups/discover/trending.json', 'get');
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
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $this->credentials);
			
			if ($action == 'post') {
				curl_setopt($ch, CURLOPT_POST, 1);
		    	if(isset($params)){
		    	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		    	}
			}
			
				$convore_data = curl_exec($ch);			
				$this->http_response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				return json_decode($convore_data);
				
		}		
	}
	
?>