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
include_once "cmsdb.php";
include_once "tracker/monitorServer.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Config: Monitor Server");


$monitorServer = new MonitorServer();
$monitorServer->SetPerPage(25);
$user = new User($_SESSION['userId']);
$key = CreateLinkKey("deletemonitorServer");

$param = "";
$monitorServerName = "";
/*
if (!validateFormKey())
{
	DebugOutput();
	exit();
}
*/
if (isset($_POST['monitorServerName']))
{
	$monitorServerName=trim(strip_tags($_POST['monitorServerName']));
	if (strlen($monitorServerName))
	{
		$param = AddEscapedParam($param,"sectionValue",$monitorServerName);
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
$numRows = $monitorServer->Count($param);
$pages = 1;
if ($monitorServer->perPage)
{
	$pages = ceil($numRows/$monitorServer->perPage);
}
$monitorServer->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $monitorServer->Get($param);
		while ($ok)
		{			
			?>
		<tr class='mritem' id="<?php echo $monitorServer->monitorServerId;?>">
			<td class="adminData"><?php echo $monitorServer->name;?></td>

			<td>
			<?php
			include $sitePath."/design/actions/monitorServer.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $monitorServer->Next();
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
