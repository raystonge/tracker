<?php
/*
 * Created on Nov 5, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/monitor.php";
include_once "tracker/asset.php";
include_once "tracker/permission.php";
PageAccess("Monitor");
ProperAccessTest("ajaxFormKey");
$state = GetTextField("state");
$buildingId = GetTextField("buildingId",0);
$assetTypeId = GetTextField("assetTypeId",0);
$_SESSION['monitorState'] = $state;
$_SESSION['monitorBuildingId'] = $buildingId;
$_SESSION['monitorAssetTypeId'] = $assetTypeId;
$query = "select m.* from monitor m inner join asset a on m.assetId=a.assetId";
$param = "active=1";
if ($buildingId)
{
	$param = AddEscapedParam($param,"a.buildingId",$buildingId);
}
if ($state >=0)
{
	$param = AddEscapedParam($param,"m.state",$state);
}
if ($assetTypeId)
{
	$param = AddEscapedParam($param,"a.assetTypeId",$assetTypeId);
}
if (strlen($param))
{
	$query = $query." where ".$param;
}
$monitor = new Monitor();
?>
<table class="width100">
  <tr>
    <th>
      Name
    </th>
    <th>
    FQDN
    </th>
    <th>
     IP Address
    </th>
    <th>
    State
    </th>
    <th>
    Time
    </th>
  </tr>
  <?php
  $ok = $monitor->doSelectQuery($query);
  while ($ok)
  {
  	$state = "Up";
  	if (!$monitor->state)
  	{
  		$state = "<span style='color:red;'>DOWN</span>";
  	}
  	?>
  	<tr class="mritem">
  	    <td><a href="/assetMonitor/<?php echo $monitor->assetId;?>/<?php echo $monitor->monitorId;?>/"><?php echo $monitor->name;?></a></td>
  	  <td><?php echo $monitor->fqdn;?></td>
  	  <td><?php echo $monitor->ipAddress;?></td>
  	  <td><?php echo $state;?></td>
  	  <td><?php echo $monitor->stateChangeDateTime;?></td>
  	</tr>
  	<?php
  	$ok = $monitor->Next();
  }
  ?>
</table>
<?php DebugOutput();?>
