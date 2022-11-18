<?php
include_once 'globals.php';
include_once 'tracker/asset.php';
include_once 'tracker/assetToAsset.php';
include_once 'tracker/assetType.php';
ProperAccessTest("removeAccessory");
$assetId = GetTextField("assetId",0);
$asset = new Asset($assetId);
$param = "";
//$param = AddEscapedParam("","organizationId",$asset->organizationId);

$ok = $asset->Get($param);
$showButton = $ok;
while ($ok)
{
	$assetType = new assetType($asset->assetTypeId);
	$field = "asset".$asset->assetId;

	if (strlen(GetTextField($field)))
	{
		$param = AddEscapedParam("", "assetId1", $assetId);
  	$param = AddEscapedParam($param,"assetId2", $asset->assetId);

	  $param1 = AddEscapedParam("", "assetId1", $asset->assetId);
	  $param1 = AddEscapedParam($param1,"assetId2", $assetId);

	  $param = "(".$param.") or (".$param1.")";
		$assetPair = new AssetToAsset();
		if ($assetPair->Get($param))
		{
			$assetPair->Delete();
		}
	}
	$ok = $asset->Next();
}
DebugPause("/accessory/".$assetId."/");
?>
