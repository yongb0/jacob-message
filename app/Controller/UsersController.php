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
         // $this->Html->css('signin');
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
                    ) ;
                $this->User->validate['name'] = array();
                $this->User->save($data);
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('name'), array('class' => 'bg-warning')));
                $this->redirect($this->Auth->redirectUrl());
                // $this->redirect(array('action' => 'home'));
            } else {
               $this->Session->setFlash(__('Invalid name or password'));
            }
        } 
    }

    public function profile() {
        $this->layout = 'main';
        $Profile = $this->User->findById($this->Session->read('Auth.User.id'));
        $this->set('profile',$Profile['User']);
        
        // pr($this->request->data);
        // if ($this->request->is('post') || $this->request->is('put')) {
        //     $data = array(
        //         'id' => $Profile
        //         );
        //     // $file = null;
        //     // $filename = $file['name'];
        //     // $file_temp_name = $file['tmp_name'];
        //     // $dir = WWW_ROOT.'img' .DS. 'upload';
        //     // move_uploaded_file($file_temp_name, $dir.DS.String::uuid().'-'.$filename);

        //     $dir = WWW_ROOT.'img/upload/';
        //     $file = $this->request->data['User']['image'];
        //     $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
        //     $newFilename = $file['name'];
        //     $result = move_uploaded_file($file['tmp_name'], $newFilename);
        //     $this->request->data['User']['image'] = $newFilename;
        //     $this->request->data['User']['modified_ip'] = $this->request->clientIp();
        //     $this->request->data['User']['modified'] = date('Y-m-d h:i:s');
        //     $this->User->save($this->request->data);
        //     $this->Session->setFlash(__('Profile has been updated.'));

        $folderToSaveFiles = WWW_ROOT . 'img/users/' ;
            if(!empty($this->request->data))
            {
                //Check if image has been uploaded
                if(empty($this->request->data['User']['image']))
                {
                        $file = $this->request->data['User']['image']; //put the data into a var for easy use

                        //debug( $file );

                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions
                        
                            $newFilename = $file['name']; // edit/add here as you like your new filename to be.
                            $result = move_uploaded_file( $file['tmp_name'],$newFilename );
                            if(empty($file['name'])){
                                $userData = array(
                                    'id' => $Profile,
                                    'name'  =>  $this->data['User']['name'],
                                    'image' =>  $newFilename,
                                    'gender'    =>  $this->data['User']['gender'],
                                    'birthdate' =>  $this->data['User']['birthdate'],
                                    'hubby' =>  $this->data['User']['hubby'],
                                ); 
                            }else{
                                $userData = array(
                                    'id' => $Profile,
                                    'name'  =>  $this->data['User']['name'],
                                    'gender'    =>  $this->data['User']['gender'],
                                    'birthdate' =>  $this->data['User']['birthdate'],
                                    'hubby' =>  $this->data['User']['hubby'],
                                );
                            }
                          $this->User->save($userData);
                          $this->Session->write('name',$this->data['User']['name']);
                          $this->Session->setFlash('<div class="alert alert-success"><i class="glyphicon glyphicon-ok"></i> Profile updated successfully.</div>');
                }
                $this->redirect(array('action' => 'profile'));

                echo $this->User->validationErrors();
            }
            // $this->redirect(array('action'=>'editProfile'));


            
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