<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupPost;
use Auth;
use DB;

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
			
			$groups = NULL;
			//if it's empty, just set it to something to prevent error
			if (!isset($request['days']))
			{
				$request['days'] = array();
			}
			if (Auth::user()) 
			{
				$groups = DB::select('exec StudyApp_FindGroupPosts ?,?,?,?,?,?,?,?,?', array($className, 
						Auth::user()->id,
						in_array('Monday', $request['days']),
						in_array('Tuesday', $request['days']),
						in_array('Wednesday', $request['days']),
						in_array('Thursday', $request['days']),
						in_array('Friday', $request['days']),
						in_array('Saturday', $request['days']),
						in_array('Sunday', $request['days'])
					)
				);
			}
			else
			{
				$groups = DB::select('exec StudyApp_FindGroupPosts ?,?,?,?,?,?,?,?,?', array($className, 
						0,
						in_array('Monday', $request['days']),
						in_array('Tuesday', $request['days']),
						in_array('Wednesday', $request['days']),
						in_array('Thursday', $request['days']),
						in_array('Friday', $request['days']),
						in_array('Saturday', $request['days']),
						in_array('Sunday', $request['days'])
					)
				);
			}

			return view('index', ['queried' => 1, 'groups' => $groups]);
		}
	}

	function createGroup(Request $request)
	{
		//Check if auth. If not, go to index
		if(!Auth::user())
		{
			return view('index', ['queried' => 0]);
		}


		$title = $request['title'];
		//same logic as queryGroups
		if(!isset($title))
		{
			return view('creategroup');
		}
		else
		{
			$newGroupPost = new GroupPost;
			$newGroupPost->GroupOwnerID = Auth::user()->id;
			$newGroupPost->GroupName = $title;
			$newGroupPost->ClassName = $request['class-name'];
			$newGroupPost->GroupDescription = $request['description'];
			$newGroupPost->Monday = in_array('Monday', $request['days']);
			$newGroupPost->Tuesday = in_array('Tuesday', $request['days']);
			$newGroupPost->Wednesday = in_array('Wednesday', $request['days']);
			$newGroupPost->Thursday = in_array('Thursday', $request['days']);
			$newGroupPost->Friday = in_array('Friday', $request['days']);
			$newGroupPost->Saturday = in_array('Saturday', $request['days']);
			$newGroupPost->Sunday = in_array('Sunday', $request['days']);
			$newGroupPost->Topics = ''; //TODO add topics
			$newGroupPost->save();

			$newGroup = new Group;
			$newGroup->GroupUserID = Auth::user()->id;
			$newGroup->GroupPostID = $newGroupPost->GroupPostID;
			$newGroup->Accepted = 1;
			$newGroup->save();
			//temp, TODO: Return mygroups page
			return redirect('/');
		}
	}

}
