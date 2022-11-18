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
include_once "tracker/assetType.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/spec.php";
PageAccess("Config: Spec");
$assetType = new AssetType();
//$assetType->SetPerPage(25);
$spec = new Spec();
$spec->SetPerPage(25);
$user = new User($_SESSION['userId']);

$param = "";
$specName = "";
/*
if (!validateFormKey())
{
	DebugOutput();
	exit();
}
*/
if (isset($_POST['specName']))
{
	$specName=trim(strip_tags($_POST['specName']));
	if (strlen($specName))
	{
		$param = AddEscapedParam($param,"sectionValue",$specName);
	}

}
$assetTypeId = GetTextField("assetType",0);
if ($assetTypeId)
{
	$param = AddEscapedParam($param, "assetTypeId", $assetTypeId);
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
//$assetType->SetOrderBy("organizationId");
$spec->SetOrderBy("name");
$numRows = $spec->Count($param);
$pages = 1;
if ($spec->perPage)
{
	$pages = ceil($numRows/$spec->perPage);
}
$spec->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $spec->Get($param);
		while ($ok)
		{
		//	$assetType = new AssetType($spec->assetTypeId);
		//	$organization = new Organization($assetType->organizationId);
			?>
		<tr class='mritem' id="<?php echo $spec->specId;?>">
			<td class="adminData"><?php echo $spec->name;?></td>

			<td>
			<?php
			include $sitePath."/design/actions/spec.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $spec->Next();
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
