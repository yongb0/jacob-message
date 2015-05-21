<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation"><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation" class="active"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('controller' => 'users' ,'action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted"><?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'home')); ?></h3>
</div>

<h2>Messages</h2>
<a href="/messages/createmessage"><button>Compose Message</button></a>
<br>
<hr>
	<?php 

		$count = 0;
		foreach($messages as $message):
			$count++;
		if ($count % 1) { echo '<tr>'; } else  echo '<tr class="zebra">'
		
	 ?>
<div class="alert alert-info">
<h2><?php echo $this->Html->link($message['Message']['from_id'], array('controller' => 'messages', 'action' => 'conversation', $this->Session->read('Auth.User.id')) ); ?></h2>
	<a href=""><h4><?php //echo $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<?php // echo $this->Form->submit('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?>	
	<button><?php echo $this->Html->link('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?></button>
</div>
<?php 
	endforeach;
	unset($message);
?>
<nav>
	<ul class="pager">
		<li><a href="" title="">Show more..</a></li>
	</ul>
</nav>