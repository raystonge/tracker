<?php
/*
 * Created on Oct 14, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/set.php";
include_once "tracker/assetType.php";
include_once "tracker/assetToAsset.php";
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
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$numOfLicenses = $asset->numOfLicenses;
$assets = new Set(",");
$assetToAsset = new AssetToAsset();
$licensesInUse = $assetToAsset->LicensesInUse($assetId);
$param = AddEscapedParam("","assetId1",$assetId);
$ok = $assetToAsset->Get($param);
while ($ok)
{
	$assets->Add($assetToAsset->assetId2);
	$ok = $assetToAsset->Next();
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
  if (strlen($assets->data))
  {
  	$param = "assetId not in (".$assets->data.")";
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
  if ($licensesInUse >= $numOfLicenses)
  {
  	$showButton = 0;
  }
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
        PrintFormKey("assetAdd");?>
      </td>
    </tr>
  </table>  
<?php
}
?>  
<form>
<?php  //DebugOutput(); ?>