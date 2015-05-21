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

<img src="<?php echo $this->webroot; ?>img/upload/jake.jpg" height="120" width="120" alt=""><br><br>
<b><?php echo ucfirst($profile['name']); ?></b><br><br>
Gender: <?php 
			if ($profile['gender'] == 1) {
				echo 'Male';
			} else {
				if ($profile['gender'] == 2) {
					echo 'Female';
				} else {
					echo 'Unspecified';
				}
			}

			
		?><br><br>
Birthdate: <?php echo $profile['birthdate']; ?><br><br>
Joined: <?php echo $profile['created']; ?><br><br>
Last Login: <?php echo $profile['last_login_time']; ?><br><br>
Hobby: <br><br>
<p><?php echo $profile['hubby']; ?></p>
