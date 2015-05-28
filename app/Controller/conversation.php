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
	
	?>