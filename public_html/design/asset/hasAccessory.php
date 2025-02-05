<?php
//
//  Tracker - Version 1.13.0
//
// v1.13.0
//  - added support for limit sharing across orgs
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
include_once "tracker/shareWithOrganization.php";

global $shareAssetAcrossOrgs;

$query = "select * from asset a inner join assetType at on a.assetTypeId=at.assetTypeId ";
$asset = new Asset($assetId);
$orgAssetId = $assetId;
$organizationId = $asset->organizationId;
$assetToAsset = new AssetToAsset();


?>
<form name="assets" method="post" action="/process/asset/removeAccessory.php">
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
  DebugText("Start looking up accessories");
  $param = "";
  if (!$shareAssetAcrossOrgs)
  {
  	$param = AddEscapedParam("","organizationId",$asset->organizationId);
  }
  //$ok = $asset->Get($param);
  $param = AddParam("","assetId1=". $orgAssetId);
  DebugText("param:".$param);
  $param = AddOrParam($param, "assetId2=".$orgAssetId);
  DebugText("param:".$param);
  $ok = $assetToAsset->Get($param);
  $showButton = $ok;
  $cnt = 0;
  while ($ok && $cnt++ < 10)
  {
     $loadId = $assetToAsset->assetId1;
     if ($loadId == $orgAssetId)
     {
         $loadId = $assetToAsset->assetId2;
     }
     $asset = new Asset($loadId);
    $assetType = new assetType($asset->assetTypeId);
  //  if ($assetType->isAccessory && $assetToAsset->AssetAssigned($assetId))
  //  {
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
    <?php
    if ($permission->hasPermission("Asset: Accessory Edit"))
    {
    	?>
      <input type="checkbox" name="asset<?php echo $asset->assetId;?>" class="asset"/>
      <?php
    }
    ?>
    </td>
  </tr>
  	<?php
  //}
  	$ok = $assetToAsset->Next();
  }
  ?>
</table>
<?php
CreateHiddenField("assetId",$assetId);
$asset = new Asset($assetId);
PrintFormKey("removeAccessory");
if ($showButton && $asset->assetConditionId != 8)
{
?>
  <table class="width100">
    <tr>
      <td>
        <input type="submit" value="Remove" name="remove" id="removeAsset"/>
      </td>
      <td align="right">

        <input type="button" value="Select All" name="addSelectAll" id="addSelectAll" />
        <input type="button" value="Unselect All" name="addUnselectAll" id="addUnselectAll" />
      </td>
    </tr>
  </table>
<?php
}
?>
</form>
<?php
if (!$asset->isEwasted())
{
  ?>

<form name="assets" method="post" action="/process/asset/addAccessory.php">
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
  DebugText("get unassigned assets");
  $ok = $assetToAsset->AssetAssigned($orgAssetId);
  $param = "";
  DebugText("shareAssetAcrossOrgs:".$shareAssetAcrossOrgs);
  if (!$shareAssetAcrossOrgs)
  {
  	$param = AddEscapedParam("","organizationId",$asset->organizationId);
  }
  else
  {
    $shareWith = new ShareWithOrganization();
    $param1 = AddEscapedParam("","shareWithId",$asset->organizationId);
    //$param1 = AddEscapedParam("","organizationId",$asset->organizationId);
    $ok = $shareWith->Get($param1);
    $orgs = new Set(",");
    $orgs->Add($asset->organizationId);
    while ($ok)
    {
      $orgs->Add($shareWith->organizationId);
      $ok = $shareWith->Next();
    }
    $param = "organizationId in (".$orgs->data.")";
  }

  $asset->SetOrderBy("assetTag");
  $ok = $asset->Get($param);
  $showButton = $ok;
  while ($ok)
  {
    $assetType = new assetType($asset->assetTypeId);
    DebugText("isAccessory:".$assetType->isAccessory);

    if ($assetType->isAccessory && !$assetToAsset->AssetAssigned($asset->assetId) && !$asset->isEwasted())
    {
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
    <?php
    if ($permission->hasPermission("Asset: Accessory Edit"))
    {
    	?>
      <input type="checkbox" name="asset<?php echo $asset->assetId;?>" class="assetAdd"/>
      <?php
    }
    ?>
    </td>
  </tr>
  	<?php
  }
  	$ok = $asset->Next();
  }
  ?>
</table>
<?php
CreateHiddenField("assetId",$orgAssetId);
PrintFormKey("addAccessory");
if ($showButton)
{
?>
  <table class="width100">
    <tr>
      <td>
        <input type="submit" value="Add" name="add" id="addAsset"/>
      </td>
      <td align="right">
        <?php PrintNBSP();?>
        <!--
        <input type="button" value="Select All" name="addSelectAll" id="addSelectAll" />
        <input type="button" value="Unselect All" name="addUnselectAll" id="addUnselectAll" />
      -->
      </td>
    </tr>
  </table>
<?php
}
}
?>
</form>
