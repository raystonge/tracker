<?php
include_once "globals.php";
include_once "tracker/asset.php";

$asset = new Asset();
$param = AddEscapedParam("","assetConditionId",5);
$ok = $asset->Get($param);
while ($ok)
{
  $fieldName = "asset".$asset->assetId;
  $checked = GetTextField($fieldName,0);
  if ($checked)
  {
    $asset->Dispose();
  }

  $ok = $asset->Next();
}
DebugPause("/assetDoeWaste/");
 ?>
