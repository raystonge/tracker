<?php
include_once 'globals.php';
include_once 'tracker/asset.php';
include_once 'tracker/assetType.php';

$_SESSION['formErrors'] ="";
//ProperAccessValidate();
if (isset($_POST['submitTest']))
{
	$numErrors = 0;
	$errorMsg = "";
	$assetId = GetTextField("assetId",0);
	$asset = new Asset($assetId);
	$assetType = new AssetType($asset->assetTypeId);
	$asset->purchasePrice = GetTextField("purchasePrice","0.00");
	$asset->poNumberId = GetTextField("poNumberId",0);
	$asset->vendor = GetTextField("vendor");
	$asset->taxable = GetTextField("taxable",0);
	$asset->sold = GetTextField("sold",0);
	if ($asset->sold)
	{
		$asset->soldPrice = GetTextField("soldPrice","0.00");
		$asset->soldDate = GetTextField("soldDate","0000-00-00");
		$asset->soldTo = GetTextField("soldTo");
	}
	else
	{
		$asset->soldPrice = "0.00";
		$asset->soldDate = "0000-00-00";
		$asset->soldTo = "";
	}
	if (!strlen($asset->vendor))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Vendor must be specified</li>";
	}
	if ($assetType->enforceCost && ($asset->purchasePrice == "0.00") || ($asset->purchasePrice == 0))
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Cost needs to be specified</li>";
	}
	if (!$numErrors)
	{
		$asset->Persist();
		$_SESSION['formSuccess'] = "Success";
	}
	else {
		$html = "<ul>".$errorMsg."</ul>";

		$_SESSION['formErrors'] = $html;
		$_SESSION['purchasePrice'] = $asset->purchasePrice;
		$_SESSION['poNumberId'] = $asset->poNumberId;
		$_SESSION['vendor'] = $asset->vendor;
		$_SESSION['taxable'] = $asset->taxable;
		$_SESSION['sold'] = $asset->sold;
		$_SESSION['soldPrice'] = $asset->soldPrice;
		$_SESSION['soldDate'] = $asset->soldDate;
		$_SESSION['soldTo'] = $asset->soldTo;

	}

	DebugPause("/assetValue/".$asset->assetId."/");
}
DebugPause("/listAssets/");
?>
