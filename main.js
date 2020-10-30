$(document).ready(function() {
	$('#get-cal').click(function(event) {
		var tripId = $('#tripId').val();
console.log(tripId);
		$.post('final.php', {
     tripId:tripId
}, function(response){
console.log(response);
});
	});
});
//29300446