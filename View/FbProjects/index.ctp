<div class="splitcontentleft">
<h2><?php echo __d('cc_facebook', 'Your projects with Facebook group'); ?></h2>
<?php foreach ($fbprojects as $project): ?>
<h3><?php
	echo $this->Html->link(
		$project['Project']['name'],
		array(
			'plugin' => '',
			'controller' => 'projects',
			'action' => 'show',
			$project['Project']['identifier']
		),
		array(
			'class' => 'icon icon-fav'
		)
	); ?></h3>
<?php endforeach; ?>
</div>
<div class="splitcontentright">
<?php echo $this->Form->create(false,array('action' => 'index')); ?>
<h2><?php echo __d('cc_facebook', 'Create New Project for Facebook Group');?></h2>
<p>
<?php
	echo $this->Form->select(
		'group',
		$groups
	);
?>
</p>
<p>
<label class="floating">
<?php
//echo $this->Form->checkbox(
//	'.posttofacebook',
//	array(
//		'value' => 1,
//	));
?>
<?php //echo __d('cc_facebook', 'Post created project url to wall of Facebook Group'); ?>
</label>
<?php echo $this->Form->submit(__d('cc_facebook', 'Create new project for this group')); ?>
<?php echo $this->Form->end(); ?>
</p>
</div>