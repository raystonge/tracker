<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/set.php";

PageAccess("Report: Billing");
$organizationId = GetTextField("organizationId",0);
$organization = new Organization($organizationId);

$assetTypes = new Set(",");
$assetType = new AssetType();
$param = "personalProperty=1";
$param = AddEscapedParam($param,"organizationId",$organizationId);
$ok = $assetType->Get($param);
while ($ok)
{
  $assetTypes->Add($assetType->assetTypeId);
  $ok = $assetType->Next();
}
$startDate = GetTextField("startDate");
$stopDate = GetTextField("stopDate");
$asset = new Asset();
$asset->SetOrderBy("buildingId");
?>
<div class="adminArea">
<h2><a href="/personalProperty/" class="breadCrumb">Personal Property Report</a><?php PrintNBSP(); PrintNBSP(); echo $organization->name;?></h2>
<p><?php echo $organization->name;?></p>
<p><a href="/personalPropertyReportExport/<?php echo $organizationId;?>/" target="_blank">Export</a>
<table width="100%">
  <tr>
    <th>Asset Tag</th><th>Serial Number</th><th>Asset Type</th><th>Make</th><th>Model</th><th>Purchase Price</th><th>Building</th><th>Employee</th><th>Vendor</th><th>Aquired Date</th><th>Status</th>
  </tr>
  <?php
  $param = "assetConditionId != 5 and assetConditionId != 8 and assetTypeId in (".$assetTypes->data.")";
  $param = AddEscapedParam($param,"organizationId",$organizationId);
  $ok = $asset->Get($param);
  while ($ok)
  {
    $assetType = new AssetType($asset->assetTypeId);
    $building = new Building($asset->buildingId);
    $assetCondition = new AssetCondition($asset->assetConditionId);
    ?>
    <tr>
      <td><?php echo $asset->assetTag;?></td><td><?php echo $asset->serialNumber;?></td><td><?php echo $assetType->name;?></td><td><?php echo $asset->make;?></td><td><?php echo $asset->model;?></td><td><?php echo $asset->purchasePrice; ?></td><td><?php echo $building->name;?></td><td><?php echo $asset->employeeName;?></td><td><?php echo $asset->vendor;?></td><td><?php $asset->aquireDate;?></td><td><?php echo $assetCondition->name;?></td>
    </tr>
    <?php
    $ok = $asset->Next();
  }



  ?>

</table>
</div>
