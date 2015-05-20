<h1>this is home page</h1>
<?php echo $this->Html->link('Profile', array('action' => 'profile', $this->Session->read('Auth.User.id'))); ?> || 
<?php echo $this->Html->link('Message', array('action' => 'message')); ?> || 
<?php echo $this->Html->link('Logout', array('action' => 'logout')); ?><br><br>
<img src="" height="120" width="120" alt=""><br><br>
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
