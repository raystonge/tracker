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
include_once "tracker/organization.php";
$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listUserGroups/">User Groups</a></h2>
    <?php
    if (isset($_SESSION['formErrors']))
    {
    	if (strlen($_SESSION['formErrors']))
    	{

    		$userGroup->name = $_SESSION['name'];
    		$userGroup->assignee = $_SESSION['assignee'];
    		?>
    		<div class="feedback error">
    		<?php
    		echo $_SESSION['formErrors'];
    		?>
    		</div>
    		<?php
    	}
    }
    ?>

<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/userGroup.php">
  <table class="width100">
    <tr>
      <td><?php echo $orgOrDept;?>:
      </td>
      <td>
        <select name="organizationId">
          <option value="0">Select <?php echo $orgOrDept;?></option>
          <?php
          $organization = new Organization();
          $ok = $organization->Get("organizationId in (".GetMyOrganizations().")");
          while ($ok)
          {
          	$selected = "";
          	if ($organization->organizationId == $userGroup->organizationId)
          	{
          		$selected = "selected='selected'";
          	}
          	?>
          	<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
          	<?php
          	$ok = $organization->Next();
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>UserGroup:
      </td>
      <td>
       <input type="text" name="name" class="ui-corner-left ui-corner-right" value="<?php echo $userGroup->name;?>"/>
      </td>
      <td>
    </tr>
    <tr>
      <td>Assignee:
      </td>
      <td><input type="checkbox" name="assignee" value="1" <?php if ($userGroup->assignee) {echo "checked='checked'";}?>>
      </td>
    </tr>
    <tr>
      <td>&nbsp;
      <input type="hidden" value="<?php echo $cnt;?>" name="cnt">
      <input type="hidden" value="1" name="submitTest">
      <input type="hidden" name="userGroupId" value="<?php echo $userGroup->userGroupId;?>"/>
      <input type="hidden" name="ajaxFormKey" value="<?php echo getAJAXFormKey();?>" />
      </td>
      <td>
        <input type="submit" name="submit" value="<?php echo $button;?>"/>
      </td>
    </tr>
  </table>
</form>
</div>
