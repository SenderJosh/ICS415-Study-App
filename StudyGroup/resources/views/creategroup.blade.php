@extends('layouts/app')

@section('content')

<div class="ui container">
	<form class="ui form">
		<div class="ui grid">
			<div class="row">
				<div class="eight wide column">
					<div class="field">
						<label>Study Group Title</label>
						<input id="title" type="text" name="title" placeholder="ICS 415 Study Group" onkeyup="checkIfEmpty()" maxlength="75" />
					</div>
				</div>
				<div class="eight wide column">
					<div class="field">
						<label>Course Name/Number</label>
						<input id="classname" type="text" name="class-name" placeholder="ICS 415" onkeyup="checkIfEmpty()" maxlength="75" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="sixteen wide column">
					<div class="field">
						<label>Description (markdown)</label>
						<textarea onkeyup="checkIfEmpty()" name="description" id="md" placeholder="# Title&#10;&#10;## What You'll Cover&#10;&#10;Times Meeting" maxlength="4000"></textarea>
						<button style="margin-top:5px;" id="prevButton" class="ui button" onclick="run()">Preview</button>
						<div id="target"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="sixteen wide column">
					<div class="field">
						<label>Days Meeting</label>
						<select id="day_meeting" name="days[]" multiple="" class="label ui selection fluid dropdown" onchange="checkIfEmpty()">
							<option value="">Pick days you will be meeting</option>
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
			</div>
			<div>
				<button id="submit" class="ui blue basic button" disabled>Create Group</button>
			</div>
		</div>
	</form>
</div>

<script src="https://cdn.rawgit.com/showdownjs/showdown/1.9.0/dist/showdown.min.js"></script>
<script>
	//Prevent default because it think it's submitting the form
	$('#prevButton').click(function(e) {
		e.preventDefault();
	});

	function run() {
		let text = document.getElementById('md').value;
		if(text) {
			let	target = document.getElementById('target'),
			converter = new showdown.Converter(),
			html = converter.makeHtml(text);
			target.innerHTML = '<hr />' + html + '<hr />';
		}
	}

	$('.dropdown').dropdown();
			
	function checkIfEmpty() {
		//If greater than 0 and not just whitespace, enable submit button
		if ($('#title').val().trim().length > 0 && $('#classname').val().trim().length > 0 && $('#md').val().trim().length > 0 && $('#day_meeting').val().length > 0) {
			$('#submit').removeAttr('disabled');
		} else {
			//Otherwise, disable
			$('#submit').attr('disabled', 'disabled');
		}
	}
</script>

@endsection