@extends('layouts/app')

@section('content')
<!-- Sidebar -->
@if ($queried == 1)
<div>
	<div class="ui vertical inverted left visible sidebar menu overlay">
		@foreach($groups as $group)
		<a class="item">
			{{$group->ClassName}}
		</a>
		@endforeach
	</div>
</div>
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
	@else
		asdf
	@endif
</div>

@endsection