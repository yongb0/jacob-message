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
?>