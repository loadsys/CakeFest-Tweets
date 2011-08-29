<?php

class TweetsController extends AppController {
	
/**
 * uses
 * 
 * @var array
 * @access public
 */
	public $uses = array('Pref', 'Tweet', 'User');
	
/**
 * beforeFilter function.
 * 
 * @access public
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'tweets', 'users', 'get_tweets_from_twitter');
	}
	
/**
 * index function.
 * 
 * @access public
 * @return void
 */
	public function index() {}

/**
 * Load Tweets that are saved in the local database for the initial 
 * page load. After page load, ajax will be used to load new tweets
 * and prepend them to the list
 *
 * @access public
 * @return void
 */
	public function tweets($since_id = null) {
		$this->layout = false;
		$tweets = $this->Tweet->find('all', array(
			'conditions' => array('Tweet.is_blacklist' => 0),
			'order' => array('Tweet.id' => 'DESC'),
			'limit' => 100
		));
		$tweets = array_reverse($tweets);
		if (empty($tweets)) {
			$tweets = array();
		} else {
			foreach ($tweets as $key => $tweet) {
				if ($tweet['Tweet']['id'] <= $since_id) {
					unset($tweets[$key]);
				} else {
					$tweets[$key]['Tweet']['from'] = html_entity_decode($tweets[$key]['Tweet']['from']);
				}
			}
			$ids = Set::extract('/Tweet/id', $tweets);
			if (!empty($ids)) {
				$since_id = max($ids);
			}
			
		}
		
		$this->set(compact('since_id', 'tweets'));
	}
	
/**
 * get_users function.
 * 
 * @access public
 * @return void
 */
	public function users() {
		$this->layout = false;
		$users = $this->User->top_ten();
		$this->set(compact('users'));
	}
	
/**
 * get_tweets_from_twitter function.
 * 
 * @access public
 * @return void
 */
	public function get_tweets_from_twitter() {
		$this->layout = false;
		$this->Tweet->load_tweets('cakefest');
		exit();
	}

}
