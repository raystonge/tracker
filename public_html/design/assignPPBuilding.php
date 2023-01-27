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
