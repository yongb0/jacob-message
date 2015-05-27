<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation"><?php echo $this->Html->link('Profile', array('action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted">Home</h3>
</div>
<?php if ($profile['image'] == '') { ?>
	<?php echo $this->Html->image('default.png', array('height' => '120', 'width' => '120')); ?><br><br>
<?php	} else {?>
<?php echo $this->Html->image('upload/' . $profile['image'], array('height' => '120', 'width' => '120')); ?><br><br>
<?php } ?>
<b><?php echo ucfirst($profile['name']); ?></b><br><br>
<b><?php echo $profile['email']; ?></b><br><br>
Gender: <?php 
			if ($profile['gender'] == 1) {
				echo 'Male';
			} else {
				if ($profile['gender'] == 2) {
					echo 'Female';
				} else {
					echo '';
				}
			}			
		?><br><br>
		Birthdate: <?php echo $this->Time->format('M d, Y', $profile['birthdate']); ?><br><br>
	Joined: <?php echo $this->Time->format('M d, Y', $profile['created']); ?><br><br>
	Last Login: <?php echo $this->Time->format('M d, Y h:i', $profile['last_login_time']); ?><br><br>
	Hobby: <br><br>
<p><?php echo $profile['hobby']; ?></p>
