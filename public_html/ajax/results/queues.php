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
include_once "tracker/queue.php";
include_once "tracker/organization.php";
include_once "tracker/permission.php";
PageAccess("Config: Queue");
$queue = new Queue();
$queue->SetPerPage(25);
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
$organizationId = GetTextField("organization",0);
if ($organizationId)
{
	$param = AddEscapedParam($param,"organizationId",$organizationId);
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

$queue->SetOrderBy("organizationId");
$numRows = $queue->Count($param);
$pages = 1;
if ($queue->perPage)
{
	$pages = ceil($numRows/$queue->perPage);
}
$queue->SetPage($page);

//include $sitePath."/design/pagination/upper.php";
?>

	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th align="left"><strong>Actions</strong></th>
		</tr>


		<?php

		$ok = $queue->Get($param);
		while ($ok)
		{
			$organization = new Organization($queue->organizationId);
			?>
		<tr class='mritem' id="<?php echo $queue->queueId;?>">
			<td class="adminData"><?php echo $organization->name." - ".$queue->name;?></td>

			<td>
			<?php
			include $sitePath."/design/actions/queue.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		$ok = $queue->Next();
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
