<script>
$(document).ready(function() {
	$('#delete').click(function() {
	$('#message').fadeOut('slow');
	});
});
</script>
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
<button><?php echo $this->Html->link('Compose Message', array('controller' => 'messages', 'action' => 'createmessage')); ?></button>
<br>
<hr>
<?php foreach($messages as $message): ?>
<?php if ($this->Session->read('Auth.User.id') != $message['Message']['from_id']) { ?>
<div class="alert alert-info" id='message'>
	<h3>From: <?php echo $this->Html->link($message['Message']['from_id'], array('controller' => 'messages', 'action' => 'conversation', $this->Session->read('Auth.User.id')) ); ?></h3>
	<a href=""><h4><?php //echo $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<button id='#message'><?php echo $this->Html->link('View Conversation', array('controller' => 'messages', 'action' => 'conversation', $message['Message']['id'])); ?></button>
	<p id='delete'>click mes</p>
	<button onclick='$('#message').fadeOut(300, function());'><?php echo $this->Html->link('Delete', array('controller' => 'messages', 'id' => 'delete', 'action' => 'delete', $message['Message']['id']) ); ?></button>
</div>
<?php } else { ?>
<div class="alert alert-success from" id='message'>
	<h2><?php echo $this->Html->link($this->Session->read('Auth.User.name'), array('controller' => 'messages', 'id' => 'delete', 'action' => 'conversation', $this->Session->read('Auth.User.id')) ); ?></h2>
	<a href=""><h4><?php //echo $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<?php // echo $this->Form->submit('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?>	
	<button onclick='$('#message').fadeOut(300, function());'><?php echo $this->Html->link('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?></button>
</div>
<?php } ?>
<?php 
	endforeach;
	unset($message);
?>

<nav>
	<ul class="pager">
		<li><?php echo $this->Paginator->next(__('Show more..', true) . '', array(), null, array('class' => 'disabled'));?></li>
	</ul>
</nav>