$(document).ready(function(e) {
	// 50-50
	$('#50-50').click(function(e) {	
		if(!$('.answers').hasClass('inactive')) {
			$.get(base_url + '/50-50', function(data) {
				console.log(data);
				if(data != "false") {
					
				}
			});
		}
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
		if(!$('.answers').hasClass('inactive')) {
			$('.answers').addClass('inactive');

			qid = $(this).data('id');
			uid = $(this).data('uid');
			step = $('.step span').html();

			$.get(base_url + '/check-answer?uid=' + uid, function(data) {
				console.log(data);
				if(data == "true") {
					// ANSWER CORRECT
					$('#a'+step).addClass('correct');
				} else {
					// ANSWER WRONG
					$('#a'+step).addClass('wrong');
				}
			});
		}
	});
});