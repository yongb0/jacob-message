<script>
  $(document).ready(function() {
      $("#frm_send").submit(function(){
          var to = $("#to").val();
          var msg = $("#msg").val();
          var url = $("#frm_send")[0].action;

          if (to.length == 0 && msg.length == 0) {
            alert('recepient and message is required');
            return false;
          } else {
            var data = {
                  to : to,
                  msg : msg
            };
            $.post(url, data, function(data){
              alert('message sent!');
            })
          }
      });
  });
</script>
<script>
    $(document).ready(function() {
       $("#users").select2({});
     });
</script>
<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation"><?php echo $this->Html->link('Profile', array('controller' => 'users' ,'action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('controller' => 'users' ,'action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted"><?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'home')); ?></h3>
</div>
<h1>Create New Message</h1>
<?php echo $this->Form->create('Message', array('controller' => 'messages', 'action' => 'send', 'id' => 'frm_send')); ?>
  <select name="data[Message][to_id]" id="users" class="form-control" style="width:300px; height: 30px;" id="to" >
    <option value="0">Send to</option>
    <?php foreach ($users as $user) { ?>
    <?php if ($user['User']['id'] != $this->Session->read('Auth.User.id'))  { ?>
      <option value="<?php echo $user['User']['id']; ?>"><?php echo $user['User']['name']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
<?php echo $this->Form->textarea('content',array('type'=>'text', 'id' => 'msg','name' => 'data[Message][content]', 'class' => 'form-control', 'placeholder' => 'Message', 'style' => 'margin: 0px; width: 490px; height: 100px;')); ?><br>
<?php echo $this->Form->submit(__('Send')); ?>
<?php echo $this->Form->end(); ?>