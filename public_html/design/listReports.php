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
include_once "tracker/module.php";
include_once "tracker/permission.php";
PageAccess("Report: List");
?>
<div class="adminArea">
	<h2><a href="/listReports/" class="breadCrumb">Reports</a></h2>
	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th>
			Type
			</th>
			<th class="right"><strong>Actions</strong></th>
		</tr>
        <?php
        $module = new Module();
        //$param = "userId=".$currentUser->userId;
				$ok = $module->GetMyVisible();
        //$ok = $module->Get($param);
        while ($ok)
        {
			?>
		<tr class='mritem' id="<?php echo $module->moduleId;?>">
			<td class="adminData">
			<?php CreateLink("/viewReports/".$module->moduleId."/",$module->name,"",$title="View Report");?>
			</td>
			<td><?php echo $module->moduleType;?></td>
			<td class="right">
			<?php
			include $sitePath."/design/actions/module.php";
			if ($permission->hasPermission("Report: Edit") || $module->userId == $currentUser->userId)
			{
				echo $htmlAction;
			}
			?>
		    </td>
		</tr>
		<?php
		   $ok = $module->Next();
		   }
        ?>
     </table>

</div>
