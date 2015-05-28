 <?php  
 public function conversation($id = null) {

  	$this->loadModel('User');
  	$this->layout = 'main';
		$users = $this->User->find('all', array(
											'conditions' => array('id = '. $id)
										));

		$this->paginate = array(
			'limit' => 5,
			// 'conditions' => array('status' => '1', 'to_id' => $this->Session->read('Auth.User.id')),
			'conditions' => 'to_id = ' .$this->Session->read('Auth.User.id'). ' AND from_id = ' .$this->Session->read('Auth.User.id'). ' OR from_id = '.$id.' OR to_id = '.$id.' AND status = 1' ,
			'order' => array('Message.id' => 'desc')
			);

		$this->paginate = array(
			'User' => array(
						'joins' => array(
								'table' => 'users',
								'alias' => 'User',
								'conditions' => array('User.id = Message.to_id')
								),
						

					),
			'limit' => 5,
			'conditions' => 'to_id = ' .$this->Session->read('Auth.User.id'). ' AND from_id = ' .$this->Session->read('Auth.User.id'). ' OR from_id = '.$id.' OR to_id = '.$id.' AND status = 1' ,
			'order' => array('Message.id' => 'desc')
			);

		$messages = $this->paginate('Message');
		$this->set(compact('messages'));

	}
	/*	 	SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`, `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`, `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`, `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `db_message`.`messages` AS `Message` LEFT JOIN `db_message`.`users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE status = 1 OR to_id = 2 AND from_id = 2 ORDER BY `Message`.`id` desc LIMIT 5
*/
	/*'SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`,
	 	  `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`,
	 	   `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`,
	 	    `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `db_message`.`messages` AS `Message` LEFT JOIN
	 	     `db_message`.`users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE to_id = '.$this->Session->read('Auth.User.id').'
	 	      OR from_id = '.$this->Session->read('Auth.User.id').' AND
	 	      status = 1 ORDER BY `Message`.`id` desc LIMIT 5'*/

	?>