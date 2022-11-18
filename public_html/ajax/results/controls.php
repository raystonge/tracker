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
include_once "tracker/control.php";
include_once "tracker/permission.php";
PageAccess("Config: Controls");
$control = new Control();
//$control->SetPerPage(25);
$user = new User($_SESSION['userId']);
$param = AddEscapedParam("","sectionValue",$user->initials);
$param = AddParam($param,"keyValue='numRowsPerPage'");
if($control->Get($param))
{
  	$control->SetPerPage($control->valueInt);
}


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

$numRows = $control->Count($param);
$pages = 1;
if ($control->perPage)
{
	$pages = ceil($numRows/$control->perPage);
}
$control->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Section</strong>
			</th>
			<th align="left"><strong>Key</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php
		if (!$permission->hasPermission("Developer"))
		{
			$param = AddParam($param,"developer=0");
		}
		$ok = $control->Get($param);
		while ($ok)
		{
			?>
		<tr class='mritem' id="<?php echo $control->controlId;?>">
			<td class="adminData"><?php echo $control->section;?></td>
			<td class="adminData"><?php echo $control->key;?></td>
			<td>
			<?php 
			include $sitePath."/design/actions/control.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $control->Next();
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
