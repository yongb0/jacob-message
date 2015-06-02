<?php

public function message() {
		$this->loadModel('Message');
		$this->layout= 'main';
		$
		$this->paginate = array(
				'Message' => array(
					'joins' => array(
								'table' => 'users',
								'alias' => 'User',
								'type' => 'left',
								'conditions' => array('Message.to_id = User.id'),
								),
					
					),
				
				'limit' => 5,
				'order' => array('Message.id' => 'desc'),
				'conditions' => array('to_id = '.$this->Session->read('Auth.User.id').' OR from_id = ' .$this->Session->read('Auth.User.id'). ' AND  status = 1')
			);
		// $messages = $this->Message->find('all');
		// $this->set('messages', $messages);

		$messages = $this->paginate('Message');
		$this->set('messages', $messages);

	}

	// sample syntax for joining!
	public function user() {

		$this->paginate = array(
	    'conditions' => array('User.id' => $this->Auth->user('id')),
	    'joins' => array(
	        array(
	            'alias' => 'User',
	            'table' => 'users',
	            'type' => 'INNER',
	            'conditions' => '`User`.`id` = `Widget`.`user_id`'
	        )
	    ),
	    'limit' => 20,
	    'order' => array(
	        'created' => 'desc'
		    )
		);
		$this->set( 'widgets', $this->paginate( $this->Widget ) );
	}


	// 6/2/2015
	
	// public  function message() {
	// $this->layout = 'main';
 	// $db = ClassRegistry::init('Message')->getDataSource();
 	// $data = $db->fetchAll(
	//  	 'SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`,
	//  	  `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`,
	//  	   `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`,
	//  	    `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `messages` AS `Message` LEFT JOIN
	//  	     `users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE to_id = '.$this->Session->read('Auth.User.id').' AND
	//  	      status = 1 OR from_id = '.$this->Session->read('Auth.User.id').'  ORDER BY `Message`.`id` desc LIMIT 10'
	//   		);
	// $this->set('messages', $data);

	// $this->loadModel('User');
	// $Users = $this->User->find('all');
	// $this->set('users', $Users);
	// }
?>