<?php
//
//  Tracker - Version 1.9.0
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
//  See the License for the specific language governing services and
//  limitations under the License.
//
?>
<?php
include_once "globals.php";
include_once "tracker/service.php";
include_once "tracker/userToService.php";
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
$userId = 0;
if (isset($_POST['userId']))
{
	$userId = strip_tags($_POST['userId']);
}
if (isset($_POST['submitTest']))
{
	$userId = strip_tags($_POST['userId']);
	$userToService = new UserToService();
	$userToService->userId = $userId;
	$userToService->Reset();
  $service = new Service();

  $ok = $service->Get($param);
  while ($ok)
  {
		$userToService = new UserToService();
		$field = "service".$service->serviceId;
		$fieldAdmin = "serviceAdmin".$service->serviceId;
    if (isset($_POST[$field]) || isset($_POST[$fieldAdmin]))
    {
    	$userToService->userId = $userId;
    	$userToService->serviceId = $service->serviceId;
			if (isset($_POST[$fieldAdmin]))
			{
				$userToService->adminAccess = 1;
			}
  		$userToService->Insert();
  	}
  	$ok = $service->Next();
  }
  $status = 'success';
  DebugPause("/listUsers/");
}
?>
