<?php pr($profile); ?>
<?php echo $this->Html->link('Return to Home', array('action' => 'home')); ?><br>
<br>

<?php echo $this->Form->create('User'); ?><br>	
<img src="" height="120" width="120" alt="">
<?php echo $this->Form->input('id', array('value' => $profile['id'], 'readonly')); ?>
<?php echo $this->Form->input('name', array('value' => $profile['name'])); ?><br>
Birthdate: <?php echo $this->Form->date('birthdate', array('value' => $profile['birthdate'])); ?>  <br>

<?php  

echo $this->Form->input('gender', array(
        'type' => 'radio',
        'before' => '<label class="col col-md-3 control-label">Gender</label>',
        'legend' => false,
        'class' => 'radio-btn',
        'options' => array(
            1 => 'Male',
            2 => 'Female' 
       	 ),
        'value' => $profile['gender']
       )); 
?>
Hobby:
<?php
	echo $this->Form->textarea('hubby', array('value' => $profile['hubby']));
	echo $this->Form->submit(__('Update Profile'));
	echo $this->Form->end();
?>