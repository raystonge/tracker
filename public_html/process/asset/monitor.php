<?php
//
//  Tracker - Version 1.13.0
//
//  v1.13.0
//   - added support for specifying which monitor server is doing the monitor
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
include_once "tracker/monitorToUser.php";
include_once "tracker/assetType.php";
$_SESSION['formErrors'] ="";
$_SESSION['assetMonitorActive'] = "";
$_SESSION['assetMonitorFQDN'] = "";
$_SESSION['assetMonitorIPAddress'] = "";
$_SESSION['assetMonitorNotify'] = "";
$_SESSION['assetMonitorMonitorURL'] = "";
$_SESSION['assetMonitorPingAddress'] = "";
$_SESSION['assetSMSNotice'] = "";
$_SESSION['assetMonitorWhine'] = 0;
$_SESSION['assetMonitorServerId'] = 0;

$html="";
$numErrors = 0;
$errorMsg = "";
ProperAccessValidate();
$assetId = GetTextField('assetId',0);
$monitorId = GetTextField('monitorId',0);
$name = GetTextField("name");
$monitorURL = GetTextField("monitorURL");
$pingAddress = GetTextField("pingAddress");
$smsNotify = GetTextField("smsNotice",0);
$whine = GetTextField("whine",0);
$asset = new Asset($assetId);
$monitorType = GetTextField("monitorType");
$monitorServerId = GetTextField("monitorServerId");
$assetType = new AssetType($asset->assetTypeId);
if (!$asset->assetId)
{
	exit;
}
$fqdn = GetTextField('fqdn');
$ipAddress = GetTextField("ipAddress");
$notify = "";
$monitorURL = GetTextField("monitorURL");
$active = GetTextField("active",0);
if (strlen($name) == 0 && $permission->hasPermission("Asset: Edit: Name"))
{
    $numErrors++;
    $errorMsg=$errorMsg."<li>Please Specify a Name</li>";
}

