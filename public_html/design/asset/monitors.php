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
?><?php
$searchSerialNumber = GetTextField("assetSerialNumber");
$searchAssetTag = GetTextField("assetAssetTag");
?>
<a href="/newMonitor/<?php echo $assetId;?>/">Create new Monitor</a>
<table width="100%">
 <tr>
   <th>
     Name
   </th>
   <th>
     State
   </th>
   <th>
     Time
   </th>
 </tr>

<?php
$monitor = new Monitor();
$param = AddEscapedParam("", "assetId", $assetId);
$ok = $monitor->Get($param);
while ($ok)
{
    $state = "Up";
    if (!$monitor->state)
    {
        $state = "<span style='color:red;'>DOWN</span>";
    }

    ?>
    <tr class="mritem">
      <td>
        <a href="/assetMonitor/<?php echo $monitor->assetId;?>/<?php echo $monitor->monitorId;?>/"><?php echo $monitor->name;?></a>
      </td>
      <td>
        <?php echo $state;?>
      </td>
      <td>
        <?php echo $monitor->stateChangeDateTime;?>
      </td>
    </tr>
    <?php
    $ok = $monitor->Next();

}
?>
</table>
<div id="assetTickets"></div>
<div class="clear"></div>
