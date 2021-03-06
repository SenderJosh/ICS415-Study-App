@extends('layouts/app')

@section('content')
<!-- Variable to disable or enable 'request to join' button based on if the user is logged in -->
@if (Auth::user())
<script>const auth = 1;</script>
@else
<script>const auth = 0;</script>
@endif

<!-- Find Group page -->
<div class="ui container" style="margin-top: 50px;">
	@if ($queried == 0)
		<form class="ui form">
			<div class="ui grid">
				<div class="row">
					<div class="four wide column"></div>
					<div class="four wide column">
						<div class="field">
							<label>Class Name</label>
							<input id="class_name" type="text" name="class-name" placeholder="ICS 415" onkeyup="checkIfEmpty()">
						</div>
					</div>
					<div class="four wide column">
						<div class="field">
							<label>Topics</label>
							<input id="topics" type="text" name="topics" placeholder="Web Programming,Angular.JS,Semantic-UI">
						</div>
					</div>
					<div class="four wide column"></div>
				</div>
				<div class="row">
					<div class="four wide column"></div>
					<div class="eight wide column">
						<div class="field">
							<label>Day Availability</label>
							<select id="day_availability" name="days[]" multiple="" class="label ui selection fluid dropdown">
								<option value="">Pick days you are available</option>
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
								<option value="Saturday">Saturday</option>
								<option value="Sunday">Sunday</option>
							</select>
						</div>
					</div>
					<div class="four wide column"></div>
				</div>
				<div class="row">
					<div class="eight wide column"></div>
					<div class="four wide right aligned column">
						<button id="submit" class="ui blue basic button" disabled>Find a Group</button>
					</div>
					<div class="eight wide column"></div>
				</div>
			</div>
		</form>
		<script>
			$('.dropdown').dropdown();
			
			function checkIfEmpty() {
				//If greater than 0 and not just whitespace, enable submit button
				if ($('#class_name').val().trim().length > 0) {
					$('#submit').removeAttr('disabled');
				} else {
					//Otherwise, disable
					$('#submit').attr('disabled', 'disabled');
				}
			}
		</script>
	@endif
</div>
<!-- Sidebar -->
@if ($queried == 1)
@if (count($groups) > 0)
<div class="ui grid" style="overflow-y:auto;white-space:nowrap;max-height:auto;">
	<div class="four wide column">
		<div class="ui fluid vertical tabular menu">
			@foreach($groups as $group)
				<a class="item group" data-tab="{{$group->GroupDescription}}" data-postid="{{$group->GroupPostID}}" data-applied="{{$group->Applied}}">
					<div class="groupItem title">
						{{$group->GroupName}}
					</div>
					<div style="text-align:center;">
						<div class="groupItem class" style="display: inline-block;">
							{{$group->ClassName}}
						</div>
						<div class="groupItem days" style="display: inline-block;">
							@if ($group->Monday)
							M
							@endif
							@if ($group->Tuesday)
							T
							@endif
							@if ($group->Wednesday)
							W
							@endif
							@if ($group->Thursday)
							R
							@endif
							@if ($group->Friday)
							F
							@endif
							@if ($group->Saturday)
							[SAT]
							@endif
							@if ($group->Sunday)
							[SUN]
							@endif
						</div>
					</div>
				</a>
			@endforeach
		</div>
	</div>
	<div id="contentPost" class="stretched twelve wide column" style="display: none; visibility:hidden;">
		<div id="groupPost" class="ui bottom attached segment active tab"></div>
	</div>
</div>

<script src="https://cdn.rawgit.com/showdownjs/showdown/1.9.0/dist/showdown.min.js"></script>

<script>
	//AJAX setup, add csrf token to header
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	//For any group clicked, display its content and request to join button
	$('.item.group').click(function() {
		$('#contentPost').attr('style', '');

		let text = $(this).data('tab');
		let postid = $(this).data('postid');
		let applied = $(this).data('applied');

		if(!$(this).hasClass('active')) {
			$('.item.active').removeClass('active');
			$(this).addClass('active');
		}
		if(text) {
			//REmove dynamically generated html button
			$('#genBtn').remove();

			let	target = $('#groupPost'),
			converter = new showdown.Converter(),
			html = converter.makeHtml(text);
			target.html(html);

			//Display a different button based on whether or not they've already applied to the group
			if(applied == 1) {
				$('#contentPost').append('<div id="genBtn">'+
									'<button class="ui inverted red button removerequestbutton" data-joinid="' + postid + '">Retract Request to Join</button>'+
								'</div>');
			} else {
				$('#contentPost').append('<div id="genBtn">'+
									'<button class="ui inverted blue button requestbutton" data-joinid="' + postid + '" ' + ((auth == 1) ? '' : 'disabled') + ' >Request to Join</button>'+
								'</div>');
			}
		}
	});

	//Perform AJAX to either delete the group or leave the group the user is part of
	$(document).on('click', '.requestbutton', function() {
		let postid = $(this).data('joinid');
		$.ajax({
			type:'POST',
			url:'/requestjoin',
			data:{postid:postid},
			success:function(data){
				//Change button to be the "remove request join" button
				$('#genBtn').html('<button class="ui inverted red button removerequestbutton" data-joinid="' + postid + '">Retract Request to Join</button>');
			}
		});
	});

	$(document).on('click', '.removerequestbutton', function() {
		let postid = $(this).data('joinid');
		$.ajax({
			type:'POST',
			url:'/removerequestjoin',
			data:{postid:postid},
			success:function(data){
				//Change button to be the "request join" button
				$('#genBtn').html('<button class="ui inverted blue button removerequestbutton" data-joinid="' + postid + '">Request to Join</button>');
			}
		});
	});
</script>
@else
<!-- No groups -->
<div class="ui container" style="text-align: center;">
	<h1>There are no groups with your filters</h1>
	<h3>Click <a href="{{ url('/') }}">here</a> to go back</h3>
</div>
@endif
@endif

@endsection