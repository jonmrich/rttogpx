$(document).ready(function() {
	$('#get-cal').click(function(event) {
		var tripId = $('#tripId').val();
console.log(tripId);
		$.post('gpx_files/final.php', {
     tripId:tripId
}, function(response){

$('#final_product').toggle();
$('#final_url').attr('href', response);
});
				$.post('trip.php', {
     tripId:tripId
}, function(data){
//console.log(data);
var final = JSON.parse(data)
var thisthing = final.trip.name;
//console.log(thisthing);
});

	/*	$.get('https://maps.roadtrippers.com/api/v2/trips/'+tripId, function(data) {
			console.log(data);
		});*/
	});
});
//29300446

//https://maps.roadtrippers.com/api/v2/trips/