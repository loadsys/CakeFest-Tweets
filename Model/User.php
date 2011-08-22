<?php

class User extends AppModel {

	public $name = 'User';
	
	public function update_user_count($twitter_id) {
		$user = $this->find('first', array(
			'conditions' => array(
				'User.twitter_id' => $twitter_id
			)
		));
		$user[$this->alias]['tweet_count'] = $user[$this->alias]['tweet_count'] + 1;
		return $this->save($user);
	}

	public function top_ten() {
		$users = $this->find('all', array(
			'limit' => 10,
			'order' => array('User.tweet_count' => 'DESC')
		));
		return $users;
	}

}
