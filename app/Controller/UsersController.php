<?php  
class UsersController extends AppController {
 
    public $paginate = array(
        'limit' => 25,
        'order' => array('User.name' => 'asc' ) 
    );
     
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','register'); 
    }
     
 
 
    public function login() {
         
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('action' => 'home'));      
        }
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $User = $this->Session->read('Auth.User');
                $id = $User['id'];
                $data = array(
                        'id' => $id,
                        'last_login_time' => date('Y-m-d h:i:s')
                    );
                $this->User->validate['name'] = array();
                $this->User->save($data);
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('name')));
                $this->redirect($this->Auth->redirectUrl());
            } else {
               $this->Session->setFlash(__('Invalid name or password'));
            }
        } 
    }

    public function profile() {

        $Profile = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->set('profile',$Profile['User']);
        
        pr($this->request->data);
        if ($this->request->is('post') || $this->request->is('put')) {
           //  $filename = WWW_ROOT. DS . 'upload'.DS.$this->data['User']['doc_file']['name']; 
           // move_uploaded_file($this->data['User']['doc_file']['tmp_name'],$filename); 
            $data = array(
                'id' => $Profile
                );
            $this->request->data['User']['modified_ip'] = $this->request->clientIp();
            $this->request->data['User']['modified'] = date('Y-m-d h:i:s');
            $this->User->save($this->request->data);
            $this->Session->setFlash(__('Profile has been updated.'));
            $this->redirect(array('action' => 'profile'));
        }

    }

    public function home() {

        $Profile = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->set('profile', $Profile['User']);
        // echo $this->request->clientIp();


        // $this->User->id = $this->Session->read('Auth.User.id');
        // $data = array(
        //          'modified_ip' => '192.168.0.1'
        //         );
        // $this->User->validate['name'] = array();
        // $this->User->save($data);
        // pr($this->User->validationErrors);

        // $userId = $this->Session->read('Auth.User.id');

    }

    

    public function message() {

    }
 
    public function logout() {

        $this->redirect($this->Auth->logout());
    }
 
    public function index() {

        $this->paginate = array(
            'limit' => 6,
            'order' => array('User.name' => 'asc' )
        );
        $users = $this->paginate('User');
        $this->set(compact('users'));
    }
 
    public function register() {

        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['created_ip'] = $this->request->clientIp();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }  
        }
    }

 
}

?>