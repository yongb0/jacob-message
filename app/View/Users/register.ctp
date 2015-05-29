<!-- jQuery Form Validation code -->
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
 
	<?php echo $this->Form->create('User', array('id' => 'register-form'));?>
	    <fieldset>
	        <legend><?php echo __('Register'); ?></legend>
	        <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'name'));
	        echo $this->Form->input('email', array('class' => 'form-control', 'id' => 'email'));
	        echo $this->Form->input('password', array('class' => 'form-control', 'id' => 'password'));
	        echo $this->Form->input('password_confirm', array('class' => 'form-control','label' => 'Confirm Password *', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password')); ?>
            <br><?php echo $this->Form->submit('Register', array('class' => 'form-submit',  'title' => 'Click here to add the user')); ?>
	    </fieldset>
	<?php echo $this->Form->end(); ?>
</div>
<?php 
if ($this->Session->check('Auth.User')) {
echo $this->Html->link( "Return to Dashboard",   array('action'=>'index') ); 
echo "<br>";
echo $this->Html->link( "Logout",   array('action' => 'logout') ); 
}else{ ?>

<br><br>
<?php
echo $this->Html->link( "Return to Login Screen",   array('action'=>'login') ); 
}
?>