<?php
class ServiceFB {
	
	/**
	 * @var Facebook 
	 */
	protected $facebook;
	
	
	public function __construct() {
		
		$this->facebook = ClassRegistry::getObject('Facebook');
		
	}
	
	/**
	 * event handler method for IssueNew 
	 */
	public function afterIssueNewhandler($event) {
		
		$fbroup = null;
		foreach($event->data['project']['CustomValue'] as $row) {
			if ($row['CustomField']['name'] == 'fbgroup') {
				$fbgroup = $row['value'];
				break;
			}
		}
		if (!$fbgroup) {
			return false;
		}
		
		if ($this->facebook->getUser() == 0) {
			return false;
		}
		
		$data = $event->data['save_data'];
		$ret = $this->facebook->api(
			'/' . $fbgroup . '/feed',
			'post',
			array(
				'link' => Router::url(array(
					'controller' => 'issues',
					'action' => 'show',
					'issue_id' => $event->data['issue']->id
				), true),
				'message' => $data['Issue']['description'],
				'name' => $data['Issue']['subject'],
				'description' => __('New issue is created.')
			)
		);
	}
	
	/**
	 * event handler method for IssueEdit
	 */
	public function afterIssueEdithandler($event) {
		$fbroup = null;
		foreach($event->data['project']['CustomValue'] as $row) {
			if ($row['CustomField']['name'] == 'fbgroup') {
				$fbgroup = $row['value'];
				break;
			}
		}
		if (!$fbgroup) {
			return false;
		}
		
		if ($this->facebook->getUser() == 0) {
			return false;
		}
		
		$data = $event->data['save_data'];
		$ret = $this->facebook->api(
			'/' . $fbgroup . '/feed',
			'post',
			array(
				'link' => Router::url(array(
					'controller' => 'issues',
					'action' => 'show',
					'issue_id' => $event->data['issue']->id
				), true),
				'message' => $event->data['notes'],
				'name' => $data['Issue']['subject'],
				'description' => __('Issue is updated.')
			)
		);		
	}
	
	
}
