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
include_once "tracker/assetType.php";
include_once "tracker/spec.php";
include_once "tracker/specToAssetType.php";
$assetTypeId = 0;
if (isset($request_uri[2]))
{
	$assetTypeId = $request_uri[2];
}
$assetType = new AssetType($assetTypeId);
?>
<div class="adminArea">
<h2><a href="/listAssetType/" class="breadCrumb">Assets Types</a> </h2>
  <?php echo "<strong>Specs for ".$assetType->name;?></strong><br><br><br>
  <form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/specToAssetType.php">
    <?php
    $spec = new Spec();
    $ok = $spec->Get("");
    while ($ok)
    {
      $specToAssetType = new SpecToAssetType();
      $name = "spec".$spec->specId;
      $checked = 0;
      $param = AddEscapedParam("","specId",$spec->specId);
      $param = AddEscapedParam($param,"assetTypeId",$assetTypeId);
      if ($specToAssetType->Get($param))
      {
        $checked = 1;
      }
      CreateHiddenField("assetTypeId",$assetTypeId);
      CreateCheckBox($name,$spec->specId,$spec->name,$checked);
      PrintBR();
      $ok = $spec->Next();
    }

    PrintFormKey();
    CreateSubmit("Update");

     ?>

  </form>
</div>
