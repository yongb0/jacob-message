<?php  

class MessagesController extends AppController {

	public $paginate = array(
		'limit' => 5,
		'conditions' => array('status' => '1'),
		'order' => array('Message.created' => 'asc')
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

	public function message() {
		
		$this->loadModel('User');
		$this->layout = 'main';
		$this->paginate = array(
			'limit' => 5,
			'conditions' => array('status' => '1', 'to_id' => $this->Session->read('Auth.User.id')) ,
			'order' => array('Message.created' => 'desc')
			);

		$messages = $this->paginate('Message');
		$this->set(compact('messages'));
	}

	public function createmessage() {

		$this->layout = 'main';
		$this->loadModel('User');
		$userid = $this->Session->read('Auth.User.id');
		$this->request->data['Message']['from_id'] = $userid;
		$this->request->data['Message']['status'] = 1;
		if ($this->request->is('post')) {
			pr($this->request->data);
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash('send');
			} else {
				pr($this->Message->validationErrors);
			}
		}
	}

	public function search() {
		$this->autoRender = false;

	}

	public function conversation($id = null) {
		$this->layout = 'main';
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