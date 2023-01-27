<?php
//
//  Tracker - Version 1.0
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
include_once "globals.php";
include_once "cmsdb.php";
include_once "tracker/user.php";
// Override what is loaded from the database;
$sitePath = $_SERVER['DOCUMENT_ROOT'];

$currentUser = new User();
if (!isset($_SESSION['failedLogin']))
{
	$_SESSION['failedLogin'] = 0;
}
$request_uri = array();
$request_uri =explode("/",$_SERVER['REQUEST_URI']);

include_once "authuser.php";
$loggedIn = 0;
if (isset($_SESSION['userId']))
{
	$loggedIn = $_SESSION['userId'];
}
DebugText("loggedIn:".$loggedIn);
DebugText("uri:".$_SERVER['REQUEST_URI']);


//$request_uri[4] is the first parameter to the page
//$request_uri[5] is the second parameter to the page
$page = "";
if (isset($request_uri[3]))
{
  if (strlen($request_uri[3]))
  {
    $page = $request_uri[3];
	  DebugText("using param 3:".$page);
  }
  else
  {
    if (isset($request_uri[2]))
		{
			$page = "home";
	  }
  }
}

if (!strlen($page) && strlen($request_uri[1]))
{
  if (strlen($request_uri[1]))
  {
    $page = $request_uri[1];
	  DebugText("using param 1:".$page);
  }
}
if (!strlen($page))
{
  $page = "home";
}
if (!isset($_SESSION['userId']))
{
	$page = "start";
}
$firstDir = "";
$siteRegion = "";
$sitePage = "";
if (isset($request_uri[1]))
{
  $firstDir = $request_uri[1];
}
DebugText("firstDir:".$firstDir);
$navFile = "nav.php";
if ($sitePage == "viewItem")
{
  $navFile = "";
}
if ($firstDir == "index.html")
{
  $firstDir = "";
}
if (is_numeric($firstDir))
{
  $templateName =$sitePath.$designPath."/post.php";
  $postId=$firstDir;
  $post->GetById($postId);
}
else
{
  if (strlen($firstDir) == 0)
  {
   $firstDir = "home";
  }
  if (!isset($_SESSION['userId']) && $firstDir != "forgot" && $firstDir != "forgotsent" && $firstDir !="resetpassword")
  {
  	$firstDir = "start";
  }
  $templateName =$sitePath.$designPath."/".$firstDir.".php";
}
if ($firstDir == "logout")
{
	DebugText("doing logout");
	$_SESSION['userId'] = 0;
	$_SESSION['userName'] = "";
	$_SESSION['userGroups'] = 0;
	$_SESSION['userPassword'] = "";
	$_SESSION['lastRunOverDue'] = '2013-01-01 00:00:00';
	session_destroy();
	session_unset();

	$firstDir = "start";
	$templateName =$sitePath.$designPath."/".$firstDir.".php";
}
DebugText("Desired Template:".$templateName);
if (!file_exists($templateName))
{
  $templateName = $sitePath.$designPath."/pageNotFound.php";
}
$permission = new Permission();
?>
