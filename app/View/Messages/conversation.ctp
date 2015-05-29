<?php // pr($messages); ?>
<script type="text/javascript">
	
	$(document).ready(function() {
		$("#action").submit(function(){
			var to = $("#from_id").val();
			var content = $("#content").val();
			var from = $("#from").val();
			var action = $("#action")[0].action;
			var data = {
				to : to,
				content : content
				from : from
			};

			if (content.length == 0 && to.length == 0) {
				alert('must contain!');
			} else {
				$.post(action, data, function(data) {
					alert(data);
				});

			}
			return false;

		});
	});



</script>
<script>
	function confirmation(e) {
    var answer = confirm("Are you sure?")
    if (!answer){ 
        e.preventDefault();
        return false;
    }
}
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

<?php foreach ($messages as $message) : ?>

<?php endforeach; ?>
<?php echo $this->Form->create('', array('controller' => 'messages', 'action' => 'reply/' .$message['Message']['from_id']  , 'id' => 'action'  )); ?>
<?php echo $this->Form->hidden('', array('value' => $message['Message']['from_id'], 'name' => 'data[Message][to_id]','id' => 'from_id')); ?>
<?php echo $this->Form->textarea('content', array('class' => 'form-control','id' => 'content', 'placeholder' => 'Reply..')); ?>
<?php echo $this->Form->button(__('Send'), array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
<br>
<hr>
<?php foreach($messages as $message): ?>
<?php if ($this->Session->read('Auth.User.id') != $message['Message']['from_id']) { ?>
<div class="alert alert-info">
		<?php echo $this->Html->image('upload/' . $message['User']['image'], array('id' => 'img', 'height' => '120', 'width' => '120')); ?><br>
	<h3>From: <?php echo $this->Html->link($message['User']['name'], array('controller' => 'users', 'action' => 'userprofile', $message['User']['id']) ); ?></h3>
	<a href=""><h4><?php //echo $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<?php  echo $this->Html->link('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id']), array('onclick' => "confirmation(event)")); ?>
</div>
<?php } else { ?>
<div class="alert alert-success from">
	<div class='float-left'>
		<?php echo $this->Html->image('upload/' . $message['User']['image'], array('id' => 'img', 'height' => '120', 'width' => '120')); ?><br>
	</div>
	<a href=""><h4><?php //echo  $message['Message']['from_id']; ?></h4></a>
	<p><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	 <?php // echo $this->Form->submit('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'])); ?>
	<?php  echo $this->Html->link('Delete', array('controller' => 'messages', 'action' => 'delete', $message['Message']['id'] ), array('onclick' => "confirmation(event)")); ?>
</div>
<?php } ?>
<?php endforeach; ?>


<?php unset($message); ?>
<nav>
	<ul class="pager">
		<li><?php echo $this->Paginator->next(__('Show more..', true) . '', array(), null, array('class' => 'enable'));?></li>
	</ul>
</nav>