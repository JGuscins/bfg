$(document).ready(function(e) {
	// 50-50
	$('#50-50').click(function(e) {	
		$.get(base_url + '/50-50', function(data) {
			if(data != "false") { 
				$("a[data-uid='"+ data[0] +"']").css({'opacity': 0.5});
				$("a[data-uid='"+ data[1] +"']").css({'opacity': 0.5});
			}
		});
	});	

	// STOP TIME
	$('#stop-time').click(function(e) {

	});	

	// CHANGE QUESTION
	$('#change-question').click(function(e) {

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

			step = $('.step span').html();

			$('.step span').html(Number(step)+1);

			if(Number(step)+1 == 11) {
				window.location = base_url + '/leaderboard';
			}

			$.get(base_url + '/check-answer?uid=' + $(this).attr('data-uid'), function(data) {
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


			$('.answers').removeClass('inactive');
			$('.answers a').css({'opacity': 1});

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
				newkey = key+1;

				myString = value.name
				myArray = myString.split(' ');

	    		$('#q'+newkey).html(''+ myArray[0] +'<br>'+ myArray[1] +' <span><img class="profile-image" src="'+ value.picture +'"></span>');
	    		$('#q'+newkey).attr('data-id', newkey).attr('data-uid', value.uid);
			});
		});
	}
});