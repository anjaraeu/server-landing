$('#ram').progress();
$('#swap').progress();
$('#dd').progress();
var conn = new WebSocket('wss://' + window.location.hostname + '/wsapp');

conn.onmessage = function(e) {
	var message_parsed = JSON.parse(e.data);
	var avg = message_parsed.avg;
	var ram = message_parsed.mem.ram;
	var swap = message_parsed.mem.swap;
	var du = message_parsed.du;
	$('#avg').text(avg);
	$('#ram').progress('set progress', ram);
	$('#swap').progress('set progress', swap);
	$('#du').progress('set progress', du);
}

function send(mess) {
	conn.send(mess);
}

setInterval(send, 1500, 'getsys');
