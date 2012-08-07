<?php
$pluginContainer = ClassRegistry::getObject('PluginContainer');
$pluginContainer->installed('cc_facebook','0.2');

$hookContainer = ClassRegistry::getObject('HookContainer');
$hookContainer->registerElementHook(
	'accounts/middlebox', // target element name.
	'../../Plugin/CcFacebook/View/Element/login', // additional template you want to inject.
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
