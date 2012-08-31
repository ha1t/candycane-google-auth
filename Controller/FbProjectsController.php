<?php
class FbProjectsController extends CcFacebookAppController {

	public $uses = array(
		'Project',
		'CustomValue',
		'CustomField',
		'Member',
		'EnabledModule',
		'ProjectsTracker',
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->require_login();
	}
	
	public function index() {
		
		$facebook = ClassRegistry::getObject('Facebook');
		$groups = $facebook->api('/me/groups');
		$ids = Set::extract('{n}.id',$groups['data']);		
		$data = $this->CustomValue->find('all',array(
			'conditions' => array(
				'value' => $ids
			)
		));
				
		$fbprojects = $this->Project->find('all',array(
			'conditions' => array(
				'Project.id' => Set::extract('{n}.CustomValue.customized_id',$data)
			)
		));
		$this->set('fbprojects',$fbprojects);
		$groups = Set::combine($groups,'data.{n}.id','data.{n}.name');
		foreach ($fbprojects as $row) {
			foreach($row['CustomValue'] as $custom) {
				if ($custom['CustomField']['name'] == 'fbgroup' && in_array($custom['value'], $ids)) {
					unset($groups[$custom['value']]);
				}
			}
		}
		
		$this->set('groups', $groups);
		
		if ($this->request->is('post') && isset($groups[$this->request->data['group']])) {
			$this->create(
				$groups[$this->request->data['group']],
				$this->request->data['group']
			);
		}
		
	}
	
	protected function create($name, $fbgroup) {
		
		$custom_field = $this->CustomField->find(
			'first',
			array(
				'conditions' => array(
					'type' => 'ProjectCustomField',
					'name' => 'fbgroup'
				)
			)
		);		
		$custom_field_id = $custom_field['CustomField']['id'];
		
		$data = array(
			'Project' => array(
				'name' => $name,
				'is_public' => 0,
				'identifier' => 'fb-' . $fbgroup,
				'status' => 1,
			),
			'Member' => array(
				'role_id' => 3,
				'user_id' => $this->current_user['id']
			)
		);
		
		//crete project
		$project = $this->Project->save($data);
		
		//add user as manager
		$data = array(
			'Member' => array(
				'project_id' => $project['Project']['id'],
				'role_id' => 3,
				'user_id' => $this->current_user['id']
			)
		);
		$this->Member->save($data);
		
		//add fbgroup id into custom value
		$data = array(
			'CustomValue' => array(
				'customized_type' => 'Project',
				'customized_id' => $project['Project']['id'],
				'custom_field_id' => $custom_field_id,
				'value' => $fbgroup
			),
		);
		$this->CustomValue->save($data);
		
		$this->EnabledModule->save(array(
			'project_id' => $project['Project']['id'],
			'name' => 'issue_tracking'
		));
		
		$this->ProjectsTracker->save(array(
			'project_id' => $project['Project']['id'],
			'tracker_id' => 1
		));
		
		$this->Session->setFlash(__('Successful creation.'), 'default', array('class'=>'flash notice'));
		$this->redirect('index');
	}
}
