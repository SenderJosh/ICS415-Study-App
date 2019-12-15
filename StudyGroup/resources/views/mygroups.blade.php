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
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

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
			$('#genBtn').remove();
			let	target = $('#groupPost'),
			converter = new showdown.Converter(),
			html = converter.makeHtml(text);
			target.html(html);
			if(ownership == 1) {
				$('#contentPost').append('<div id="genBtn">'+
									'<button class="ui inverted red button deletebutton" data-deleteid="' + postid + '">Delete Group</button>'+
								'</div>');
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
</script>

@endsection