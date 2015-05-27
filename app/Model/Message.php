<?php  

App::uses('AppController', 'Controller');

class Message extends AppModel {

	public $validate = array(
		'to_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Receiver is required'
				)
			),
		'from_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Sender is required'
				)
			),
		'content' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must contain message.'
				)
			),
		'created' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Must contain date created'
				)
			)
		);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'id'
			)
		);
}

?>