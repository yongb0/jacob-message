<?php echo $this->Html->script('bootstrap.min'); ?>
<script>
  
  // When the browser is ready...
  $(document).ready(function() {
  
    // Setup form validation on the #register-form element
    $("#register-form").validate({
    
        // Specify the validation rules
        rules: {
            name: {
            	required: true,
            	minlength: 5
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        
        // Specify the validation error messages
        messages: {
            name: "Please enter your first name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
</script>

<div class="users form">
	<p class="bg-warning"><?php echo $this->Session->flash('auth'); ?></p>
	<?php echo $this->Form->create('User', array('class' => 'form-signin')); ?>
		<h2 class="form-signin-heading">Please sign in</h2>
	        <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Username')); ?>
	        <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
	    	<?php echo $this->Form->button(__('Sign in'), array('class' => 'btn btn-lg btn-primary btn-block')); ?>
			<?php echo $this->Form->end(); ?>
			<hr>
			No Account? <?php // echo $this->Html->link( "Register",  array('action'=>'register')); ?> 


<!-- Small modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Register Here!</button>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	    	<div class="modal-header">
	    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	    			<span aria-hidden="true">x</span>
	    		</button>
	    		<h4 class="modal-title">Register</h4>		
	    	</div>
	    	<div class="modal-body">
	    		<div class="users form">
					<?php echo $this->Form->create('User', array('id' => 'register-form', 'action' => 'register'));?>
					    <fieldset>
					        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'name'));
					        echo $this->Form->input('email', array('class' => 'form-control', 'id' => 'email'));
					        echo $this->Form->input('password', array('class' => 'form-control', 'id' => 'password'));
					        echo $this->Form->input('password_confirm', array('class' => 'form-control','label' => 'Confirm Password *', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password')); ?>
				            <br><?php echo $this->Form->submit('Register', array('class' => 'form-submit',  'title' => 'Click here to add the user')); ?>
					    </fieldset>
					<?php echo $this->Form->end(); ?>
				</div>
	    	</div>
	    </div>
	  </div>
	</div>
</div>
