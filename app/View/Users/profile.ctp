<?php pr($profile); ?>
<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation" class="active"><?php echo $this->Html->link('Profile', array('action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted"><?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'home')); ?></h3>
</div>
<br>
<h2>Profile</h2>

<?php echo $this->Form->create('User', array('type' => 'file')); ?><br>	
<img src="" height="120" width="120" alt="">
<?php echo $this->Form->input('id', array('value' => $profile['id'], 'readonly')); ?>
<?php echo $this->Form->file('image'); ?>
<br>
Name: <?php echo $this->Form->input('name', array('class' => 'form-control', 'value' => $profile['name'], 'label' => false)); ?>
Birthdate: <?php echo $this->Form->date('birthdate', array('class' => 'form-control', 'value' => $profile['birthdate'])); ?>
Gender: 
<input type="radio" name="data[User][gender]" id="blankRadio1" value="1" <?php if ($profile['gender'] == 1) { echo 'checked = checked' ;} ?> >Male
<input type="radio" name="data[User][gender]" id="blankRadio1" value="2" <?php if ($profile['gender'] == 2) { echo 'checked = checked' ;} ?> >Female<br>

Hobby:<br>
<?php echo $this->Form->textarea('hubby', array('value' => $profile['hubby'])); ?><br><br>
<?php echo $this->Form->button(__('Update Profile'), array('class' => 'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>