<?php
include_once "tracker/insuranceRepairComplete.php";
include_once "tracker/permission.php";
PageAccess("Config: Insurance Repair Complete");
$insuranceRepairComplete = new InsuranceRepairComplete();
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
<!--
<script
	language="javascript"
	src="/js/listInsuranceRepairCompletes-jquery.js"></script>
	-->
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Insurance Repair Complete</h2>
	<div class="options">
		<a id="newInsuranceRepairComplete" href="/newInsuranceRepairComplete/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Insurance Repair Complete"';}?>>New Insurance Repair Complete</a>
	</div>
	<?php
	$sectionName = "";

	if (isset($_POST['sectionName']))
	{
		$sectionName=trim(strip_tags($_POST['sectionName']));
	}

	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
		<table>
			<tr>
				<td valign="top">Section:
				</td>
				<td><input name="sectionName" type="text" <?php if ($showMouseOvers){echo 'title="Search by Section Name"';};?>
					value="<?php echo $sectionName;?>" /><br />
				</td>
			</tr>
			<tr>
				<td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				</td>
				<td><input id="search" type="submit" name="Submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
