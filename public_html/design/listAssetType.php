<?php
include_once "tracker/assetType.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("Config: AssetType List");
$assetType = new AssetType();
$organization = new Organization();
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
	src="/js/listAssetTypes-jquery.js"></script>
	-->
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Asset Type</h2>
	<div class="options">
		<a id="newAssetType" href="/newAssetType/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Asset Type"';}?>>New Asset Type</a>
	</div>
	<?php
	$sectionName = GetTextField("sectionName",GetTextFromSession("assetTypeSectionName"));
	$organizationId = GetTextField("organization",GetTextFromSession("assetTypeOrganizationId",0));

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
				<?php echo $orgOrDept;?>:
				</td>
				<td>
				<select name="organization">
				  <option value="0">All <?php echo $orgOrDept;?>s</option>
				<?php
                $myOrganizations = GetMyOrganizations();
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
