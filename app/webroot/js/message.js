
$(document).ready(function(){
	$('#search_name').keyup(function() {
		if ($('#search_name').val().length > 0) {
			$.post(baseURL+'messages/search',{name:$('#search_name').val()},function(data){
				// console.log(data);
				$('#result').html(data);
			})
		}
	});

});