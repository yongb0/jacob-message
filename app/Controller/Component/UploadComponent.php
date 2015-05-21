<?php  

App::uses('Component', 'Controller');

class UploadComponent extends Component {

	public $max_file = 1;

	public function upload($data = null) {

		if (!empty($data)) {
			if (count($data) > $this->max_file) {
				throw new NotFoundException('Error Processing Request', 1);
			}

			foreach($data As $file) {
				$filename = $file['name'];
				$file_temp_name = $file['tmp_name'];
				$dir = WWW_ROOT.'img' .DS. 'upload';
				$allowed = array('png', 'jpg', 'jpeg');
				if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {

					throw new NotFoundException('Error Processing Request', 1);
				} elseif (is_uploaded_file($file_temp_name)) {
					move_uploaded_file($file_temp_name, $dir.DS.String::uuid().'-'.$filename);
					// String::uuid().'-'.$filename outputs 2131-2133-123-foto.jpg 
				}
			}
		}
	}

}


?>