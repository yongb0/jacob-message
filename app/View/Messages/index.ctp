this is message page.
<a href="/messages/createmessage"><button>Compose Message</button></a>
<br><br>
<hr>
<table>
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('to_id', 'To'); ?></th>
			<th><?php echo $this->Paginator->sort('from_id', 'From'); ?></th>
			<th><?php echo $this->Paginator->sort('content', 'Message'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Sent on'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php 

		$count = 0;
		foreach($messages as $message):
			$count++;
		if ($count % 1) { echo '<tr>'; } else  echo '<tr class="zebra">'
		
	 ?>
		<tr>
			<td><?php echo $message['Message']['to_id']; ?></td>
			<td><?php echo $message['Message']['from_id']; ?></td>
			<td><?php echo $message['Message']['content']; ?></td>
			<td><?php echo $message['Message']['created']; ?></td>
		</tr>
	<?php 
		endforeach;
		unset($message);
	 ?>
	</tbody>
</table>