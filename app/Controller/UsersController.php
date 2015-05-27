<?php  
class UsersController extends AppController {
    
    public $components = array('Upload');

    

    public $paginate = array(
        'limit' => 25,
        'order' => array('User.name' => 'asc' ) 
    );
  
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','register'); 
    }
     
    public function login() {
         
         $this->layout = 'main';

        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('controller' => 'users', 'action' => 'home'));      
        }
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $User = $this->Session->read('Auth.User');
                $id = $User['id'];
                $data = array(
                        'id' => $id,
                        'last_login_time' => date('Y-m-d h:i:s')
                    ) ;
                $this->User->validate['name'] = array();
                $this->User->save($data);
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('name'), array('class' => 'bg-warning')));
                $this->redirect(array('controller' => 'users', 'action' => 'home'));
            } else {
               $this->Session->setFlash(__('Invalid name or password'));
            }
        } 
    }

    public function profile() {

        $this->layout = 'main';
        $Profile = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->set('profile', $Profile['User']);

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = array(
                'id' => $Profile
                );
            if (!empty($this->request->data['User']['image']['name'])) {
                $file = $this->request->data['User']['image'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                $arr_ext = array('jpg', 'png', 'jpeg');

                if (in_array($ext, $arr_ext)) {

                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/upload/' . $file['name']);
                    $this->request->data['User']['image'] = $file['name'];
                    $this->request->data['User']['modified_ip'] = $this->request->clientIp();
                    // $this->User->save($this->request->data);
                    if ($this->User->save($this->request->data)) {
                        $this->Session->setFlash('User updated');
                        $this->redirect(array('action' => 'profile'));

                    }
                }
            } else {
                $this->request->data['User']['modified_ip'] = $this->request->clientIp();

                    $this->request->data['User']['image'] = '';
                    // $this->User->save($this->request->data);
                    if ($this->User->save($this->request->data)) {
                        $this->Session->setFlash('User updated');
                        $this->redirect(array('action' => 'profile'));
                }
                
            }
        }
    }

    public function home() {

        $this->layout = 'main';
        $Profile = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->set('profile', $Profile['User']);

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

        $this->layout = 'main';
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

    public function userprofile($id = null) {

        $this->layout = 'main';
        $users = $this->User->find('all', array(
                                            'conditions' => array('id = '.$id)
                                        ));
        $this->set('users', $users);
    }


 
}

?>