<?php
//
//  Tracker - Version 1.0
//
//  v1.5.0
//   - fixing issue with search//
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
include_once "globals.php";
include_once "tracker/building.php";
include_once "tracker/organization.php";
$organizationId = GetTextField("organizationId",GetTextFromSession("searchAssetOrganizationId",0,0));
$searchBuildingId = GetTextField("searchBuildingId",GetTextFromSession("searchBuildingId",0,0));
$param = "active = 1";
if ($organizationId)
{
	$param = AddEscapedParam($param,"organizationId",$organizationId);
}
?>

			    <select name="searchBuildingId">
			      <option value="0">All</option>
			      <?php
			      $building = new Building();
			      $ok = $building->Get($param);
			      while ($ok)
			      {

			      	$selected = "";
			      	if ($building->buildingId == $searchBuildingId)
			      	{
			      		$selected = "selected=='selected'";
			      	}
							$name = $building->name;
							if (!$organizationId)
							{
								$organization = new Organization($building->organizationId);
								$name = $building->name." - ".$organization->name;
							}
			      	?>
			      	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $name;?></option>
			      	<?php
			      	$ok = $building->Next();
			      }
			      ?>
			    </select>
