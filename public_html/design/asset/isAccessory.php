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
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/assetToAsset.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/set.php";
$asset = new Asset($assetId);
$orgAssetId = $assetId;
$organizationId = $asset->organizationId;
$assetToAsset = new AssetToAsset();
$assets = new Set();

$param = AddParam("","assetId1=". $orgAssetId);
DebugText("param:".$param);
$param = AddOrParam($param, "assetId2=".$orgAssetId);
DebugText("param:".$param);
DebugText("Look at what it is attached to");
$ok = $assetToAsset->Get($param);
while ($ok)
{
	$assets->Add($assetToAsset->assetId1);
	$ok = $assetToAsset->Next();
}
?>
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
    <th>
    &nbsp;
    </th>
  </tr>
  <?php
  //$ok = $assetToAsset->AssetAssigned($assetId);
  $param = AddEscapedParam("","organizationId",$asset->organizationId);
  $param = "assetId in (".$assets->data.")";
	DebugText("param:".$param);
	$ok = 0;
	if (strlen($assets->data))
	{
		$ok = $asset->Get($param);
	}
  $showButton = $ok;

  while ($ok)
  {
    $assetType = new assetType($asset->assetTypeId);
  	?>
  <tr class="mritem">
    <td>
      	<?php
      	if (!strlen($asset->serialNumber))
      	{
      		$asset->serialNumber = "Unknown";
      	}
      	if ($permission->hasPermission("Asset: Edit"))
        {
        	$building = new Building($asset->buildingId);
        	$title = "Building: ".$building->name;
        	if (strlen($asset->buildingLocation))
        	{
        		$title = $title." - ".$asset->buildingLocation;
        	}
        	$assetCondition = new AssetCondition($asset->assetConditionId);
        	$title = $title."\nCondition: ".$assetCondition->name;
        	CreateLink("/assetEdit/$asset->assetId/",$asset->serialNumber,"asset".$asset->assetId,$title);
        }
        else
        {
        	if ($permission->hasPermission("Asset: View"))
        	{
        		?>
        		<a href="/viewAsset/<?php echo $asset->assetId;?>/"><?php echo $asset->serialNumber;?></a>
        		<?php
        	}
        	else
        	{
        		echo $asset->serialNumber;
        	}
        }
	    ?>
    </td>
    <td>
    <?php echo $asset->assetTag;?>
    </td>    <td>
    <?php echo $asset->employeeName;?>
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
    </td>
  </tr>
  	<?php
  	$ok = $asset->Next();
  }
  ?>
</table>
