<!DOCTYPE html>
<html>
	<head>
		<script
			src="https://code.jquery.com/jquery-3.1.1.min.js"
			integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
			crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
		<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	</head>
	<body>
		<div class="ui inverted segment" style="border-radius: 0px !important;">
			<div class="ui inverted secondary pointing menu">
				<div class="ui container">
					<a class="header item" href="{{ url('/') }}"><i class="book icon"></i>Study Group App</a>
					@if (Request::is('/'))
						<a class="active item" href="{{ url('/') }}">Find Group</a>
						<a class="item" href="{{ url('/mygroups') }}">My Groups</a>
					@elseif (Request::is('mygroups') || Request::is('creategroup'))
						<a class="item" href="{{ url('/') }}">Find Group</a>
						@if (Auth::check())
							<a class="active item" href="{{ url('/mygroups') }}">My Groups</a>
						@else
							<a class="active item" href="{{ url('/login') }}">My Groups</a>
						@endif
					@else
						<a class="item" href="{{ url('/') }}">Find Group</a>
						<a class="item" href="{{ url('/mygroups') }}">My Groups</a>
					@endif
					@if (Auth::check())
						<a class="right item" href="{{ url('/profile') }}"><i class="user icon"></i> Welcome Back, {{ explode(' ', Auth::user()->name)[0] }}!</a>
					@else
						<a class="right item" href="{{ url('/login') }}">Login</a>
					@endif
				</div>
			</div>
		</div>
		@yield('content')
	</body>
</html>