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


	public  function message() {
		$this->layout = 'main';
  		$db = ClassRegistry::init('Message')->getDataSource();
  		$data = $db->fetchAll(
	 	 'SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`,
	 	  `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`,
	 	   `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`,
	 	    `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `db_message`.`messages` AS `Message` LEFT JOIN
	 	     `db_message`.`users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE to_id = '.$this->Session->read('Auth.User.id').' AND
	 	      status = 1 OR from_id = '.$this->Session->read('Auth.User.id').'  ORDER BY `Message`.`id` desc LIMIT 5'
	  		);

	  	$this->set('messages', $data);
	 }


	 public function conversation($id = null) {

	 	$this->layout = 'main';
  		$db = ClassRegistry::init('Message')->getDataSource();
  		$data = $db->fetchAll(
	 	 
		 	      'SELECT `Message`.`id`, `Message`.`to_id`, `Message`.`from_id`, `Message`.`content`, `Message`.`created`, 
		 	      `Message`.`modified`, `Message`.`status`, `User`.`id`, `User`.`name`, `User`.`email`, `User`.`password`, 
		 	      `User`.`image`, `User`.`gender`, `User`.`birthdate`, `User`.`hobby`, `User`.`last_login_time`, `User`.`created`, 
		 	      `User`.`modified`, `User`.`created_ip`, `User`.`modified_ip` FROM `db_message`.`messages` AS `Message` LEFT JOIN
		 	       `db_message`.`users` AS `User` ON (`Message`.`from_id` = `User`.`id`) WHERE status = 1 OR to_id = 2 AND 
		 	       from_id = 2 ORDER BY `Message`.`id` desc LIMIT 5'
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
						$this->redirect(array('controller' => 'messages', 'action' => 'createmessage'));
					}
				}
			}
	}

	// public function send() {
	// 	$this->autoRender = false;

	// 	$data = array(
	// 			'to_id' => $this->request->data['to'],
	// 			'content' => $this->request->data['msg'],
	// 			'from_id' => $this->Session->read('Auth.User.id'),
	// 			'status' => 1				
	// 		);

	// 	if ($this->Message->save($data)) {
	// 		echo 'sent';
	// 	}

	// }


	// public function reply() {
		
	// 	$this->autoRender = false;
	// 	$this->loadModel('User');
	// 	$userid = $this->Session->read('Auth.User.id');
	// 	$this->request->data['Message']['from_id'] = $userid;
	// 	$this->request->data['Message']['status'] = 1;
	// 	if ($this->request->is('post')) {
	// 		// pr($this->request->data);
	// 		if ($this->request->data['Message']['to_id'] == $userid) {
	// 				$this->Session->setFlash('<div class="alert alert-danger">Message sending error!</div>');
	// 				$this->redirect(array('controller' => 'messages', 'action' => 'conversation', $this->request->data['Message']['to_id']));
	// 			} else {
	// 			$this->Message->create();
	// 			if ($this->Message->save($this->request->data)) {
	// 				$this->Session->setFlash('<div class="alert alert-warning">Message sent!</div>');
	// 				$this->redirect(array('controller' => 'messages', 'action' => 'conversation', $id));
	// 			} else {
	// 				$this->Session->setFlash('<div class="alert alert-danger">Message sending failed!</div>');
	// 			}
	// 		}
	// 	}
		
	// }


	public function reply() {
		$this->autoRender = false;

		if ($this->request->is('ajax')) {
			$data = array(
				'to_id' => $this->request->data['to'],
				'from_id' => $this->Session->read('Auth.Session.id'),
				'content' => $this->request->data['content'],
				'status' => 1
				);

			if ($this->Message->save($data)) {
				echo 'success!';
				return false;
				// $this->redirect(array('controller' => 'messages', 'action' => 'conversation', $this->request->data['to']));
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
	

	public function search() {

		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$search = $this->request->data['search'];
			$this->loadModel('User');
			$users = $this->User->find('all',array(
												"conditions" => array(
													"name LIKE '%" . $search . "%' AND to_id = ".$this->Session->read('Auth.User.id')
													)
												)
										);
			
			foreach($users as $user) {

				$array[] = array('<img src="/jacob-message/img/upload/' . $user["User"]["image"] . '"/>');
				echo $array;
			}
		}
	}



}

?>