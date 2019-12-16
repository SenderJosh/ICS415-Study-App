@extends('layouts/app')

@section('content')

<div class="ui container">
	<a class="ui inverted red button" href="{{ url('/logout') }}">Logout</a>
</div>

@endsection