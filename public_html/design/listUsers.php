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
include_once "tracker/user.php";
include_once "tracker/permission.php";
PageAccess("Config: User");
$adRep = new User();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

$searchName = GetTextField("searchName",GetTextFromSession("searchName"));
$searchEmail = GetTextField("searchEmail",GetTextFromSession("searchEmail"));
$searchActive = GetTextField("searchActive",GetTextFromSession("searchActive",1));
?>
<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Users</h2>
<?php
if ($permission->hasPermission("Config: User: Create"))
{
?>
<a id="newUser" href="/newUser/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new User"';}?>>New User</a><br/>
<?php
}
?>
<form method="post" autocomplete="<?php echo $autoComplete;?>">
<table width="100%" border="0">
<tr>
  <td>Name: <?php CreateTextField("searchName",$searchName,getFieldSize("users","fullName"),"Search by Name");?></td>
  <td>Email: <?php CreateTextField("searchEmail",$searchEmail,getFieldSize("users","email"),"Email Address");?></td>
  <td>Active:
    <select id="searchActive" name="searchActive">
      <option value="-1" <?php if ($searchActive == "-1") echo "selected='selected'";?>>All</option>
      <option value="1" <?php if ($searchActive == 1) echo "selected='selected'";?>>Active</option>
      <option value="0" <?php if ($searchActive == 0) echo "selected='selected'";?>>Inactive</option>
    </select>
  </td>
</tr>
<tr>
  <td><input type="submit" id="search" name="search" value="Search"></td>
  <td>
  <?php
  PrintFormKey();
  CreateHiddenField("page",$page);
  PrintNBSP();
  ?>
  </td>
  <td>&nbsp;</td>
</tr>
</table>
</form>

<div id="results">
</div>
