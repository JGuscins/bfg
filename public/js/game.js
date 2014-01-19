$(document).ready(function(e) {
	// 50-50
	$('#50-50').click(function(e) {	
		if(!$('.answers').hasClass('inactive')) {
			$.get(base_url + '/50-50', function(data) {
				if(data != "false") {
					$("a[data-uid='"+ data[0] +"']").css({'opacity': 0.5});
					$("a[data-uid='"+ data[1] +"']").css({'opacity': 0.5});
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
		if(!$('.answers').hasClass('inactive')) {
			$.get(base_url + '/get-answer', function(data) {
				if(data != "false") {
					$('.answers a').css({'opacity': 0.5});
					$("a[data-uid='"+ data +"']").css({'opacity': 1});
				}
			});
		}
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
					$('#a'+step).addClass('right');
				} else {
					// ANSWER WRONG
					$('#a'+step).addClass('wrong');
				}

				setTimeout(getQuestion(), 500);
			});
		}
	});

	function getQuestion() {
		$.get(base_url + '/get-question', function(data) {
			console.log(data);
			if(data.type == "Music" || data.type == "Movie" || data.type == "Book") {
				$('#question-image').attr('src', data.picture);
				$('#question').html(data.title + ' ' + data.question);
			} else if(data.type == "Picture") {
				$('#question-image').attr('src', data.question);
				$('#question').html(data.title);
			} else {
				$('#question').html(data.title + ' ' + data.question);
			}

			$.each(data.answers, function(key, value) {
				key = key+1;
	    		$('#q'+key).html(''+ value.name +'<br>
	    		'+ value.name +' <span><img class="profile-image" src="'+ value.picture +'"></span>')
	    		$('#g'+key).data('id', key).data('uid', value.uid);
			});
		});
	}
});