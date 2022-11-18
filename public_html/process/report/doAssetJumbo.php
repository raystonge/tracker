<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/module.php";
$moduleId = GetTextField("moduleId",0);
$module = new Module($moduleId);
$param = "";
$asset = new Asset();
$assets = new Set(",");
$param = $module->GetParam();
$ok = $asset->Get($param);
while ($ok)
{
	$field = "asset".$asset->assetId;
	if (isset($_POST[$field]))
	{
		$assets->Add($asset->assetId);
	}
	$ok = $asset->Next();
}
$_SESSION['assetJumbo'] = $assets->data;
$_SESSION['reportId']= $moduleId;
DebugPause("/assetJumbo/");
?>