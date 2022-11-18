<?php
PageAccess("Asset: Create");
?>
<div class="adminArea">
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Asset</h2>
<?php
include_once "tracker/asset.php";
$asset = new Asset();
$asset->assetConditionId = 3;
$asset->organizationId = GetTextField("organization",0);
include $sitePath."/design/asset/editor.php";
?>
</div>
