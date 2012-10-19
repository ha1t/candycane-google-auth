<?php
function is_set_settings($Settings)
{
    $columns = array(
        'google_client_id',
        'google_client_secret',
        'google_redirect_uri',
        'google_developer_key',
        'google_allow_domains',
        'google_allow_emails',
    );

    foreach ($columns as $column) {
        if (!isset($Settings->$column)) {
            return false;
        }
    }

    return true;
}
?>
<tr>
    <td colspan="2" style="text-align: center;">
<?php
if (is_set_settings($Settings)) {
    echo __('configure google auth settings in administrator dashboard.');
} else {
    // TODO: ログインURLの作成
    $facebook = new Facebook();
    echo $this->Html->link(
        "google auth login",
        $facebook->getLoginurl(
            array(
                'scope' => 'email,user_groups,publish_stream',
                'redirect_uri' => $this->Html->url(array(
                    'controller' => 'accounts',
                    'action' => 'login',
                    'plugin' => 'cc_facebook',
                    '?' => array('back_url' => $back_url)
                ),true)
            )
        ),
        array('escape' => false)
    );
}	  ?>
    </td>
</tr>
