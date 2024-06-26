<?php
//
//  Tracker - Version 1.7.0
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
include "tracker/asset.php";
include "tracker/building.php";
include "tracker/assetCondition.php";
include "tracker/assetType.php";

$asset = new Asset();
$param = "";
$param = AddEscapedParam($param,"assetConditionId",5);
 ?>
<form name="assets" method="post" action="/process/asset/ewaste.php">
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

  $ok = $asset->Get($param);
  $showButton = $ok;
  while ($ok)
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
    <?php
    if ($permission->hasPermission("Asset: Jumbo"))
    {
    	?>
      <input type="checkbox" name="asset<?php echo $asset->assetId;?>" class="asset"/>
      <?php
    }
    ?>
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
        <input type="submit" value="eWaste" name="ewaste" id="ewaste"/>
        <?php PrintFormKey(); ?>
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
