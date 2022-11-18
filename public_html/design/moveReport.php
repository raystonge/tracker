<?php
include_once "tracker/organization.php";
include_once "tracker/asset.php";
include_once "tracker/building.php";
include_once "tracker/set.php";

$orgList = new Set(",");
$organization = new Organization();
$ok = $organization->Get("active=1");
while ($ok)
{
  $orgList->Add($organization->organizationId);
  $ok = $organization->Next();
}
$asset = new Asset();
$param = "organizationId in (".$orgList->data.")";
$param1 = "assetConditionId not in (5,8)";
$param = $param." and ".$param1." and buildingId <> startingBuildingIdPP";
$asset->SetOrderBy("buildingId");

?>
<table>
<?php
$ok = $asset->Get($param);
while ($ok)
{
  $building = new Building($asset->buildingId);
  $orgBuilding = new Building($asset->startingBuildingIdPP);
  ?>
  <tr>
    <td>
      <?php echo $asset->assetTag;?>
    </td>
    <td>
      <?php echo $asset->employeeName;?>
    </td>
    <td>
    <td>
      <?php echo $orgBuilding->name;?>

    </td>
    <td>
      ==>
    </td>
    <td>
      <?php echo $building->name;?>
    </td>
  </tr>
  <?php

  $ok = $asset->Next();
}
 ?>
</table>