if (!$monitorId == 0 && $permission->hasPermission("Asset: Edit: Monitor Server"))
{
    $numErrors++;
    $errorMsg=$errorMsg."<li>Please Specify a Monitor Server</li>";
}
if (strlen($fqdn) == 0 && $permission->hasPermission("Asset: Edit: FQDN"))
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify an FQDN</li>";
}
if (strlen($ipAddress) == 0 && $permission->hasPermission("Asset: Edit: IP Address") && $assetType->monitorType=="ping")
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify an IP Address</li>";
}
else
{
	if (!validIPAddress($ipAddress) && $permission->hasPermission("Asset: Edit: IP Address") && $assetType->monitorType=="ping")
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please enter a valid IP Address</li>";
	}
}
if (strlen($monitorURL) == 0 && $permission->hasPermission("Asset: Edit: Monitor URL") && $assetType->monitorType == "monitorURL")
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify an IP Address</li>";
}
if (strlen($pingAddress) == 0 && $permission->hasPermission("Asset: Edit: Ping Address") && $assetType->monitorType == "pingAddress")
{
	$numErrors++;
	$errorMsg=$errorMsg."<li>Please Specify an IP Address</li>";
}
if ($numErrors == 0)
{
	$action = "Create";
	if ($monitorId)
	{
		$action = "Change";
	}

	$monitor = new Monitor($monitorId);
	$monitor->monitorType = $monitorType;
	if ($monitor->name != $name)
	{
	    $old = $monitor->name;
	    $monitor->name = $name;
	    $historyVal = CreateHistory($action,"Name", $old,$fqdn);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	        array_push($historyArray,$historyVal);
	    }
	}
	if ($monitor->fqdn != $fqdn)
	{
		$old = $monitor->fqdn;
		$monitor->fqdn = $fqdn;
		$historyVal = CreateHistory($action,"FQDN", $old,$fqdn);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
		   	array_push($historyArray,$historyVal);
		}
	}
	if ($monitor->ipAddress != $ipAddress)
	{
		$old = $monitor->ipAddress;
		$monitor->ipAddress = $ipAddress;
		$historyVal = CreateHistory($action,"IP Address", $old,$ipAddress);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
		   	array_push($historyArray,$historyVal);
		}
	}
	if ($monitor->active != $active)
	{
		$old = "Inactive";
		$monitor->active = $active;
		if ($old)
		{
			$old = "Active";
		}
		if ($active)
		{
			$active = "Active";
		}
		else
		{
			$active = "Inactive";
		}
		$historyVal = CreateHistory($action,"Active", $old,$active);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
		   	array_push($historyArray,$historyVal);
		}
	}
	if ($monitor->whine != $whine)
	{
	    $old = "Inactive";
	    $monitor->whine = whine;
	    if ($old)
	    {
	        $old = "Active";
	    }
	    if ($whine)
	    {
	        $whine = "Active";
	    }
	    else
	    {
	        $whine = "Inactive";
	    }
	    $historyVal = CreateHistory($action,"Whine", $old,$whine);
	    DebugText("history:".$historyVal);
	    if (strlen($historyVal))
	    {
	        array_push($historyArray,$historyVal);
	    }
	}
	if ($monitor->monitorURL != $monitorURL)
	{
		$old = $monitor->monitorURL;
		$monitor->monitorURL = $monitorURL;
		$historyVal = CreateHistory($action,"Monitor URL", $old,$monitorURL);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
			array_push($historyArray,$historyVal);
		}
	}
	if ($monitor->pingAddress != $pingAddress)
	{
		$old = $monitor->pingAddress;
		$monitor->pingAddress = $pingAddress;
		$historyVal = CreateHistory($action,"Ping Address", $old,$pingAddress);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
			array_push($historyArray,$historyVal);
		}
	}
	DebugText("monitor->smsNotify:".$monitor->smsNotice.":".$smsNotify);
	if ($monitor->smsNotice != $smsNotify)
	{
		DebugText("set smsNotice");
		$old = $monitor->smsNotice;
		$monitor->smsNotice = $smsNotice;
		$historyVal = CreateHistory($action,"SMS Notify", $old,$smsNotice);
		DebugText("history:".$historyVal);
		if (strlen($historyVal))
		{
			array_push($historyArray,$historyVal);
		}
	}


	$monitor->assetId = $assetId;
	$monitor->Persist();
	$monitorToUser = new MonitorToUser();
	//$monitorToUser->Reset($monitor->monitorId);
	$notified = new Set(",");
	$cnt = 0;
	if (isset($_POST['notify']) && $permission->hasPermission("Asset: Edit: Notify"))
	{
		@$notifies = $_POST['notify'];
		//while (list ($key, $notify) = each ($notifies) && $cnt< 10)
		for ($i=0; $i < sizeof($notifies);$i++)
		{
			$cnt++;
			$notify = $notifies[$i];
			$notified->Add($notify);
			$param = "userId=".$notify." and monitorId=".$monitor->monitorId;
			if (!$monitorToUser->Get($param))
			{
				$monitorToUser->monitorId = $monitor->monitorId;
				$monitorToUser->userId = $notify;
				$monitorToUser->Insert();
				$user = new User($notify);
				$historyVal = "Added User: ".$user->fullName;
		    	array_push($historyArray,$historyVal);
			}
		}
		$param = "monitorId=".$monitor->monitorId;
		$ok = $monitorToUser->Get($param);
		while ($ok)
		{
			if (!$notified->InSet($monitorToUser->userId))
			{
				$monitorToUser->Delete();
				$user = new User($monitorToUser->userId);
				$historyVal = "Removed User: ".$user->fullName;
				DebugText("historyVal:".$historyVal);
		    	array_push($historyArray,$historyVal);
			}
			$ok = $monitorToUser->Next();
		}
	}
	else
	{
		if (!isset($_POST['notify']) && $permission->hasPermission("Asset: Edit: Notify"))
		{
			$param = "monitorId=".$monitor->monitorId;
			$ok = $monitorToUser->Get($param);
			while ($ok)
			{
				$monitorToUser->Delete();
				$user = new User($monitorToUser->userId);
				$historyVal = "Removed User: ".$user->fullName;
				DebugText("historyVal:".$historyVal);
				array_push($historyArray,$historyVal);
				$ok = $monitorToUser->Next();
			}
		}
	}

	DebugText("sizeof History:".sizeof($historyArray));
    $historyVal = array_pop($historyArray);
	while (strlen($historyVal))
	{
    DebugText("historyVal:".$historyVal);
	  $history = new History();
		$history->assetId = $asset->assetId;
		$history->userId = $_SESSION['userId'];
		$history->actionDate = $now;
		$history->action = $historyVal;
		$history->Insert();
		$historyVal = array_pop($historyArray);
	}

}
else
{
	$html = "<ul>".$errorMsg."</ul>";
	$_SESSION['formErrors'] = $html;
	$_SESSION['assetMonitorName'] = $name;
	$_SESSION['assetMonitorFQDN'] = $fqdn;
	$_SESSION['assetMonitorIPAddress'] = $ipAddress;
	$_SESSION['assetMonitorNotify'] = "";
	$_SESSION['assetMonitorActive'] = $active;
	$_SESSION['assetMonitorMonitorURL'] = $monitorURL;
	$_SESSION['assetMonitorPingAddress'] = $pingAddress;
	$_SESSION['assetSMSNotice'] = $smsNotify;
  $_SESSION['assetMonitorServerId'] = $monitorServerId;
	DebugPause("/assetMonitor/$asset->assetId/");
}

DebugPause("/assetMonitor/$assetId/");
?>
