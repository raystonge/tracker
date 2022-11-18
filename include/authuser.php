<?php
//
//  AdSys - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
DebugText("authuser");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

include_once "tracker/user.php";
$currentUser = new User();
if (isset($_SESSION['userId']))
{
	$currentUser->GetUserByID($_SESSION['userId']);
	if (isset($_COOKIE['userId']) && !$currentUser->userId)
	{
		if ($_COOKIE['userId'])
		{
			$currentUser->GetUserByID($_COOKIE['userId']);
		}
	}	
	if (!$currentUser->userId)
	{
		session_destroy();
		@setcookie("userId",0);
		$redirect = "/login/";
		DebugPause($redirect);
		exit();
	}
	@setcookie("userId",$currentUser->userId,time()+300);
	?>
	<?php
}
?>
