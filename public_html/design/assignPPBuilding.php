<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/set.php";

PageAccess("Report: Assign Personal Propety Building");
?>

<div class="adminArea">
<h2><a href="/assingPPBuilding/" class="breadCrumb">Personal Property Report</a>Assign Personal Property Buildign</h2>
</div>

<form method="post" action="/process/asset/assignPPBuilding.php">
  <p>This process CANNOT be undone. Once the update is completed, the current building will be saved so any building changes will be recorded for Personal Property Reports</p>
  <?php CreateSubmit("submit","Update"); ?>
</form>
