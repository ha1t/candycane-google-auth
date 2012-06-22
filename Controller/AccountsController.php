<?php
	class AccountsController extends CcFacebookAppController {
		
		public $uses = array(
			'User'
		);
		
	public function login() {
		$facebook = new Facebook(
			array(
				'appId' => $this->Setting->fb_appid,
				'secret' => $this->Setting->fb_secret,
			)
		);
		ClassRegistry::addObject('Facebook', $facebook);

		$me = $facebook->api('/me');
		$conditions = array(
			'User.mail' => $me['email']
		);
		$data = $this->User->find('all',compact('conditions'));
		
		if (count($data) > 1) {
			$this->Session->setFlash(__('dupulicated user account'), 'default', array('class' => 'flash flash_error'));
			$this->redirect('/account/login');			
		}
		
		if ( count($data) == 0 ) {
			$new_user = array(
				'login' => 'fb:' . $me['id'],
				'firstname' => $me['first_name'],
				'lastname' => $me['last_name'],
				'mail' => $me['email'],
				'admin' => 0,
				'status' => 1,	
			);
			$registered_data = $this->User->save($new_user);
			if ($registered_data == false) {
				$this->Session->setFlash(__('fail registering user account'), 'default', array('class' => 'flash flash_error'));
				$this->redirect('/account/login');					
			}
			$data = $this->User->find('all',compact('conditions'));
		}

		if ( $data[0]['User']['status'] !== '1' ) {
			$this->Session->setFlash(__('account is not active.'), 'default', array('class' => 'flash flash_error'));
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
			$this->User->id = $user['id'];
			$this->User->saveField('last_login_on', date('Y-m-d H:i:s'));
		} else {
			$this->currentuser = null;
			$this->Session->write('user_id', null);
		}
	}
}

