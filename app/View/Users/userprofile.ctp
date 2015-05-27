<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation"><?php echo $this->Html->link('Profile', array('action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted"><?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'home')); ?></h3>
</div>

<?php foreach($users as $user) : ?>
<?php if ($user['User']['image'] == '') { ?>
	<?php echo $this->Html->image('default.png', array('height' => '120', 'width' => '120')); ?><br><br>
<?php	} else {?>
<?php echo $this->Html->image('upload/' . $user['User']['image'], array('height' => '120', 'width' => '120')); ?><br><br>
<?php } ?>
<b><?php echo ucfirst($user['User']['name']); ?></b><br><br>
<b><?php echo $user['User']['email']; ?></b><br><br>
Gender: <?php 
			if ($user['User']['gender'] == 1) {
				echo 'Male';
			} else {
				if ($user['User']['gender'] == 2) {
					echo 'Female';
				} else {
					echo '';
				}
			}			
		?><br><br>
		Birthdate: <?php echo $this->Time->format('M d, Y', $user['User']['birthdate']); ?><br><br>
	Joined: <?php echo $this->Time->format('M d, Y', $user['User']['created']); ?><br><br>
	Last Login: <?php echo $this->Time->format('M d, Y h:i', $user['User']['last_login_time']); ?><br><br>
	Hobby: <br><br>
<p><?php echo $user['User']['hobby']; ?></p>
<?php endforeach; ?>