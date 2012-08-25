<?php
$is_facebook = false;
foreach ($main_project['CustomValue'] as $row) {
	if ($row['CustomField']['name'] == 'fbgroup' && $row['value']) {
		$is_facebook = true;
	}
}
$is_facebook_login = false;
if(ClassRegistry::getObject('Facebook')->getUser()){
	$is_facebook_login = true;
}
?>
<?php if($is_facebook): ?>
<p>
<label>Facebook</label>
<label class="floating">
<?php
echo $this->Form->checkbox(
	'.posttofacebook',
	array(
		'value' => 1,
		'disabled' => $is_facebook_login ? 'none' : 'disabled'
	));
?>
<?php echo __('Post update to wall of Facebook Group'); ?>
</label>
</p>
<?php endif; ?>