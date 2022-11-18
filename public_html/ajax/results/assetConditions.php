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
include_once "tracker/assetCondition.php";
include_once "tracker/permission.php";
PageAccess("Config: Asset Condition");
$assetCondition = new AssetCondition();
$assetCondition->SetPerPage(25);
$user = new User($_SESSION['userId']);

$param = "";
$sectionName = "";
ProperAccessTest();

$sectionName = GetTextField("sectionName");
if (strlen($sectionName))
{
	$param = AddEscapedParam($param,"sectionValue",$sectionName);
}
$page = GetTextField("page",1);
if (!isNumeric($page))
{
	$page=1;
}

$numRows = $assetCondition->Count($param);
$pages = 1;
if ($assetCondition->perPage)
{
	$pages = ceil($numRows/$assetCondition->perPage);
}
$assetCondition->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $assetCondition->Get($param);
		while ($ok)
		{
			?>
		<tr class='mritem' id="<?php echo $assetCondition->assetConditionId;?>">
			<td class="adminData"><?php echo $assetCondition->name;?></td>
			
			<td>
			<?php 
			include $sitePath."/design/actions/assetCondition.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $assetCondition->Next();
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
