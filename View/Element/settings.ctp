<?php echo $this->Form->create(
	'Setting',
	array(
		'action' => 'edit',
		'url' => array('?' => 'tab=cc_google_auth')
	)
); ?>

<div class="box tabular settings">

<p><label><?php echo __('Google Cliend Id') ?></label>
<?php echo $this->Form->input(
	'google_client_id',
	array(
		'type' => 'text',
		'value' => $Settings->google_client_id,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

<p><label><?php echo __('Google Client Secret') ?></label>
<?php echo $this->Form->input(
	'google_client_secret',
	array(
		'value' => $Settings->google_client_secret,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

<p><label><?php echo __('Google Redirect URI') ?></label>
<?php echo $this->Form->input(
	'google_redirect_uri',
	array(
		'value' => $Settings->google_redirect_uri,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

<!--
<p><label><?php echo __('Google Developer Key') ?></label>
<?php echo $this->Form->input(
	'google_developer_key',
	array(
		'value' => $Settings->google_developer_key,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>
-->

<p><label><?php echo __('Google Allow Domains') ?></label>
<?php echo $this->Form->input(
	'google_allow_domains',
	array(
		'value' => $Settings->google_allow_domains,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

<p><label><?php echo __('Google Allow Emails') ?></label>
<?php echo $this->Form->input(
	'google_allow_emails',
	array(
		'value' => $Settings->google_allow_emails,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

</div>

<?php echo $this->Form->submit(__('Save')) ?>
<?php echo $this->Form->end(); ?>
