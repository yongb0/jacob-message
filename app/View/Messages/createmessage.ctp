<?php echo $this->Html->script('message'); ?>
<script>var baseURL = '<?php echo $this->webroot; ?>';</script>
<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation"><?php echo $this->Html->link('Profile', array('controller' => 'users' ,'action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('controller' => 'users' ,'action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted"><?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'home')); ?></h3>
</div>
<h1>Create New Message</h1>
<?php echo $this->Form->create('Message'); ?>
<?php echo $this->Form->input('',array('type' => 'text', 'name' => 'data[User][name]', 'id' => 'search_name','class' => 'form-control', 'placeholder' => 'Send to', 'value' => '')); ?><br>
<table>
	<tbody id='result'>
	</tbody>
</table>
<?php echo $this->Form->textarea('content',array('type'=>'text', 'name' => 'data[Message][content]', 'class' => 'form-control', 'placeholder' => 'Message', 'style' => 'margin: 0px; width: 490px; height: 100px;')); ?><br>
<?php echo $this->Form->submit(__('Send')); ?>
<?php echo $this->Form->end(); ?>