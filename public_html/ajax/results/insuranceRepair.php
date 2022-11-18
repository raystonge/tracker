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
include_once "tracker/insuranceRepairComplete.php";
include_once "tracker/permission.php";
PageAccess("Config: Insurance Repair");
$insuranceRepairComplete = new InsuranceRepairComplete();
$insuranceRepairComplete->SetPerPage(25);
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

$numRows = $insuranceRepairComplete->Count($param);
$pages = 1;
if ($insuranceRepairComplete->perPage)
{
	$pages = ceil($numRows/$insuranceRepairComplete->perPage);
}
$insuranceRepairComplete->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $insuranceRepairComplete->Get($param);
		while ($ok)
		{
			?>
		<tr class='mritem' id="<?php echo $insuranceRepairComplete->insuranceRepairCompleteId;?>">
			<td class="adminData"><?php echo $insuranceRepairComplete->name;?></td>
			
			<td>
			<?php 
			include $sitePath."/design/actions/insuranceRepairComplete.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $insuranceRepairComplete->Next();
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
