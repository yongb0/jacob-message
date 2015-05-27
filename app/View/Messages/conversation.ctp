<?php // pr($messages); ?>
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
<?php foreach ($messages as $message) : ?>
<br>
<?php echo $this->Form->create('', array('controller' => 'messages', 'action' => 'reply/'. $message['Message']['from_id'] )); ?>
<?php endforeach; ?>
<?php echo $this->Form->textarea('content', array('class' => 'form-control', 'placeholder' => 'Reply..')); ?>
<?php echo $this->Form->button(__('Send'), array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
<br>
<hr>
<?php foreach($messages as $message): ?>
<?php if ($this->Session->read('Auth.User.id') != $message['Message']['from_id']) { ?>
<div class="alert alert-info">
	<h3>From: <?php echo $this->Html->link($message['User']['name'], array('controller' => 'messages', 'action' => 'conversation', $this->Session->read('Auth.User.id')) ); ?></h3>
	<a href=""><h4><?php //echo $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<?php // echo $this->Html->link('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?>
</div>
<?php } else { ?>
<div class="alert alert-success from">
<div class='float-left'>
<?php if ($this->Session->read('Auth.User.image') == '') { ?>
<?php echo $this->Html->image('default.png', array('height' => '120', 'width' => '120')); ?><br><br>
<?php } else { ?>
<?php echo $this->Html->image('upload/' . $this->Session->read('Auth.User.image'), array('id' => 'img', 'height' => '120', 'width' => '120')); ?><br>
<?php } ?> 
	</div>
	<a href=""><h4><?php //echo  $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<?php // echo $this->Form->submit('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?>	
	<?php // echo $this->Html->link('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?>
</div>
<?php } ?>
<?php endforeach; ?>


<?php unset($message); ?>
<nav>
	<ul class="pager">
		<li><?php echo $this->Paginator->next(__('Show more..', true) . '', array(), null, array('class' => 'enable'));?></li>
	</ul>
</nav>