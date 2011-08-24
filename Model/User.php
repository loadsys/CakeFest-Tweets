<?php
/**
 * User Model
 *
 * @extends AppModel
 */
class User extends AppModel {

/**
 * name
 * 
 * @var string
 * @access public
 */
	public $name = 'User';
	
/**
 * hasMany
 * 
 * @var string
 * @access public
 */
	public $hasMany = array('Tweet');
	
/**
 * update_user_count function.
 * 
 * @access public
 * @param mixed $twitter_id
 * @return void
 */
	public function update_user_count($twitter_id) {
		$user = $this->find('first', array(
			'conditions' => array(
				'User.twitter_id' => $twitter_id
			)
		));
		$user[$this->alias]['tweet_count'] = $user[$this->alias]['tweet_count'] + 1;
		return $this->save($user);
	}

/**
 * top_ten function.
 * 
 * @access public
 * @return void
 */
	public function top_ten() {
		$users = $this->find('all', array(
			'conditions' => array('User.is_blacklist' => 0),
			'limit' => 10,
			'order' => array('User.tweet_count' => 'DESC')
		));
		return $users;
	}
	
/**
 * blacklist function.
 * 
 * @access public
 * @param mixed $id
 * @return void
 */
	public function blacklist($id) {
		$this->id = $id;
		$user = $this->read();
		if (empty($user)) { return false; }
		$this->set('is_blacklist', 1);
		$tweets = $this->Tweet->findAllByUserId($id);
		foreach ($tweets as &$tweet) {
			$tweet['Tweet']['is_blacklist'] = 1;
		}
		return ($this->Tweet->saveAll($tweets) && $this->save());
	}

}
