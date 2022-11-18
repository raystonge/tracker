<?php
//
//  AdSys - Version 1.0
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
include_once "tracker/userGroup.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Config: User Group");
$userGroup = new UserGroup();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

?>
<h2><a href="/config/" class="breadCrumb">Configuration</a> -> UserGroups</h2>
<?php
if ($permission->hasPermission("Config: User Group: Create"))
{
?>
<a id="newUserGroup" href="/newUserGroup/" class="addLink" <?php if($showMouseOvers){echo 'title="Create new User Group"';}?>>New User Group</a><br/>
<?php
}
?>
<form>
<table width="100%" border="0">
		    <tr>
		      <td>
		      <?php echo $orgOrDept;?> : 
		        <?php CreateHiddenField("hideLabel",1);?>
		        <select id="organizationId" name="organizationId">
		          <option value="0">All <?php echo $orgOrDept;?>s</option>
		          <?php
		          $param = "organizationId in (".GetMyOrganizations().")";
		          $organization= new Organization();
		          $ok = $organization->Get($param);
		          while ($ok)
		          {
		          	$selected = "";
		          	if ($searchOrganizationId == $organization->organizationId)
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
		      <td>
		      &nbsp;
		      </td>
		      <td>
		      &nbsp;
		      </td>
		    </tr>

<tr>

  <td>Name: <input id="name" name="name" type="text"  <?php if($showMouseOvers){echo 'title="Search by User Group Name"';}?> class="ui-corner-left ui-corner-right"/></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="submit" id="search" name="search" value="Search"></td>
  <td>&nbsp;
  <input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
  <input type="hidden" name="page" id="page" value="<?php echo $page;?>">
  </td>
  <td>&nbsp;</td>
</tr>
</table>
</form>

<div id="results">
</div>
