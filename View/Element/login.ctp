<tr>
	<td colspan="2" style="text-align:center">
      <?php
	  if (
		!isset($Settings->fb_appid) || !isset($Settings->fb_secret)
		|| empty($Settings->fb_appid) || empty($Settings->fb_secret)
	  ) {
		  echo __('configure fb_appid and fb_secret in administrator dashboard.');
	  } else {
	  $facebook = new Facebook(
			array(
				'appId' => $Settings->fb_appid,
				'secret' => $Settings->fb_secret,
			)
	);
	  echo $this->Html->link(
		$this->Html->image('/cc_facebook/img/facebook.png'),
		$facebook->getLoginurl(
			array(
				'scope' => 'email',
				 'redirect_uri' => $this->Html->url(array(
					 'controller' => 'accounts',
					 'action' => 'login',
					 'plugin' => 'cc_facebook'
				 ),true
				)
			)
		),
		array('escape' => false)
);
	  }	  ?>
	</td>
</tr>