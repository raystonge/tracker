<?php
/*
 * Created on Jun 27, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "cmsdb.php";
include_once "tracker/building.php";
include_once "tracker/organization.php";
include_once "tracker/permission.php";
PageAccess("Config: Building");
$building = new Building();
$building->SetPerPage(25);
$user = new User($_SESSION['userId']);

$param = "";
$sectionName = "";
$organizationId = 0;
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
$organizationId = GetTextField("organization",0);
if (!$organizationId)
{
	$param1 = "organizationId in (".GetMyOrganizations().")";
	$param = AddParam($param,$param1);
}
else
{
	$param = AddParam($param,"organizationId=".$organizationId);
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
$building->SetOrderBy("organizationId");
$numRows = $building->Count($param);
$pages = 1;
if ($building->perPage)
{
	$pages = ceil($numRows/$building->perPage);
}
$building->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $building->Get($param);
		while ($ok)
		{
			$organization = new Organization($building->organizationId);
			?>
		<tr class='mritem' id="<?php echo $building->buildingId;?>">
			<td class="adminData"><?php echo $organization->name." - ".$building->name;?></td>

			<td>
			<?php
			include $sitePath."/design/actions/building.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $building->Next();
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
