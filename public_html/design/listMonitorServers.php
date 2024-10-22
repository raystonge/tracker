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
include_once "tracker/assetType.php";
include_once "tracker/permission.php";
PageAccess("Config: Monitor Servers");
$assetType = new AssetType();
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
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Monitor Servers</h2>
	<div class="options">
		<a id="newMonitorServer" href="/newMonitorServer/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Monitor Server"';}?>>New Monitor Server</a>
	</div>
	<?php
	$monitorServerName = "";

	if (isset($_POST['monitorServerName']))
	{
		$monitorServerName=trim(strip_tags($_POST['monitorServerName']));
	}

	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
		<table>
			<tr>
				<td valign="top">Section:
				</td>
				<td><input name="monitorServer" type="text" <?php if ($showMouseOvers){echo 'title="Search by Monitor Server"';};?>
					value="<?php echo $monitorServerName;?>" /><br />
				</td>
			</tr>
			<tr>
				<td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				</td>
				<td><input id="search" type="submit" name="Submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
