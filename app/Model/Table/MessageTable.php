<?php  

class MessageTable extends Table {

	public function initialize(array $config) {

		$this->belongsToMany('Users');
	}

}


?>