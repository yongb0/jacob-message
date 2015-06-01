<?php echo $this->Html->script('message'); ?>
<script type="text/javascript">
	var baseURL = '<?php echo $this->webroot; ?>';
</script>
<script>
    $(document).ready(function() {
        $('#delete').click(function() {
        $('#message').fadeOut('slow');
        $("#users").select2({});
        $("#message_content").shorten({
	    "showChars" : 10,
	    "moreText"  : "See More"
	});
     });
</script>
<script type="text/javascript">
	$(document).ready(function() {
    var showChar = 100;
    var ellipsestext = "...";
    var moretext = "more";
    var lesstext = "less";
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar-1, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ ' </span><span class="morecontent"><span>' + h + '</span>  <a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>

<?php  //  pr($messages); ?>
<div class="header clearfix">
    <nav>
      <ul class="nav nav-pills pull-right">
        <li role="presentation"><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile', $this->Session->read('Auth.User.id'))); ?></li>
        <li role="presentation" class="active"><?php echo $this->Html->link('Message', array('controller' => 'messages','action' => 'message')); ?></li>
        <li role="presentation"><?php echo $this->Html->link('Logout', array('controller' => 'users' ,'action' => 'logout')); ?></li>
      </ul>
    </nav>
    <h3 class="text-muted"><?php echo $this->Html->link('Home', array('controller' => 'users', 'action' => 'home')); ?></h3>
</div>
<h2>Messages</h2>
 <button><?php  echo $this->Html->link('Compose Message', array('controller' => 'messages', 'action' => 'createmessage')); ?></button> 
<hr>
<br><hr>
<div class="alert alert-info">
	
</div>
<?php //echo $this->Form->input(' ',array('type' => 'text','name' => 'data[Message][name]', 'class' => 'form-control', 'placeholder' => 'Search...')); ?><br>
<hr>
<?php foreach($messages as $message): ?>
<?php if ($message['Message']['from_id'] != $this->Session->read('Auth.User.id')) { ?>
<div class="alert alert-info" id='message'>
<?php echo $this->Html->image('upload/' . $message['User']['image'], array('height' => 120, 'width' => 120)); ?>
	<h3>From: <?php echo $this->Html->link($message['User']['name'], array('controller' => 'users', 'action' => 'userprofile', $message['Message']['from_id']) ); ?></h3>
	<a href=""><h4><?php //echo $message['Message']['from_id']; ?></h4></a>
	<p id="message_content"><?php echo $message['Message']['content']; ?></p><hr>
	<p class="right">Sent on <?php echo $message['Message']['created']; ?></p>
	<button id='#message'><?php echo $this->Html->link('View Conversation', array('controller' => 'messages', 'action' => 'conversation', $message['Message']['from_id'])); ?></button>
	<p id='delete'>click me</p>
</div>
	<?php } ?>

<?php  ?>
<?php 
	endforeach;
	unset($message);
?>


<nav>
	<ul class="pager">
		<li><?php echo $this->Paginator->next(__('Show more..', true) . '', array(), null, array('class' => 'disabled'));?></li>
	</ul>
</nav>