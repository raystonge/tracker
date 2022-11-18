<?php
PageAccess("Asset: Create");
?>
<div class="adminArea">
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Software</h2>
<?php
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$asset = new Asset();
$assetType = new AssetType();
$asset->assetTypeId = $assetType->Get("name='Software'");

include $sitePath."/design/asset/softwareEditor.php";
?>
</div>