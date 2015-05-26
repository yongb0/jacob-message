<?php echo $this->Form->create('User', array('url' => array('action' => 'create'), 'enctype' => 'multipart/form-data')); ?>

<?php echo $this->Form->input('image', array('type' => 'file')); ?>

<?php echo $this->Form->end('Save'); ?>