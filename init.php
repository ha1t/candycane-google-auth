<?php
$pluginContainer = ClassRegistry::getObject('PluginContainer');
$pluginContainer->installed('cc_facebook','0.1');

$hookContainer = ClassRegistry::getObject('HookContainer');
$hookContainer->registerElementHook(
	'accounts/middlebox', // target element name.
	'../../Plugin/CcFacebook/View/Element/login', // additional template you want to inject.
	false // it should be true when you want to inject before the target template.
);

require_once 'Vendor/facebook-php-sdk/src/facebook.php';
$facebook = new Facebook(
	array(
		'appId' => '127953654009621',
		'secret' => '4a38882fe46f835807342bc075dcf216',
	)
);
ClassRegistry::addObject('Facebook', $facebook);