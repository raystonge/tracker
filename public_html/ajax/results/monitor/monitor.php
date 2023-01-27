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
