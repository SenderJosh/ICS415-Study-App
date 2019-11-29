<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
	/*
	Fields:
		class-name
		topics
		days (array)
	*/
	function queryGroups(Request $request) 
	{
		//If null, means we messed up or fake request. Just go back to normal view
		if($request['class-name'] == 'NULL')
		{
			return view('index', ['queried' => 0]);
		}
		else
		{
			//Actually do the query, and then return with queried = 1 along with the group meet data
			return view('index', ['queried' => 1]);
		}
	}
}
