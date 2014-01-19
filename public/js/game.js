$(document).ready(function(e) {
	// 50-50
	$('#50-50').click(function(e) {
		console.log('50-50');
	});	

	// STOP TIME
	$('#stop-time').click(function(e) {
		console.log('stop-time');
	});	

	// CHANGE QUESTION
	$('#change-question').click(function(e) {
		console.log('change-question');
	});	

	// SHOW ANSEER
	$('#show-answer').click(function(e) {
		console.log('show-answer');
	});	

	// CHECK QUESTION
	$('.answers a').click(function() {
		qid = $(this).data('id')
		uid = $(this).data('uid');

		$.get(base_url + '/check-answer?uid=' + uid, function(data) {
			console.log(data);
		});
	});
});