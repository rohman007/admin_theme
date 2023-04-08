"use strict";


if($('iframe#game-area').length){
	load_leaderboard({type: 'top', amount: 10});
}
function load_leaderboard(conf){
	if($('#content-leaderboard').length){
		let g_id = $('#content-leaderboard').data('id');
		$.ajax({
			url: '/includes/api.php',
			type: 'POST',
			dataType: 'json',
			data: {'action': 'get_scoreboard', 'game-id': g_id, 'conf': JSON.stringify(conf)},
			complete: function (data) {
				if(data.responseText){
					if(JSON.parse(data.responseText).length){
						show_leaderboard(JSON.parse(data.responseText));
					}
				}
			}
		});
	}
}
function show_leaderboard(data){
	let html = '<table class="table table-striped table-dark"><thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Username</th><th scope="col">Score</th><th scope="col">Date</th></tr></thead><tbody>';
	let index = 1;
	data.forEach((item)=>{
		html += '<tr><th scope="row">'+index+'</th><td>'+item.username+'</td><td>'+item.score+'</td><td>'+item.created_date.substr(0, 10)+'</td></tr>';
		index++;
	});
	html += '</tbody></table>';
	$('#content-leaderboard').html(html);
}

(function(){
	$(".burger-left").click(function(){
		$(".left-categories").toggleClass("show");
	});

	$(".burger-right").click(function(){
		$(".sidebar-right").toggleClass("show");
	});

	if(window.innerWidth < 1025){
        $('.has-dropdown').click(function(d){
            d.preventDefault();
            $(this).children(".drop-ct").toggle();
        });
    }
	/*let game_iframe = $('iframe#game-area');
	if(game_iframe.length){
		//is game page
		game_iframe.attr('src', game_iframe.attr('data-src'));
	}*/

	var $el = $(".user-avatar");
	var $ee = $(".user-dropdown");
	$el.click(function(e){
		e.stopPropagation();
		e.preventDefault();
		$(".user-dropdown").toggleClass('show');
	});
	$(document).on('click',function(e){
		if(($(e.target) != $el) && ($ee.hasClass('show'))){
			$ee.removeClass('show');
		}
	});
	let last_offset = $("#listing1").children().length;
	let load_amount = 12;
	$('#load-more1').click((e)=>{
		e.preventDefault();
		$(this).addClass('disabled');
		fetch_games(load_amount, 'new');
	});
	function fetch_games(amount, sort_by) {
		$.ajax({
			url: "/includes/fetch.php",
			type: 'POST',
			dataType: 'json',
			data: {amount: amount, offset: last_offset, sort_by: sort_by},
			complete: function (data) {
				append_content(JSON.parse(data.responseText));
			}
		});
	}
	function append_content(data){
		last_offset += data.length;
		data.forEach((game)=>{
			let rating = 0;
			game['upvote'] = Number(game['upvote']);
			game['downvote'] = Number(game['downvote']);
			let total_revs = game['upvote']+game['downvote'];
			if(total_revs > 0){
				rating = (Math.round((game['upvote']/(game['upvote']+game['downvote'])) * 5));
			}
			let html = '<div class="col-lg-2 col-md-4 col-6 grid-1">';
			html += '<a href="/game/'+game['slug']+'/">';
			html += '<div class="game-item">';
			html += '<div class="list-game">';
			html += '<div class="list-thumbnail">';
			html += '<img src="'+game['thumb_2']+'" class="small-thumb" alt="'+game['title']+'">';
			html += '</div>';
			html += '<div class="list-info">';
			html += '<div class="list-b-play"><img src="/content/themes/arcade-one/images/icon/play.svg" alt=""></div>';
			html += '<div class="list-title ellipsis">'+game['title']+'</div>';
			html += '<span class="list-rating ellipsis">';
			html += '<i class="bi bi-star-fill star-on"></i> '+rating+' ('+total_revs+' Reviews)';
			html += '</span></div></div></div></a></div>';
			$("#listing1").append(html);
			$("#listing1 .column:hidden").slice(0, load_amount).slideDown();
		});
		if(data.length < load_amount){
			$("#load-more1").text("No More Games").addClass("noContent disabled");
		} else {
			$("#load-more1").removeClass('disabled');
		}
	}
	$("#navb").on('show.bs.collapse', function(){
		$('.user-avatar').hide();
	});
	$("#navb").on('hidden.bs.collapse', function(){
		$('.user-avatar').show();
	});
	$('.bt-group #upvote').on('click', function(e) {
		e.preventDefault();
		$(this).addClass('disabled');
		let data_id = $(this).attr('data-id');
		$.ajax({
			url: '/includes/vote.php',
			type: 'POST',
			dataType: 'json',
			data: {'vote': true, 'action': 'upvote', 'id': data_id},
			success: function (data) {
				//console.log(data.responseText);
			},
			error: function (data) {
				//console.log(data.responseText);
			},
			complete: function (data) {
				console.log(data.responseText);
				$('.bt-group #upvote').addClass('has-background-success');
			}
		});
	});
	$('.bt-group #downvote').on('click', function(e) {
		e.preventDefault();
		$(this).addClass('disabled');
		let data_id = $(this).attr('data-id');
		$.ajax({
			url: '/includes/vote.php',
			type: 'POST',
			dataType: 'json',
			data: {'vote': true, 'action': 'downvote', 'id': data_id},
			success: function (data) {
				//console.log(data.responseText);
			},
			error: function (data) {
				//console.log(data.responseText);
			},
			complete: function (data) {
				console.log(data.responseText);
				$('.bt-group #downvote').addClass('has-background-danger');
			}
		});
	});
	$('.user-avatar').on('click', ()=>{
		let element = $('.user-links');
		if (element.is(":hidden")) {
			element.removeClass('hidden');
		} else element.addClass('hidden');
	});
	$('#btn_prev').on('click', function() {
		$('.liked-gamelist ul').animate({
			scrollLeft: '-=150'
		}, 300, 'swing');
	});
	
	$('#btn_next').on('click', function() {
		$('.liked-gamelist ul').animate({
			scrollLeft: '+=150'
		}, 300, 'swing');
	});
	$('#f_prev').on('click', function() {
		$('.favorite-gamelist ul').animate({
			scrollLeft: '-=150'
		}, 300, 'swing');
	});
	
	$('#f_next').on('click', function() {
		$('.favorite-gamelist ul').animate({
			scrollLeft: '+=150'
		}, 300, 'swing');
	});
	$('.delete-comment').on('click', function() {
		let id = $(this).attr('data-id');
		$.ajax({
			url: '/admin_theme/includes/comment.php',
			type: 'POST',
			dataType: 'json',
			data: {'delete': true, 'id': id},
			success: function (data) {
				//console.log(data.responseText);
			},
			error: function (data) {
				//console.log(data.responseText);
			},
			complete: function (data) {
				if(data.responseText === 'deleted'){
					$('.id-'+id).remove();
				}
			}
		}, this);
	});
	let game_id;
	if($('#comments').length){
		game_id = $('.game-content').attr('data-id');
		$.ajax({
			url: '/admin_theme/includes/comment.php',
			type: 'POST',
			dataType: 'json',
			data: {'load': true, 'game_id': game_id},
			success: function (data) {
				//console.log(data.responseText);
			},
			error: function (data) {
				//console.log(data.responseText);
			},
			complete: function (data) {
				let comments = JSON.parse(data.responseText);
				load_comments(convert_comments(comments));
			}
		});
	}
	function convert_comments(array){
		let data = [];
		array.forEach((item)=>{
			let arr = {
				id: Number(item.id),
				created: item.created_date,
				content: item.comment,
				fullname: item.sender_username,
				profile_picture_url: item.avatar,
			};
			if(Number(item.parent_id)){
				arr.parent = Number(item.parent_id);
			}
			if(!arr.fullname){
				arr.fullname = 'Anonymous';
			}
			data.push(arr);
		});
		return data;
	}
	function load_comments(array){
		let read_only = false;
		let avatar = $('.user-avatar img').attr('src');
		if(!avatar){
			avatar = '/images/default_profile.png';
			read_only = true;
		}
		$('#comments').comments({
			enableUpvoting:false,
			roundProfilePictures: true,
			popularText: '',
			profilePictureURL: avatar,
			readOnly: read_only,
			enableNavigation: false,
			enableEditing: false,
			getComments: function(success, error) {
				success(array);
			},
			postComment: function(commentJSON, success, error) {
				commentJSON.source = 'jquery-comments';
				commentJSON.send = true;
				commentJSON.game_id = game_id;
				$.ajax({
					type: 'post',
					url: '/includes/comment.php',
					data: commentJSON,
					success: function(comment) {
						console.log(comment);
						success(commentJSON)
					},
					error: error
				});
			}
		});
	}
})();

function open_fullscreen() {
	let game = document.getElementById("game-area");
	if (game.requestFullscreen) {
	  game.requestFullscreen();
	} else if (game.mozRequestFullScreen) { /* Firefox */
	  game.mozRequestFullScreen();
	} else if (game.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
	  game.webkitRequestFullscreen();
	} else if (game.msRequestFullscreen) { /* IE/Edge */
	  game.msRequestFullscreen();
	}
};