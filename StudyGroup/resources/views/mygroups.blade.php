@extends('layouts/app')

@section('content')
<div class="ui grid" style="overflow-y:auto;white-space:nowrap;max-height:auto;">
	<div class="four wide column">
		<div class="ui fluid vertical tabular menu">
			@foreach($groups as $group)
				<a class="item group" data-tab="{{$group->GroupDescription}}" data-owner="{{$group->Owner}}" data-postid="{{$group->GroupPostID}}">
					<div class="groupItem title">
						@if ($group->Owner == 1)
						<div data-tooltip="You are the owner" data-position="left center" style="display:inline-block;">
							<i class="certificate icon"></i>
						</div>
						@endif
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
			<a class="item" href="{{url('/creategroup')}}">
				<div class="groupItem create">
					<i class="plus circle icon"></i>
				</div>
			</a>
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

	//When a gropu is clicked, display the content and get the users who are part of the group if they own it
	$('.item.group').click(function() {
		$('#contentPost').attr('style', '');

		let text = $(this).data('tab');
		let ownership = $(this).data('owner');
		let postid = $(this).data('postid');
		if(!$(this).hasClass('active')) {
			$('.item.active').removeClass('active');
			$(this).addClass('active');
		}
		if(text) {
			//Remove any dynamically generated HTML from AJAX/form changes
			$('#genBtn').remove();
			$('#genUsers').remove();

			let	target = $('#groupPost'),
			converter = new showdown.Converter(),
			html = converter.makeHtml(text);
			target.html(html);

			if(ownership == 1) {
				//Query for the postid, get all users part of group
				$.ajax({
					type:'GET',
					url:'/mygroups/users',
					data:{postid:postid},
					success:function(data){
						data = JSON.parse(data);
						//If return is not 0, it means we got data returned
						if(data != 0) {
							//If greater than 0, we have actual people in the group (nonempty)
							if(data.length > 0) {
								let userHtml = '<div id="genUsers"><table class="ui celled padded table"><tr><th>Name</th><th>Email</th><th>Status</th></tr>';
								for (let index = 0; index < data.length; index++) {
									const element = data[index];
									let id = element['id'];
									let name = element['name'];
									let email = element['email'];
									let accepted = element['Accepted'];

									//Add data for the person and whether or not the owner has the ability to accept their request to join, or to remove from the group
									//Dependent on 'accepted' indicator, display a different button (use ternary)
									userHtml += '<tr><td>' + name + '</td><td>' + email + '</td><td>' + ((accepted == 1) ? '<button data-postid="' + postid + '" data-uid="' + id + '" class="ui inverted red button removePerson">Remove From Group</button>' : '<button data-postid="' + postid + '" data-uid="' + id + '" class="ui inverted green button addPerson">Accept Request to Join</button>') +'</td></tr>';
								}

								userHtml += '</table></div>';
								$('#contentPost').append(userHtml);
							}
						}
						$('#contentPost').append('<div id="genBtn">'+
									'<button class="ui inverted red button deletebutton" data-deleteid="' + postid + '">Delete Group</button>'+
								'</div>');
					}
				});
			} else {
				$('#contentPost').append('<div id="genBtn">'+
									'<button class="ui inverted red button leavebutton" data-leaveid="' + postid + '">Leave Group</button>'+
								'</div>');
			}
		}
	});

	//Perform AJAX to either delete the group or leave the group the user is part of
	$(document).on('click', '.deletebutton', function() {
		let postid = $(this).data('deleteid');
		$.ajax({
			type:'POST',
			url:'/mygroups/delete',
			data:{postid:postid},
			success:function(data){
				//REmove tab
				$('.group[data-postid=' + postid + ']').remove();
				//Remove button and post from  view
				$('#contentPost').attr('style', 'display: none; visibility:hidden;');
			}
		});
	});

	$(document).on('click', '.leavebutton', function() {
		let postid = $(this).data('leaveid');
		$.ajax({
			type:'POST',
			url:'/mygroups/leave',
			data:{postid:postid},
			success:function(data){
				//Remove tab
				$('.group[data-postid=' + postid + ']').remove();
				//Remove button and post from  view
				$('#contentPost').attr('style', 'display: none; visibility:hidden;');
			}
		});
	});

	//Perform AJAX to either remove the person from the group (as the owner), or accept the person into the group (as the owner)
	$(document).on('click', '.removePerson', function() {
		let postid = $(this).data('postid');
		//UID to remove from the group
		let uid = $(this).data('uid');

		$.ajax({
			type:'POST',
			url:'/mygroups/removeuserfromgroup',
			data:{postid:postid, uid:uid}
		});

		//Remove row from the list of people in the group
		//The HTML parent for the button clicked is a <td>, so need <tr> (parent's parent)
		$(this).closest('tr').remove();
	});

	$(document).on('click', '.addPerson', function() {
		let postid = $(this).data('postid');
		//UID to remove from the group
		let uid = $(this).data('uid');
		$.ajax({
			type:'POST',
			url:'/mygroups/acceptuserintogroup',
			data:{postid:postid, uid:uid}
		});
		//Remove row from the list of people in the group
		//The HTML parent for the button clicked is a <td>, so need <tr> (parent's parent)
		$(this).removeClass();
		$(this).addClass('ui inverted red button removePerson');
		$(this).text('Remove From Group');
	});

	

</script>

@endsection