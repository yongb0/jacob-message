<?php  

class MessagesController extends AppController {

	public $belongsTo = array(
        'User' => array(
            'className' => 'Message',
            'foreignKey' => 'id',
            'conditions' => 'messages.to_id = users.id'
            )
        );



	public function index() {

		$this->paginate = array(
			'limit' => 5,
			'conditions' => array('status' => '1'),
			'order' => array('Message.created' => 'desc')
			);

		$messages = $this->paginate('Message');
		$this->set(compact('messages'));
	}

	// public function message() {

	// 	$this->loadModel('User');
	// 	$this->layout = 'main';
	// 	$this->paginate = array(
	// 		'limit' => 5,
	// 		'conditions' => array('to_id = ' . $this->Session->read('Auth.User.id') . ' AND status = 1'),
	// 		'order' => array('Message.created' => 'desc')
	// 		);
	// 	$users = $this->Message->find('all', array(
	// 										'conditions' => 'User.id = Message.from_id'
	// 									));
	// 	$messages = $this->paginate('Message');
	// 	$this->set(compact('messages'));

	// }

	public function message() {
		// $this->loadModel('User');
		$this->layout= 'main';
		$this->paginate = array(
				'Users' => array(
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

	public function conversation($id = null) {

		$this->loadModel('User');
		$this->layout = 'main';
		// $users = $this->User->find('all', array(
		// 									'conditions' => array('id = '. $id)
		// 								));

		// $this->paginate = array(
		// 	'limit' => 5,
		// 	// 'conditions' => array('status' => '1', 'to_id' => $this->Session->read('Auth.User.id')),
		// 	'conditions' => 'to_id = ' .$this->Session->read('Auth.User.id'). ' AND from_id = ' .$this->Session->read('Auth.User.id'). ' OR from_id = '.$id.' OR to_id = '.$id.' AND status = 1' ,
		// 	'order' => array('Message.id' => 'desc')
		// 	);
		$this->paginate = array(
			'User' => array(
						'joins' => array(
								'table' => 'users',
								'alias' => 'User',
								),
						'conditions' => array('User.id = Message.from_id OR User.id = Message.to_id')

					),
			'limit' => 5,
			'conditions' => 'to_id = ' .$this->Session->read('Auth.User.id'). ' AND from_id = ' .$this->Session->read('Auth.User.id'). ' OR from_id = '.$id.' OR to_id = '.$id.' AND status = 1' ,
			'order' => array('Message.id' => 'desc')
			);

		$messages = $this->paginate('Message');
		$this->set(compact('messages'));

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
			$this->Session->setFlash(__('Receiver is required!'));
			$this->redirect(array('controller' => 'messages', 'action' => 'createmessage'));
		} else {
			if ($this->request->is('post')) {
				$this->request->data['Message']['from_id'] = $from;
				$this->request->data['Message']['status'] = 1;
				$this->Message->create();
				if ($this->Message->save($this->request->data)) {
					$this->Session->setFlash(__('Message sent!'));
					$this->redirect(array('controller' => 'messages', 'action' => 'createmessage'));
				}
			}
		}
	}

	public function reply($id = null) {
		
		$this->autoRender = false;
		$this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');
		$this->request->data['Message']['from_id'] = $userid;
		$this->request->data['Message']['to_id'] = $id;
		$this->request->data['Message']['status'] = 1;
		if ($this->request->is('post')) {
			// pr($this->request->data);
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash('Message sent!');
				$this->redirect(array('controller' => 'messages', 'action' => 'conversation', $id));
			} else {
				$this->Session->setFlash('Message sending failed!');
			}
		}
		
	}
	

	public function delete($id = null) {

		$this->Message->id = $id;
		if ($this->Message->saveField('status', 0)) {
			$this->Session->setFlash(__('Message deleted'));
			$this->redirect(array('action' => 'message'));
		}
	}



}

?>