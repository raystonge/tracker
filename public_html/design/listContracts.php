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
include_once "tracker/contract.php";
include_once "tracker/permission.php";
PageAccess("Config: Contract");
$contract = new Contract();
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
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Contracts</h2>
	<?php
	if ($permission->hasPermission("Contract: Create"))
	{
		?>
	<div class="options">
		<a id="newContract" href="/newContract/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Contract"';}?>>New Contract</a>
	</div>
	<?php
	}
	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
			<tr>
				<td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				</td>
				<td><input id="search" type="hidden" name="Submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
