<?php
$pluginContainer = ClassRegistry::getObject('PluginContainer');
$pluginContainer->installed('cc_facebook','0.3');

$hookContainer = ClassRegistry::getObject('HookContainer');
$hookContainer->registerElementHook(
	'accounts/middlebox', // target element name.
	'../../Plugin/CcFacebook/View/Element/login', // additional template you want to inject.
	false // it should be true when you want to inject before the target template.
);

$hookContainer->registerElementHook(
	'issues/form', // target element name.
	'../../Plugin/CcFacebook/View/Element/posttofacebook', // additional template you want to inject.
	false // it should be true when you want to inject before the target template.
);

$settingContainer = ClassRegistry::getObject('SettingContainer');
$settingContainer->addSystemSetting(array(
	'name' => 'cc_facebook',
	'partial' => '../../Plugin/CcFacebook/View/Element/settings',
	'label' => __('Facebook Plugin')
));
if (!class_exists('Facebook')) {
	require_once 'Vendor/facebook-php-sdk/src/facebook.php';
}

$Setting = ClassRegistry::init('Setting');
$facebook = new Facebook(
	array(
		'appId' => $Setting->fb_appid,
		'secret' => $Setting->fb_secret,
	)
);
ClassRegistry::addObject('Facebook', $facebook);


App::uses('CakeEventManager', 'Event');
App::uses('ServiceFB', 'CcFacebook.Vendor');
$service = new ServiceFB();
CakeEventManager::instance()->attach(array($service,'afterIssueNewhandler'), 'Controller.Candy.issuesNewAfterSave');
CakeEventManager::instance()->attach(array($service,'afterIssueEdithandler'), 'Controller.Candy.issuesEditAfterSave');

