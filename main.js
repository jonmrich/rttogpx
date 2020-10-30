$(document).ready(function() {
	$('#get-cal').click(function(event) {
		var tripId = $('#tripId').val();
console.log(tripId);
		$.post('final.php', {
     tripId:tripId
}, function(response){
//console.log(response);
});
	/*	$.get('https://maps.roadtrippers.com/api/v2/trips/'+tripId, function(data) {
			console.log(data);
		});*/
	});
});
//29300446

//https://maps.roadtrippers.com/api/v2/trips/