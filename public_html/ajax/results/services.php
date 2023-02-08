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
include_once "globals.php";
include_once "cmsdb.php";
include_once "tracker/service.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Config: Asset Type");
$service = new Service();
$service->SetPerPage(25);
$user = new User($_SESSION['userId']);

$param = "";
$sectionName = "";
/*
if (!validateFormKey())
{
	DebugOutput();
	exit();
}
*/
if (isset($_POST['sectionName']))
{
	$sectionName=trim(strip_tags($_POST['sectionName']));
	if (strlen($sectionName))
	{
		$param = AddEscapedParam($param,"sectionValue",$sectionName);
	}

}

$page = 1;
if (isset($_POST['page']))
{
	$page = strip_tags($_POST['page']);
}
if (!isNumeric($page))
{
	$page=1;
}
$numRows = $service->Count($param);
$pages = 1;
if ($service->perPage)
{
	$pages = ceil($numRows/$service->perPage);
}
$service->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $service->Get($param);
		while ($ok)
		{
			?>
		<tr class='mritem' id="<?php echo $service->serviceId;?>">
			<td class="adminData"><?php echo $service->name;?></td>

			<td>
			<?php
			include $sitePath."/design/actions/service.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $service->Next();
		}
		?>
	</table>
<?php
//include $sitePath."/design/pagination/lower.php";
?>
<script language="javascript">
    	jQuery("body").removeClass("waitng");
    	jQuery("body").addClass("waitOver");
</script>
<?php DebugOutput();?>
