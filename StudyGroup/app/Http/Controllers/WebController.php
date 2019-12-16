<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\GroupPost;
use Auth;
use DB;

class WebController extends Controller
{

	////////////////////////////////////////// INDEX PAGE //////////////////////////////////////////

	/*
	Handles the querying of groups. Authentication not necessary, but will therefore only be 'views' and won't have ability to apply
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

	//API endpoint for removing a request to join a group from the queried index page
	function removeRequestJoin(Request $request)
	{
		if(!Auth::user())
		{
			redirect('/login');
		}

		//Soft delete the request
		Group::where('GroupPostID', $request['postid'])->where('GroupUserID', Auth::user()->id)->where('Accepted', 0)->update(['Deleted' => 1]);
	}

	//API endpoint for adding a request to join a group from the queried index page
	function requestJoin(Request $request)
	{
		if(!Auth::user())
		{
			redirect('/login');
		}

		//Insert the request
		$newGroup = new Group;
		$newGroup->GroupUserID = Auth::user()->id;
		$newGroup->GroupPostID = $request['postid'];
		$newGroup->Accepted = 0;
		$newGroup->save();
	}

	////////////////////////////////////////// MYGROUPS AND CREATING GROUPS RELATED //////////////////////////////////////////
	
	//Display the user's groups. If they aren't logged in, redirect to login
	function myGroups(Request $request)
	{
		if(!Auth::user())
		{
			return redirect('/login');
		}

		//Get all groups this user is part of, and all the groups the user owns
		$groups = DB::select('exec StudyApp_GetMyGroups ?', array(Auth::user()->id));

		return view('mygroups', ['groups' => $groups]);
	}

	//Display fthe form to create a group. If they aren't logged in, redirect to login
	function createGroup(Request $request)
	{
		//Check if auth. If not, go to index
		if(!Auth::user())
		{
			return redirect('/login');
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
			return redirect('/mygroups');
		}
	}

	//API endpoint for deleting a group from the myGroup view. Only allow this if they are authorized to do so
	function deleteGroup(Request $request) 
	{
		if(Auth::user()) 
		{
			//Only delete the group if the user is an authenticated user that actually owns the post
			$group = GroupPost::where('GroupPostID', $request['postid'])->where('GroupOwnerID', Auth::user()->id)->update(['Deleted' => 1]);
			return 1;
		}
		return 0;
	}

	//API endpoint for leaving a group from the myGroup view. Only allow this if they are authorized to do so
	function leaveGroup(Request $request) 
	{
		if(Auth::user()) 
		{
			//Only leave the group if the user is an authenticated user that actually is part of the group
			$group = Group::where('GroupPostID', $request['postid'])->where('GroupUserID', Auth::user()->id)->where('Accepted', 1)->update(['Deleted' => 1]);
			return 1;
		}
		return 0;
	}

	//API endpoint for getting all the users who are part of a group post from the myGroup view. Only allow this if they are authenticated
	function getUsersFromGroup(Request $request)
	{
		if(Auth::user())
		{
			$users = DB::select('exec StudyApp_GetUsersFromGroup ?,?', array($request['postid'], Auth::user()->id));
			return json_encode($users);
		}
		return 0;
	}

	//API endpoint for removing a user from a group from the myGroup view. Only allows it if hte user is authenticated to do so
	function removeUserFromGroup(Request $request)
	{
		if(Auth::user())
		{
			DB::update('exec StudyApp_RemoveUserFromGroup ?,?,?', array(Auth::user()->id, $request['uid'], $request['postid']));
			return 1;
		}
		return 0;
	}

	//API endpoint for accepting a user into a group from the myGroup view. Only allows it if hte user is authenticated to do so
	function acceptUserIntoGroup(Request $request)
	{
		if(Auth::user())
		{
			DB::update('exec StudyApp_AcceptRequestToJoinUserFromGroup ?,?,?', array(Auth::user()->id, $request['uid'], $request['postid']));
			return 1;
		}
		return 0;
	}

}
