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
include "globals.php";
include_once "tracker/permission.php";
include_once "tracker/module.php";

//ProperAccessTest();
$permission = new Permission();
$_SESSION['searchNumPerPage'] = $maxTicketsPerPage;
$moduleId = GetTextField("reportModuleId",0);
if ($moduleId == 0)
{
	exit;
}
$module = new Module($moduleId);
$reportFile = "";
DebugText("module type:".$module->moduleType);
switch ($module->moduleType)
{
	case "ticket" :
	case "Ticket" : $reportFile = "/ajax/results/reports/ticket.php";
	                $module->moduleType = "Ticket";
	                break;
	case "asset"  :
	case "Asset"  : $reportFile = "/ajax/results/reports/asset.php";
	                $module->moduleType = "Asset";
	                break;
}
$reportType = strtolower($module->moduleType);
?>
<table class="width100">
  <tr>
    <td>
    <?php
  if ($module->userId)
  {
  	CreateLink("/edit".$module->moduleType."Report/".$module->moduleId."/","Edit Report","editReport","Edit ".$module->name);
  }
    ?>
    </td>
    <td align="right">
    <?php
    $permissionName = "Report: ".$module->moduleType.": Export";
    if ($permission->hasPermission($permissionName))
    {
    	CreateLinkNewWindow("/process/report/export/".$reportType.".php?id=".$module->moduleId,"Export","exportReport","Export ".$module->name);
    }
    ?>
    </td>
  </tr>
</table>
<?php
echo $sitePath.$reportType."<Br>";
DebugText("Report File:".$sitePath.$reportFile);
include $sitePath.$reportFile;
DebugOutput();
?>
