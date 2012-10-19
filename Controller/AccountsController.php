<?php
class AccountsController extends AppController
{
    public $uses = array(
        'User',
    );

    public function login()
    {
        App::uses('GoogleAuth', 'CcGoogleAuth.Model');

        $code = $_GET['code'];
        try {
            $result = GoogleAuth::verify($code);
        } catch (Exception $e) {
            $this->redirect('/');
            return;
        }

        $conditions = array(
            'OR' => array(
                'User.mail' => $result['email'],
                'login'     => 'google:' . $result['id'],
            ),
        );
        $data = $this->User->find('all', array('conditions' => $conditions));

        if (count($data) > 1) {
            $this->Session->setFlash(__('dupulicated user account'), 'default', array('class' => 'flash flash_error'));
            $this->redirect('/account/login');
        }

        // create user
        if (count($data) == 0) {
            $new_user = array(
                'login' => 'google:' . $result['id'],
                'firstname' => $result['given_name'],
                'lastname' => $result['family_name'],
                'mail' => $result['email'],
                'admin' => 0,
                'status' => 1,
            );
            $registered_data = $this->User->save($new_user);
            if ($registered_data == false) {
                $this->Session->setFlash(__('fail registering user account'), 'default', array('class' => 'flash flash_error'));
                $this->redirect('/account/login');
            }
            $data = $this->User->find('all', array('conditions' => $conditions));
        }

        if ( $data[0]['User']['status'] !== '1' ) {
            $this->Session->setFlash(__('account is not active.'), 'default', array('class' => 'flash flash_error'));
            $this->redirect('/account/login');
        }

        $this->logged_user($data[0]);

        if (isset($this->request->query['back_url'])) {
            $this->redirect($this->request->query['back_url']);
        } else {
            $this->redirect('/');
        }
    }

    public function logged_user($user)
    {
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

