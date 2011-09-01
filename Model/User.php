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
		$this->set('is_participant', 0);
		$tweets = $this->Tweet->findAllByUserId($id);
		foreach ($tweets as &$tweet) {
			$tweet['Tweet']['is_blacklist'] = 1;
		}
		return ($this->Tweet->saveAll($tweets) && $this->save());
	}

/**
 * participant function.
 * 
 * @access public
 * @param mixed $id
 * @param mixed $allowed
 * @return void
 */
	public function participant($id, $allowed) {
		$this->id = $id;
		$user = $this->read();
		if (empty($user)) { return false; }
		$this->set('is_participant', $allowed);
		return $this->save();
	}
	
/**
 * winners function.
 * 
 * @access public
 * @param mixed $count
 * @return void
 */
	public function winners($count) {
		$winners = array();
		for ($i = 0; $i < $count; $i++) {
			$winner = $this->winner();
			if (array_key_exists($winner, $winners) === false) {
				$winners[$winner] = $winner;
			} else {
				$i--;
			}
		}
		return $winners;
	}

/**
 * winner function.
 * 
 * @access public
 * @return void
 */
	public function winner() {
		$users = $this->find('all', array(
			'conditions' => array(
				'User.is_blacklist' => 0,
				'User.is_participant' => 1
			)
		));
		$participants = array();
		foreach ($users as $user) {
			$name = $user['User']['username'];
			for ($i = 0; $i < $user['User']['tweet_count']; $i++) {
				array_push($participants, $name);
			}
		}
		return $participants[rand(0, count($participants) - 1)];
	}

}
