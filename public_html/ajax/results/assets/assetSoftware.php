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
include_once "tracker/asset.php";
include_once "tracker/assetToAsset.php";
include_once "tracker/permission.php";
include_once "tracker/assetType.php";
ProperAccessValidate();
$permission = new Permission();
$assetToAsset = new AssetToAsset();
$assetId = GetTextField("assetId");
$param = AddEscapedParam("","assetId1",$assetId);
$asset = new Asset($assetId);
$serialNumber = $asset->serialNumber;
?>
<form method="post" name="attachedsearchedAssets">

<table class="width100">
  <tr>
    <th>Serial Number
    </th>
    <th>
    Software SN
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
  $ok = $assetToAsset->Get($param);
  $showButton = $ok;
  while ($ok)
  {
  	$asset = new Asset($assetToAsset->assetId2);
  	?>
  <tr id="<?php echo $asset->assetId;?>"  class="mritem">
    <td>
      	<?php
      	if ($permission->hasPermission("Asset: Edit"))
        {
        	CreateLink("/assetEdit/$asset->assetId",$asset->serialNumber);
        }
        else
        {
        	if ($permission->hasPermission("Asset: View"))
        	{
        		CreateLink("/assetView/$asset->assetId/",$asset->serialNumber);
        	}
        	else
        	{
        		echo $asset->serialNumber;
        	}
        }
	    ?>
    </td>
    <td>
    <?php echo $assetToAsset->serialNumber;?>
    <?php if (!strlen($serialNumber))
    {
    	$href = "/assetAssignSerialNumber/$assetToAsset->assetToAssetId/";
    	$id = "assetAssignSerialNumber".$asset->assetId;;
    	$title = "Edit Serial Number";
    	CreateLink($href,"Set SN",$id,$title);
    }
    ?>
    </td>    <td>
    <?php echo $asset->name;?>
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
      CreateCheckBox("attachedAsset".$asset->assetId,$asset->assetId,"",0,"Click to remove asset","toRemoveAsset");
      ?>
    </td>
  </tr>
  	<?php
  	$ok = $assetToAsset->Next();
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
      <?php CreateButton("removeAsset","Remove");?>
      </td>
      <td align="right">
      <?php
      CreateButton("removeSelectAll","Select ALL");
      CreateButton("removeUnselectAll","Unselect ALL");
      PrintFormKey("assetAssetsAdded");?>
      </td>
    </tr>
  </table>
<?php
}
?>

</form>
<?php  //DebugOutput();?>
