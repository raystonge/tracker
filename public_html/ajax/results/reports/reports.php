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
