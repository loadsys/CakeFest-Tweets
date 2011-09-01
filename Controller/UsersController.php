<?php
/**
 * Users Controller
 *
 * @extends AppController
 */
class UsersController extends AppController {

/**
 * uses
 * 
 * @var string
 * @access public
 */
	public $uses = array('Account', 'User');
	
/**
 * login function.
 * 
 * @access public
 * @return void
 */
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect(array('controller' => 'users', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email and password did not match a user'), 'default', array(), 'auth');
			}
		}
	}
	
/**
 * logout function.
 * 
 * @access public
 * @return void
 */
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	
/**
 * index function.
 * 
 * @access public
 * @return void
 */
	public function index() {
		$this->paginate = array(
			'conditions' => array('User.is_blacklist' => 0),
			'order' => array('User.tweet_count' => 'DESC')
		);
		$users = $this->paginate('User');
		$this->set(compact('users'));
	}
	
/**
 * blacklist function.
 * 
 * @access public
 * @param mixed $id
 * @return void
 */
	public function blacklist($id) {
		$this->User->blacklist($id);
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * participant function.
 * 
 * @access public
 * @param mixed $id
 * @return void
 */
	public function participant($id) {
		$this->User->participant($id, 1);
		$this->redirect($this->referer());
	}
	
/**
 * not_participant function.
 * 
 * @access public
 * @param mixed $id
 * @return void
 */
	public function not_participant($id) {
		$this->User->participant($id, 0);
		$this->redirect($this->referer());
	}
	
/**
 * winner function.
 * 
 * @access public
 * @return void
 */
	public function winner() {
		$winners = $this->User->winners(3);
		$this->set(compact('winners'));
	}

}
