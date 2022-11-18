<?php
PageAccess("Monitor");
include_once "tracker/monitor.php";
include_once "tracker/asset.php";
include_once "tracker/building.php";
include_once "tracker/assetType.php";
include_once "tracker/organization.php";

$buildingId = GetTextField("buildingId",GetTextFromSession("monitorBuildingId",0,0));
$assetTypeId = GetTextField("assetTypeId",GetTextFromSession("monitorAssetTypeId",0,0));
$state = GetTextField("state",GetTextFromSession("monitorState",0,0));

$formKey = getAJAXFormKey();
?>
<div class="adminArea">
	<h2><a href="/monitor/" class="breadCrumb">Monitor</a></h2>

<form method="post">
 <table>
   <tr>
     <td>
     State:<select name="state">
      <option value="-1" <?php if ($state == -1){echo " selected='selected'";}?>>All</option>
      <option value="1" <?php if ($state == 1){echo " selected='selected'";}?>>Up</option>
      <option value="0" <?php if ($state == 0){echo " selected='selected'";}?>>Down</option>
      </select>
     </td>
     <td>
     Building: <select name="buildingId">
     <option value="0">All</option>
     <?php
     $building = new Building();
     $param = "organizationId in (".GetMyOrganizations().")";

     $ok = $building->Get($param);
     while ($ok)
     {
     	$selected = "";
			$organization = new Organization($building->organizationId);
     	if ($buildingId == $building->buildingId)
     	{
     		$selected = "selected = 'selected'";
     	}
     	?>
     	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $organization->name." - ".$building->name;?></option>
     	<?php
     	$ok = $building->Next();
     }
     ?>
     </select>
     </td>
     <td>
     Asset Type: <select name="assetTypeId">
     <option value="0">All</option>
     <?php
     $assetType = new AssetType();
     $param = "organizationId in (".GetMyOrganizations().")";
     $param = AddParam($param,"monitor=1");
     $ok = $assetType->Get($param);
     while ($ok)
     {
     	$selected = "";
			$organization = new Organization($assetType->organizationId);
     	if ($assetTypeId == $assetType->assetTypeId)
     	{
     		$selected = "selected = 'selected'";
     	}
     	?>
     	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $organization->name." - ".$assetType->name;?></option>
     	<?php
     	$ok = $assetType->Next();
     }
     ?>
     </select>
     </td>
   </tr>
 </table>
 <input type="submit" value="Submit" id="search">
 <input type="hidden" value="<?php echo $formKey;?>" name="ajaxFormKey"/>
</form>

</div>
<div id="results"></div>
