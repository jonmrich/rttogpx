$(document).ready(function() {
	$('#get-cal').click(function(event) {
		var tripId = $('#tripId').val();

		$.post("pint.php", {
     tripId:tripId
}, function(response){
console.log(response);
});
	});
});
