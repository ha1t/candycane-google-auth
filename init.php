<?php
/*
 * @url https://developers.google.com/accounts/docs/OAuth2
 * @url http://code.google.com/p/google-api-php-client/wiki/OAuth2
 */

require_once 'Vendor/google-api-php-client/src/apiClient.php';
require_once 'Vendor/google-api-php-client/src/contrib/apiOauth2Service.php';

$plugin_name = 'CcGoogleAuth';

function is_set_settings($Settings)
{
    $columns = array(
        'google_client_id',
        'google_client_secret',
        'google_redirect_uri',
        //'google_developer_key',
        //'google_allow_domains',
        //'google_allow_emails',
    );

    foreach ($columns as $column) {
        if (!isset($Settings->$column)) {
            return false;
        }
    }

    return true;
}

$menuContainer = ClassRegistry::getObject('MenuContainer');
$menuContainer->addTopMenu(
    array(
        'url' => '/candycane_google_auth/google_projects/index',
        'class' => '',
        'caption' => 'Google Auth projects',
        'logged' => false,
        'admin' => false
    )
);

$pluginContainer = ClassRegistry::getObject('PluginContainer');
$pluginContainer->installed('cc_google_auth', '0.1');

$hookContainer = ClassRegistry::getObject('HookContainer');
$hookContainer->registerElementHook(
    'accounts/middlebox', // target element name.
    '../../Plugin/CcGoogleAuth/View/Element/login', // additional template you want to inject.
    false // it should be true when you want to inject before the target template.
);

$hookContainer->registerElementHook(
    'issues/form', // target element name.
    '../../Plugin/CcGoogleAuth/View/Element/posttofacebook', // additional template you want to inject.
    false // it should be true when you want to inject before the target template.
);

$settingContainer = ClassRegistry::getObject('SettingContainer');
$settingContainer->addSystemSetting(array(
    'name' => 'cc_google_auth',
    'partial' => '../../Plugin/CcGoogleAuth/View/Element/settings',
    'label' => __('Google Auth Plugin')
));

$Setting = ClassRegistry::init('Setting');
$columns = array(
    'google_client_id',
    'google_client_secret',
    'google_redirect_uri',
    'google_developer_key',
    'google_allow_domains',
    'google_allow_emails',
);

foreach ($columns as $column) {
    define(strtoupper($column), $Setting->$column);
}

//App::uses('CakeEventManager', 'Event');
//App::uses('ServiceFB', 'CcFacebook.Vendor');
//$service = new ServiceFB();
//CakeEventManager::instance()->attach(array($service,'afterIssueNewhandler'), 'Controller.Candy.issuesNewAfterSave');
//CakeEventManager::instance()->attach(array($service,'afterIssueEdithandler'), 'Controller.Candy.issuesEditAfterSave');

