<?php
//
//  Tracker - Version 1.5.0
//
// v1.5.0
//  - added test for active buildings
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
<?php
include_once "tracker/building.php";
include_once "tracker/assetType.php";
include_once "tracker/asset.php";
$assetId = GetURI(2,0);
$asset = new Asset($assetId);
$searchSerialNumber = GetTextField("assetSerialNumber");
$searchAssetName = GetTextField("searchAssetName");
$searchAssetTag = GetTextField("assetAssetTag");
$searchBuildingId = GetTextField("searchBuildingId",$asset->buildingId);
$searchAssetTypeId = GetTextField("searchAssetTypeId",0);
?>
<form name="assetSeaarch" method="post"  autocomplete="<?php echo $autoComplete;?>">
	<table>
	  <tr>
	    <td>Serial Number: <?php CreateTextField("assetSerialNumber",$searchSerialNumber);?></td>
	    <td>Asset Tag: <?php CreateTextField("assetAssetTag",$searchAssetTag);?></td>
	  </tr>
	  <tr>
	    <td>
	    Asset Type:<select name="searchAssetTypeId">
	      <option value="0">All</option>
	      <?php
	      $assetType = new AssetType();
	      $ok = $assetType->Get("canHaveSoftware=1");
	      while ($ok)
	      {
	      	$selected = "";
	      	if ($assetType->assetTypeId == $searchAssetTypeId)
	      	{
	      		$selected = "selected='selected'";
	      	}
	      	?>
	      	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $assetType->name;?></option>
	      	<?php
	      	$ok = $assetType->Next();
	      }
	      ?>

	    </select>
	    </td>
	    <td>
	    Building:
	    <select name="searchBuildingId" id="searchBuildingId">
	      <option value="0">All</option>
	      <?php
	      $building = new Building();
	      $ok = $building->Get("active=1");
	      while ($ok)
	      {
	      	$selected = "";
	      	if ($building->buildingId == $searchBuildingId)
	      	{
	      		$selected = "selected='selected'";
	      	}
	      	?>
	      	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $building->name;?></option>
	      	<?php
	      	$ok = $building->Next();
	      }
	      ?>
	    </select>
	    </td>
	  </tr>
	  <tr>
	    <td>
	    Name : <?php CreateTextField("searchAssetName",$searchAssetName);?>
	    </td>
	    <td>
	    &nbsp;
	    </td>
	  </tr>
	</table>
	<?php
	CreateHiddenField("assetId",$assetId);
	PrintFormKey();
	CreateSubmit("search","Submit");
    ?>

</form>
<fieldset>
  <legend>
    Associated Assets
  </legend>
</fieldset>
<div id="assetTickets"></div>
<div class="clear"></div>
<div id="assetResults"></div>
<div class="clear"></div>
