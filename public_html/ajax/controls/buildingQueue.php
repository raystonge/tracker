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
include_once "tracker/queue.php";
include_once "tracker/building.php";
$organizationId = GetTextField("organizationId",0);
$buildingId = GetTextField("buildingId",0);
$building = new Building($buildingId);
if (!$organizationId)
{
	$organizationId = $building->organizationId;
}
?>
<?php
if ($permission->hasPermission("Config: Building"))
{
?>
	<select name="queueId" id="queueId">
       <option value="0">Select a Queue</option>
       <?php
       $param = "";
       $param = AddEscapedParam($param,"organizationId",$organizationId);
       /*if ($organizationId)
       {
         $param = AddEscapedParam($param,"organizationId",$organizationId);
       }
       else
       {
         $param = "organizationId in (".GetMyOrganizations().")";
       }
       */
       $queue = new Queue();
       $ok = $queue->Get($param);
       DebugText("building queue:".$building->queueId);
       while ($ok)
       {
         $selected = "";
         if ($building->queueId == $queue->queueId)
         {
         	 $selected = "selected='selected'";
         }
         ?>
         <option value="<?php echo $queue->queueId;?>" <?php echo $selected;?>><?php echo $queue->name;?></option>
         <?php
         $ok = $queue->Next();
       }
       ?>
   </select>
   <?php
}
else
{
	$queue = new Queue($building->queueId);
	CreateHiddenField("queue",$building->queueId);
	if ($permission->hasPermission("building: View: Queue"))
	{
		echo "Queue: ".$queue->name;
	}
}
//DebugOutput();
?>
