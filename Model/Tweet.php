<?php

class Tweet extends AppModel {

	public $name = 'Tweet';
	
	public $belongsTo = array('User');
	
	public function new_tweets_since($since_id = null) {
		if (!$since_id) {
			$since_id = ClassRegistry::init('Pref')->since_id();
		}
		$tweets = $this->find('all', array(
			'conditions' => array(
				'Tweet.tweet_id >=' => $since_id
			)
		));
		return $tweets;
	}
	
	/**
	 * Uses the TwitterSearch lib to load tweets into the
	 * local database.
	 * 
	 * @access public
	 * @param mixed $search
	 * @return void
	 */
	public function load_tweets($search) {
		App::import('Lib', 'TwitterSearch');
		$Pref = ClassRegistry::init('Pref');
		$since_id = 
		$TwitterSearch = new TwitterSearch('json', $search);
		$TwitterSearch->setOption('rpp', 30);
		$tweet = ClassRegistry::init('Tweet')->find('first', array(
			'order' => array('Tweet.id' => 'DESC')
		));
		if (!empty($tweet)) {
			$TwitterSearch->setOption('since_id', $tweet['Tweet']['tweet_id']);
		}
		$results = $TwitterSearch->search();
		$id = null;
		for ($i = count($results['results']) - 1; $i >= 0; $i--) {
			$id = $this->save_tweet($results['results'][$i]);
		}
		if ($id != null) {
			$Pref->since_id($id);
		}
	}
	
	/**
	 * Using the tweets loaded from the search api, save tweet
	 * records into the database. Also increments the user
	 * record for their tweet count.
	 * 
	 * @access public
	 * @param mixed $tweet
	 * @return void
	 */
	public function save_tweet($tweet) {
		$record = $this->find('first', array(
			'conditions' => array(
				'Tweet.tweet_id' => $tweet['id']
			)
		));
		if (empty($record)) {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.twitter_id' => $tweet['from_user_id']
				)
			));
			if (empty($user)) {
				$this->User->create();
				$this->User->save(array('User' => array(
					'username' => $tweet['from_user'],
					'twitter_id' => $tweet['from_user_id'],
					'user_image' => $tweet['profile_image_url'],
					'tweet_count' => 1
				)));
				$user_id = $this->User->id;
			} else {
				$user['User']['tweet_count'] += 1;
				$this->User->save($user);
				$user_id = $this->User->id;
			}
			$this->create();
			$this->save(array('Tweet' => array(
				'username' => $tweet['from_user'],
				'user_image' => $tweet['profile_image_url'],
				'user_id' => $user_id,
				'twitter_id' => $tweet['from_user_id'],
				'tweet_id' => $tweet['id'],
				'tweet_datetime' => $tweet['created_at'],
				'content' => $tweet['text'],
				'from' => $tweet['source']
			)));
			return $this->id;
		}
	}

}
