<?php

class Twitter extends Object {

	/**
	 * Pref
	 * 
	 * (default value: null)
	 * 
	 * @var mixed
	 * @access public
	 */
	public $Pref = null;
	
	/**
	 * Tweet
	 * 
	 * (default value: null)
	 * 
	 * @var mixed
	 * @access public
	 */
	public $Tweet = null;
	
	/**
	 * User
	 * 
	 * @var mixed
	 * @access public
	 */
	public $User = null;
	
	/**
	 * searchApi
	 * 
	 * (default value: null)
	 * 
	 * @var mixed
	 * @access public
	 */
	public $search = null;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->Pref = ClassRegistry::init('Pref', 'Model');
		$this->Tweet = ClassRegistry::init('Tweet', 'Model');
		$this->User = ClassRegistry::init('User', 'Model');
		App::import('Lib', 'twitter_search');
		$this->search = new twitter_search('json', 'cakefest');
		debug(Configure::read('Twitter'));
		$this->search->setOption('rpp', Configure::read('Twitter.per_request'));
	}
	
	/**
	 * getTweets function.
	 * 
	 * @access public
	 * @return void
	 */
	public function getTweets() {
		$sinceId = Cache::read('since_id');
		if (!empty($sinceId)) {
			$this->search->setOption('since_id', $sinceId);
		}
		
		$data = $this->search->search();
		
		debug($data);
		exit();
		
		if (!empty($data)) {
			$results = $data['results'];
			$since_id = $data['max_id'];
			$sinceId = $since_id;
			Cache::write('since_id', $sinceId);
			Cache::set(array('duration' => '+30 days'));
			if (!empty($results)) {
				foreach ($results as $tweet) {
					$tweetData = array(
						'Tweet' => array(
							'username' => $tweet['from_user'],
							'user_image' => $tweet['profile_image_url'],
							'twitter_id' => $tweet['from_user_id'],
							'tweet_id' => $tweet['id'],
							'content' => $tweet['text'],
							'from' => $tweet['source'],
							'created' => $tweet['created_at']
						)
					);
					$this->Tweet->save($tweetData);
					$user = $this->User->find('first', array(
						'conditions' => array('twitter_id' => $tweet['from_user_id'])
					));
					if (!empty($user)) {
						$userData = $user;
						$userData['User']['tweet_count'] = $user['User']['tweet_count'] + 1;
						$this->User->update($userData, $user);
					} else {
						$user = array(
							'User' => array(
								'username' => $tweet['from_user'],
								'user_image' => $tweet['profile_image_url'],
								'twitter_id' => $tweet['from_user_id'],
								'tweet_count' => 1
							)
						);
						$this->User->save($user);
						$this->Tweet->set('user_id', $this->User->id);
						$this->Tweet->save();
					}
				}
			}
		}
		return $data;
	}

}

?>
