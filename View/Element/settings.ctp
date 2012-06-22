<?php echo $this->Form->create(
	'Setting',
	array(
		'action' => 'edit',
		'url' => array('?' => 'tab=cc_facebook')
	)
); ?>

<div class="box tabular settings">
<p><label><?php echo __('Facebook AppId') ?></label>
<?php echo $this->Form->input(
	'fb_appid',
	array(
		'value' => $Settings->fb_appid,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

<p><label><?php echo __('Secret Key') ?></label>
<?php echo $this->Form->input(
	'fb_secret',
	array(
		'value' => $Settings->fb_secret,
		'size' => 60,
		'label' => false,
		'div' => false
	)
);?></p>

<p>
<?php echo __('to obtain appid and secret, visit facebook developers page.'); ?><br/>
<?php echo $this->Html->link(
	'Visit Facebook Developers page',
	'https://developers.facebook.com/apps/?action=create'
);?>
</p>

</div>

<?php echo $this->Form->submit(__('Save')) ?>
<?php echo $this->Form->end(); ?>
