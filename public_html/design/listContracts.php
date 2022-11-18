<?php
include_once "tracker/contract.php";
include_once "tracker/permission.php";
PageAccess("Config: Contract");
$contract = new Contract();
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
	src="/js/listContracts-jquery.js"></script>
	-->
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Contracts</h2>
	<?php
	if ($permission->hasPermission("Contract: Create"))
	{
		?>
	<div class="options">
		<a id="newContract" href="/newContract/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Contract"';}?>>New Contract</a>
	</div>
	<?php
	}
	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
			<tr>
				<td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				</td>
				<td><input id="search" type="hidden" name="Submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
