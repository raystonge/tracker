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
include_once "tracker/service.php";
include_once "tracker/defaultUser.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
if (isset($_POST['submitTest']))
{
	$validated = false;
	$status='fail';
	$html="";

	$assignee = 0;
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;

    $service = new Service();

	if (isset($_POST['serviceId']))
	{
		$serviceId=strip_tags($_POST['serviceId']);
		$service->GetById($serviceId);
	}
	$name = GetTextField("name");
	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";
	}
	else
	{
		$param = "serviceId<>".$serviceId;
		$param = AddEscapedParam($param,"name",$name);
		$testService = new Service();
		if ($testService->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Service already in use</li>";
		}
	}


	if ($numErrors ==0)
	{
		$service->name = $name;
    $service->Persist();
		DebugPause("/listServices/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;
		$_SESSION['formErrors'] = $html;
		if ($service->serviceId)
		{
			DebugPause("/editService/".$service->serviceId."/");
		}
		DebugPause("/newService/");
	}
}
DebugPause("/listServiced/");
?>
