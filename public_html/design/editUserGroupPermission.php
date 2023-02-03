<?php
//
//  Tracker - Version 1.5.0
//
//  v1.5.0
//   - cleaning up appears of checkbox
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
include_once "tracker/userGroup.php";
include_once "tracker/userGroupToPermission.php";
include_once "tracker/permission.php";
$userGroupId = 0;
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$userGroupId = $request_uri[2];
		DebugText("using param 2:".$userGroupId);
	}
}
$userGroup = new UserGroup($userGroupId);
?>
<h2>Permissions for : <?php echo $userGroup->name;?></h2>
<form id="userGroupPermissionForm" method="post" autocomplete="<?php echo $autoComplete;?>" class="cmxform" action="/process/userGroupPermissions.php">
  <table class="width100">
    <tr>
    <?php
    $cnt = 0;
    $userGroupToPermission = new UserGroupToPermission();
    $permission = new Permission();
    $ok = $permission->Get("");
    while ($ok)
    {
    	if (($cnt % 3) == 0)
    	{
    		echo "</tr>";
    		echo "<tr>";
    	}
    	$field = "permission".$permission->permissionId;
    	$checked = "";

    	$param = AddEscapedParam("","userGroupId",$userGroupId);
    	$param = AddEscapedParam($param,"permissionId",$permission->permissionId);
    	$param = AddEscapedParam($param, "organizationId", $userGroup->organizationId);
    	if ($userGroupToPermission->Get($param))
    	{
    		$checked ="checked='checked'";
    	}
    	?>
    	<td>
    	  <input type="checkbox" name="<?php echo $field;?>" <?php echo $checked;?> value="1">&nbsp;<?php echo $permission->name;?>
    	</td>
    	<?php
    	$cnt++;
    	$ok = $permission->Next();
    }
    for ($i = 0; $i<=$cnt%3;$i++)
    {
    	echo "<td>&nbsp;</td>";
    }
    ?>
    </tr>
    <tr>
      <td>
      &nbsp;<input type="hidden" name="userGroupId" value="<?php echo $userGroupId;?>"/>
      <input type="hidden" name="submitTest" value="1"/>
      </td>
      <td>
        <center><input type ="submit" name="submit" value="Update"/></center>
      </td>
      <td>
      &nbsp;
      </td>
    </tr>
  </table>
</form>
<?php
DebugOutput();
?>
