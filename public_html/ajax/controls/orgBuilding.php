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
include_once "globals.php";
include_once "tracker/building.php";
include_once "tracker/organization.php";
$organizationId = GetTextField("organization",GetTextField("searchOrganizationId",0));
$param = "";
if ($organizationId)
{
	$param = AddEscapedParam($param,"organizationId",$organizationId);
}
?>

			    <select name="building" id="building">
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
