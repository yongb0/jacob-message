<?php  

class MessagesController extends AppController {


	public function index() {

		$this->paginate = array(
			'limit' => 5,
			'conditions' => array('status' => '1'),
			'order' => array('Message.created' => 'desc')
			);

		$messages = $this->paginate('Message');
		$this->set(compact('messages'));
	}

	// ORIGINAL
	// public  function message() {
	// 	$this->layout = 'main';
 //  		$db = ClassRegistry::init('Message')->getDataSource();
 //  		$data = $db->fetchAll(
	//  	 'SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`,
	//  	  `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`,
	//  	   `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`,
	//  	    `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `messages` AS `Message` LEFT JOIN
	//  	     `users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE to_id = '.$this->Session->read('Auth.User.id').' AND
	//  	      status = 1 OR from_id = '.$this->Session->read('Auth.User.id').'  ORDER BY `Message`.`id` desc LIMIT 10'
	//   		);

	//   	$this->set('messages', $data);

		// $this->loadModel('User');
		// $Users = $this->User->find('all');
		// $this->set('users', $Users);
	 // }

	 public  function message() {
		$this->layout = 'main';
  		$db = ClassRegistry::init('Message')->getDataSource();
  		$data = $db->fetchAll(
	 	 'SELECT * FROM `messages` AS `Message` 
	 	 LEFT JOIN `users` AS `User1` ON (`Message`.`from_id` = `User1`.`id`) 
	 	 LEFT JOIN users AS User2 ON (`Message`.`to_id` = `User2`.`id`) 
	 	 WHERE to_id = '.$this->Session->read('Auth.User.id').' AND
	 	   	   status = 1 OR from_id = '.$this->Session->read('Auth.User.id').'  ORDER BY `Message`.`id` desc LIMIT 10'
	  		);

	  	$this->set('messages', $data);
	 }


	// ORIGINAL

	 public function conversation($id = null) {

	 	$this->layout = 'main';
  		$db = ClassRegistry::init('Message')->getDataSource();
  		$data = $db->fetchAll(
	 	 
		 	      'SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`, 
		 	      `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`, 
		 	      `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`, 
		 	      `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `messages` AS `Message` LEFT JOIN
		 	       `users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE (to_id = '.$this->Session->read('Auth.User.id').' AND from_id = '.$id.') OR (to_id = '.$id.' AND from_id = '.$this->Session->read('Auth.User.id').')  
		 	       AND status = 1 ORDER BY `Message`.`id` desc LIMIT 10'
	 	       );
	  
	  	$this->set('messages', $data);


	 }


	public function createmessage() {

		$this->layout = 'main';
		$this->loadModel('User');
		$Users = $this->User->find('all');
		$this->set('users', $Users);

	}


	public function send() {

		$this->autoRender = false;
		
		$from = $this->Session->read('Auth.User.id');
		if ($this->request->data['Message']['to_id'] == 0 OR $this->request->data['Message']['to_id'] == '') {
			$this->Session->setFlash(__('<div class="alert alert-danger">Receiver is required!</div>'));
			$this->redirect(array('controller' => 'messages', 'action' => 'createmessage'));
			} else {
				if ($this->request->is('post')) {
					$this->request->data['Message']['from_id'] = $from;
					$this->request->data['Message']['status'] = 1;
					$this->Message->create();
					if ($this->Message->save($this->request->data)) {
						$this->Session->setFlash(__('<div class="alert alert-warning">Message sent!</div>'));
						$this->redirect(array('controller' => 'messages', 'action' => 'message'));
					}
				}
			}
	}

	
	// ORIGINAL
	
	public function reply() {

		$this->autoRender = false;
		$this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');

		if ($this->request->is('post')) {
			$this->request->data['Message']['status'] = 1;
			$this->request->data['Message']['from_id'] = $userid;
			$this->Message->create();

			if ($this->request->data['Message']['to_id'] == $userid) {

				$this->Session->setFlash(__('<div class="alert alert-danger">Message Error: Cant send to self!</div>'));
				$this->redirect(array('controller' => 'messages', 'action' => 'conversation', $this->request->data['Message']['to_id']));
			} else {

					if ($this->Message->save($this->request->data)) {
						$this->Session->setFlash(__('<div class="alert alert-warning">message sent!</div>'));
						$this->redirect(array('controller' => 'messages', 'action' => 'conversation', $this->request->data['Message']['to_id']));
					}
			}
		}

	}

	
	public function delete($id = null) {

		$this->Message->id = $id;
		if ($this->Message->saveField('status', 0)) {
			$this->Session->setFlash(__('<div class="alert alert-warning">Message deleted</div>'));
			$this->redirect(array('action' => 'conversation/' . $id));
		}
	}
	

}

?>