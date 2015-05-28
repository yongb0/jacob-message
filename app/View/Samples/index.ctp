<script type="text/javascript">
	$(document).ready(function() {
		var name = $("#name").val();
		if ($("#btn_add").click(function() {
			if(name.length > 0) {

			} else {
			alert('mst contain');
		}
		return false;
	}));
		
	});
</script>
<?php echo $this->Form->create('Sample', array('controller' => 'samples', 'action' => 'add', 'id' => 'form_add')); ?>
<?php echo $this->Form->input('name', array('id' => 'name')); ?>
<?php echo $this->Form->submit(__('Add', array('id' => 'btn_add'))); ?>
<?php echo $this->Form->end(); ?>