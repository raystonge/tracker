<?php
include_once "tracker/module.php";
include_once "tracker/permission.php";
PageAccess("Report: List");
?>

<div class="adminArea">
	<h2><a href="/listReports/" class="breadCrumb">Reports</a></h2>
	<table class="main_rlist tableBorder">
		<tr>
			<th align="left"><strong>Name</strong>
			</th>
			<th>
			Type
			</th>
			<th class="right"><strong>Actions</strong></th>
		</tr>
        <?php
        $module = new Module();
        $param = "userId=".$currentUser->userId;
        $ok = $module->Get($param);
        while ($ok)
        {
			?>
		<tr class='mritem' id="<?php echo $module->moduleId;?>">
			<td class="adminData">
			<?php CreateLink("/viewReports/".$module->moduleId."/",$module->name,"",$title="View Report");?>
			</td>
			<td><?php echo $module->moduleType;?></td>
			<td class="right">
			<?php 
			include $sitePath."/design/actions/module.php";
			echo $htmlAction;
			?>
		    </td>
		</tr>
		<?php
		   $ok = $module->Next();
		   }
        ?>
     </table>

</div>
