<div class="users form">
	<p class="bg-warning"><?php echo $this->Session->flash('auth'); ?></p>
	<?php echo $this->Form->create('User', array('class' => 'form-signin')); ?>
		<h2 class="form-signin-heading">Please sign in</h2>
	        <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Username')); ?>
	        <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
	    	<?php echo $this->Form->button(__('Sign in'), array('class' => 'btn btn-lg btn-primary btn-block')); ?>
			<?php echo $this->Form->end(); ?>
			<?php
 echo $this->Html->link( "Add A New User",   array('action'=>'register')); 
?>
 	
</div>
