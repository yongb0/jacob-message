<?php  

class SamplesController extends AppController {

	public function index() {

		$this->layout = 'main';
	}

	public function add() {

		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			pr($this->request->data);
			$this->redirect(array('controller' => 'samples', 'action' => 'index'));
		}
	}
}

?>