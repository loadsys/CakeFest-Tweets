<?php

class Pref extends AppModel {

	public $name = 'Pref';
	
	public function since_id($since_id = null) {
		$record = $this->find('first');
		if (empty($record)) {
			$this->create();
			$this->save();
			$record = $this->find('first');
		}
		$this->id = $record[$this->alias]['id'];
		if ($since_id != null) {
			$this->set('since_id', $since_id);
			$this->save();
			return $since_id;
		} else {
			return $record[$this->alias]['since_id'];
		}
	}

}
