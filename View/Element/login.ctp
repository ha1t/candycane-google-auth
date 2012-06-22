<tr>
	<td colspan="2">
      <?php
	  echo $this->Html->link(
		'Login with Facebook',
		ClassRegistry::getObject('Facebook')->getLoginurl(
			array(
				'scope' => 'email',
				 'redirect_uri' => $this->Html->url(array(
					 'controller' => 'accounts',
					 'action' => 'login',
					 'plugin' => 'cc_facebook'
				 ),true
				)
			)
		)
);
	  ?>
	</td>
</tr>