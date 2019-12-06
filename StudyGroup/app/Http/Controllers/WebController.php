<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupPost;

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
		$className = $request['class-name'];
		//If null, means we messed up or fake request. Just go back to normal view
		if(!isset($className))
		{
			return view('index', ['queried' => 0]);
		}
		else
		{
			//Actually do the query, and then return with queried = 1 along with the group meet data

			//As a note, the filter by day thing doesn't work
			//Probably make a SQL proc for this
			error_log($className);
			$groups = GroupPost::where('ClassName', $className)
							->where(function($q) use ($request)
						{
							$q->where('Monday', in_array('Monday', $request['days']))
							->orWhere('Tuesday', in_array('Tuesday', $request['days']))
							->orWhere('Wednesday', in_array('Wednesday', $request['days']))
							->orWhere('Thursday', in_array('Thursday', $request['days']))
							->orWhere('Friday', in_array('Friday', $request['days']))
							->orWhere('Saturday', in_array('Saturday', $request['days']))
							->orWhere('Sunday', in_array('Sunday', $request['days']));
						})->get();

			error_log($groups->count());
			return view('index', ['queried' => 1, 'groups' => $groups]);
		}
	}

}
