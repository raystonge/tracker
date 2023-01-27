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
include_once "tracker/ticket.php";
include_once "tracker/module.php";
include_once "tracker/priority.php";
include_once "tracker/user.php";
include_once "tracker/status.php";
include_once "tracker/module.php";
include_once "tracker/permission.php";
PageAccess("Ticket: List");
$ticket = new Ticket();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
$reportModuleId = GetURI(2,0);
?>

<div class="adminArea">
	<h2><a href="/viewReports/" class="breadCrumb">Reports</a></h2>
	<?php
	$reportModuleId = GetTextField("reportModuleId",$reportModuleId);

DebugText("Compute page we are on");
$page = GetURI(3,1);

if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}

	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
		<table>
			<tr>
				<td valign="top">Report:
				</td>
				<td>
				  <select name="reportModuleId" id="reportModuleId">
				   <option value="0">Select a Report</option>
				    <?php
				    $module = new Module();
				    $ok = $module->GetMyVisible();
				    while ($ok)
				    {
				    	$selected = "";
				    	if ($module->moduleId==$reportModuleId)
				    	{
				    		$selected = "selected='selected'";
				    	}
				    	?>
				    	<option value="<?php echo $module->moduleId;?>" <?php echo $selected;?>><?php echo $module->name;?></option>
				    	<?php
				    	$ok = $module->Next();
				    }
				    ?>
				  </select>
				</td>
				<td>&nbsp;
				</td>
				<td>&nbsp;
				</td>
			</tr>
			<tr>
			  <td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				</td>
				<td><input id="search" type="submit" name="Submit" value="Submit" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
