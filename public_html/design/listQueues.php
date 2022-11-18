<?php
include_once "tracker/queue.php";
include_once "tracker/organization.php";
include_once "tracker/permission.php";
PageAccess("Config: Queue");
$queue = new Queue();
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
	src="/js/listQueues-jquery.js"></script>
	-->
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Queues</h2>
	<div class="options">
		<a id="newQueue" href="/newQueue/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Queue"';}?>>New Queue</a>
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
				<td valign="top">
				<?php echo $orgOrDept;?> :
				</td>
				<td>
				<select name="organization">
				  <option value="0">All <?php echo $orgOrDept;?>s</option>
				<?php
				$organizationId=GetTextField("organization",0);
				$myOrganizations = GetMyOrganizations();
				$organization = new Organization();
				$param = "organizationId in ($myOrganizations)";
				$ok = $organization->Get($param);
				while ($ok)
				{
					$selected = "";
					if ($organizationId == $organization->organizationId)
					{
						$selected = "selected='selected'";
					}
					?>
					<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
					<?php
					$ok = $organization->Next();
				}
				?>
				</select>
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
