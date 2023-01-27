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
?>
<?php
include_once "globals.php";
include_once "tracker/user.php";
include_once "JSON.php";
$name = "";
$json = new JSON();
if (isset($_GET['term']))
{
	$name = trim($_GET['term']);
}

$user = new User();

$param = AddEscapedLikeParam("","fullName","%".$name."%");
$param = AddEscapedParam($param,"uto.organizationId",GetTextFromSession("ticketEditOrg",0));
$ok = $user->GetRequestors($param);
while($ok)
{
	$userInfo = new User($user->userId);
	$json->AddValue("id",$user->userId);
	$json->AddValue("label",$userInfo->fullName);
	$json->CreateRecord();
	$ok = $user->Next();
}
echo $json->GetArray();
//DebugOutput();
?>
