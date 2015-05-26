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

	public function message() {
		
		$this->loadModel('User');
		$this->layout = 'main';
		$this->paginate = array(
			'limit' => 5,
			// 'conditions' => array('status' => '1', 'to_id' => $this->Session->read('Auth.User.id')) ,
			'conditions' => array('status = 1 OR to_id = '. $this->Session->read('Auth.User.id').' OR from_id = ' .$this->Session->read('Auth.User.id')),
			'order' => array('Message.created' => 'desc')
			);

		$messages = $this->paginate('Message');
		$this->set(compact('messages'));
	}

	public function createmessage() {

		$this->layout = 'main';
		$this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');
		$users = $this->User->find('all', array(
									"conditions" => array("name = '".$this->request->data['User']['name']."' ")
										));
		foreach ($users as $user):
			// pr($user);
			endforeach;
		$this->request->data['Message']['to_id'] = $user['User']['id'];
		$this->request->data['Message']['from_id'] = $userid;
		$this->request->data['Message']['status'] = 1;
		if ($this->request->is('post')) {
			pr($this->request->data);
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash('Message sent!');
			} else {
				pr($this->Message->validationErrors);
			}
		}

	}

	public function reply($id = null) {
		
		$this->autoRender = false;
		$this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');
		$this->request->data['Message']['from_id'] = $id;
		$this->request->data['Message']['to_id'] = $userid;
		$this->request->data['Message']['status'] = 1;
		if ($this->request->is('post')) {
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash('Message sent!');
				$this->redirect(array('controller' => 'messages', 'action' => 'conversation', $id));
			} else {
				$this->Session->setFlash('Message sending failed!');
			}
		}
		
	}
	

	public function search() {

		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$search = $this->request->data['name'];
			$this->loadModel('User');
			$users = $this->User->find('all',array(
												"conditions" => array("name LIKE '%" . $search . "%' ")
												)
											);
			
			foreach($users as $user) {
				$array[] =  array($user['User']['name']) ;
				// $array = $user['User']['name'];
			}
			
			echo json_encode($array);

		}


	}

	public function conversation($id = null) {

		$this->loadModel('User');
		$this->layout = 'main';
		$users = $this->User->find('all', array(
											'conditions' => array('id = '. $id)
										));
		$this->paginate = array(
			'limit' => 5,
			// 'conditions' => array('status' => '1', 'to_id' => $this->Session->read('Auth.User.id')),
			'conditions' => 'status = 1 OR to_id = ' .$id. ' OR from_id = ' .$this->Session->read('Auth.User.id'). '' ,
			'order' => array('Message.created' => 'asc')
			);
		$messages = $this->paginate('Message');
		$this->set(compact('messages'));

	}

	public function delete($id = null) {

		$this->Message->id = $id;
		if ($this->Message->saveField('status', 0)) {
			$this->Session->setFlash(__('Message deleted'));
			$this->redirect(array('action' => 'message'));
		}
	}

	// public function deleteParent($id = null) {

	// 	$this->Message->id = $id;
	// 	if ($this->Message->saveField('status', 0)) {

	// 	}
	// }



}

?>