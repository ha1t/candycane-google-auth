<?php
	class AccountsController extends CcFacebookAppController {
		
		public $uses = array(
			'User'
		);
		
	public function login() {
		$facebook = ClassRegistry::getObject('Facebook');
		$me = $facebook->api('/me');
		$conditions = array(
			'User.mail' => $me['email']
		);
		$data = $this->User->find('all',compact('conditions'));
		
		if (count($data) !== 1) {
			$this->redirect('/account/login');			
		}
		
		$this->logged_user($data[0]);
		$this->redirect('/');

	}
	
	public function logged_user($user) {
		if (isset($user['User'])) {
			$user = $user['User'];
		}
		if (isset($user) && is_array($user)) {
			$this->currentuser = $this->User->findById($user['id']);
			$this->Session->write('user_id', $user['id']);
		} else {
			$this->currentuser = null;
			$this->Session->write('user_id', null);
		}
	}
}

