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
include_once "tracker/asset.php";
include_once "tracker/monitor.php";
/*
if (!testAJAXFormKey())
{
	exit;
}
*/
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$history = new History();
if ($asset->assetId)
{
	$monitor = new Monitor();
	$param = "assetId = ".$asset->assetId;
	$monitor->Get($param);
	$origState = $monitor->state;
	$state = "Up";
	$pingAddress = "";
	if (strlen($monitor->ipAddress))
	{
		$pingAddress = $monitor->ipAddress;
	}
	else
	{
		if (strlen($monitor->pingAddress))
		{
			$pingAddress = $monitor->pingAddress;
		}
	}
	$status = 1;
	$outcome = "";
	if (strlen($pingAddress))
	{
		$pingresult = exec("/bin/ping -c2 -w2 $pingAddress", $outcome, $status);
	}
    if ($status==0)
    {
    	$monitor->state = 1;
    	$history->action = "Device is now online";
    }
    else
    {
    	$monitor->state = 0;
    	$history->action = "Device is now offline";
    }
	if (!$monitor->state)
	{
		$state = "<span style='color:red;'>DOWN</span>";
	}
	if ($origState != $monitor->state)
	{
		$history->assetId = $monitor->assetId;
		$monitor->UpdateState();
		$history->Insert();
	}
	echo $state." - ".$monitor->stateChangeDateTime;
}
//DebugOutput();
?>
