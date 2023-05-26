<?php
//
//  Tracker - Version 1.6.0
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
include_once "tracker/user.php";
include_once "tracker/userGroup.php";
include_once "tracker/organization.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: User: Create");
$user = new User();
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
<div class="adminArea">
  <h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listUsers/">Users</a></h2>
	<form method="post" name="form1" id="form1"  autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/doUserImport">
	<?php
	CreateFileField("importFile","Select file to Import");
	PrintBR();
	CreateCheckBox("ignoreBasicPlan",1,"Ignore Basic Plan",0,"Click to ignore Exchange Online (Plan 1)","ignore");
	PrintBR();
	PrintBR();
	?>
	<table width="100%">
	 <tr>
		 <th>
			 User Group
		 </th>
		 <th>
		 <th>
			 Organization
		 </th>
	 </tr>
	 <tr>
		 <td valign="top">
		<?php
     $userGroup = new UserGroup();
		 $ok = $userGroup->Get("");
		 while ($ok)
		 {
			 ?>

					 <?php CreateCheckBox("userGroup".$userGroup->userGroupId,$userGroup->userGroupId, $userGroup->name,0,"Click to add to this group","userGroup"); ?>
				 <br/>
			 <?php
			 $ok = $userGroup->Next();
		 }
		 ?>
	   </td>
	   <td valign="top">
		 <?php
		 $organization = new Organization();
		 $ok = $organization->Get("");
		 while ($ok)
		 {
			 ?>
					 <?php CreateCheckBox("organization".$organization->organizationId,$organization->organizationId, $organization->name,0,"Click to add to this Organization","organization"); ?>
				 <br/>
			 <?php
			 $ok = $organization->Next();
		 }
		 ?>
	   </td>
	 </tr>
	</table>
	<?php
	PrintFormKey();
	CreateSubmit();
	?>
	</form>
</div>
