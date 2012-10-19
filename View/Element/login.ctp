<?php
App::uses('GoogleAuth', 'CcGoogleAuth.Model');
?>
<tr>
    <td colspan="2" style="text-align: center;">
<?php
if (is_set_settings($Settings)) {
    // TODO: ログインURLの作成
    $google_auth = ClassRegistry::getObject('GoogleAuth');
    echo $this->Html->link(
        "google auth login",
        GoogleAuth::getAuthUrl(),
        array('escape' => false)
    );
} else {
    echo __('configure google auth settings in administrator dashboard.');
}	  ?>
    </td>
</tr>
