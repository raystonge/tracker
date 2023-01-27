<?php
//
//  Tracker - Version 1.0
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
include_once "globals.php";
include_once "tracker/set.php";
include_once "tracker/assetType.php";
include_once "tracker/assetToTicket.php";
include_once "tracker/asset.php";
include_once "tracker/permission.php";
validateFormKey();
$permission = new Permission();
$assetSerialNumber = GetTextField("assetSerialNumber");
$searchAssetName = GetTextField("searchAssetName");
$assetAssetTag = GetTextField("assetAssetTag");
$searchBuildingId = GetTextField("searchBuildingId",0);
$searchAssetTypeId = GetTextField("searchAssetTypeId",0);
$formLength = strlen($assetAssetTag) + strlen($assetSerialNumber) + strlen($searchAssetName)+ $searchAssetTypeId + $searchBuildingId;
if (!$formLength)
{
	exit();
}
$ticketId = GetTextField("ticketId",0);
$tickets = new Set(",");
$assetToTicket = new AssetToTicket();

$ok = $assetToTicket->GetByTicket($ticketId);
while ($ok)
{
	$tickets->Add($assetToTicket->assetId);
	$ok = $assetToTicket->Next();
}
?>
<fieldset>
  <legend>Assets Searched</legend>
</fieldset>
<form method="post" name="searchedAssets">
<table class="width100">
  <tr>
    <th>Serial Number
    </th>
    <th>
    Asset Tag
    </th>
    <th>
    Name
    </th>
    <th>
    Asset Type
    </th>
    <th>Make
    </th>
    <th>
    Model
    </th>
    <th>&nbsp;</th>
  </tr>
  <?php
  $param = "";
  if (strlen($tickets->data))
  {
  	$param = "assetId not in (".$tickets->data.")";
  }
  $param = AddEscapedParamIfNotBlank($param,"serialNumber",$assetSerialNumber);
  $param = AddEscapedParamIfNotBlank($param,"assetTag",$assetAssetTag);
  $param = AddEscapedLikeParamIfNotBlank($param,"name",$searchAssetName);
  if ($searchAssetTypeId)
  {
  	$param = AddParam($param,"assetTypeId=".$searchAssetTypeId);
  }
  else
  {
  	$assetTypes = new Set(",");
  	$assetType = new AssetType();
  	$ok = $assetType->Get("canHaveSoftware=1");
  	while($ok)
  	{
  		$assetTypes->Add($assetType->assetTypeId);
  		$ok= $assetType->Next();
  	}
  	$param = AddParam($param,"assetTypeId in ($assetTypes->data)");
  }
  if ($searchBuildingId)
  {
  	$param = AddParam($param,"buildingId=".$searchBuildingId);
  }
  $asset = new Asset();
  $ok = $asset->Get($param);
  $showButton = $ok;
  while ($ok)
  {
  	?>
  <tr id="<?php echo $asset->assetId;?>" class="mritem">
    <td>
      	<?php
     		echo $asset->serialNumber;
	    ?>
    </td>
    <td>
    <?php echo $asset->assetTag;?>
    </td>    <td>
    <?php
		if (strlen($asset->employeeName))
		{
			echo $asset->employeeName;
		}
		else
		{
			echo $asset->name;
		}?>
    </td>

    <td>
    <?php
    $assetType = new AssetType($asset->assetTypeId);
    echo $assetType->name;
    ?>
    </td>
    <td><?php echo $asset->make;?>
    </td>
    <td>
    <?php echo $asset->model;?>
    </td>
    <td>
      <?php CreateCheckbox("asset".$asset->assetId,$asset->assetId,"",0,"Select to Add to Ticket","toAddAsset");?>
    </td>
  </tr>
  	<?php
  	$ok = $asset->Next();
  }
  ?>

</table>
<?php
if ($showButton)
{
?>
  <table class="width100">
    <tr>
      <td>
        <?php CreateButton("addAsset","Add");?>
      </td>
      <td align="right">
        <?php
        CreateButton("addSelectAll","Select All");
        CreateButton("addUnselectAll","Unselect All");
        PrintFormKey("ticketAdd");?>
      </td>
    </tr>
  </table>
<?php
}
?>
<form>
<?php // DebugOutput(); ?>
