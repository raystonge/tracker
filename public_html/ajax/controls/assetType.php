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
include_once "tracker/assetType.php";
include_once "tracker/organization.php";
$organizationId = GetTextField("organization",GetTextFromSession("searchAssetOrganizationId",0,0));
$searchAssetTypeId = GetTextFromSession("searchAssetType",0,0);
$param = "";
if ($organizationId)
{
	$param = AddEscapedParam($param,"organizationId",$organizationId);
}
?>

			    <select name="searchAssetTypeId">
			      <option value="0">All</option>
			      <?php
			      $assetType = new AssetType();
			      $assetType->SetOrderBy("organizationId");
			      $ok = $assetType->Get($param);
			      while ($ok)
			      {
			      	$selected = "";
			      	DebugText("assetTypeId:".$assetType->assetTypeId);
			      	DebugText("organizationId:".$assetType->organizationId);
			      	if ($assetType->assetTypeId == $searchAssetTypeId)
			      	{
			      		$selected = "selected=='selected'";
			      	}
							$name = $assetType->name;
							if (!$organizationId)
							{
								$organization = new Organization($assetType->organizationId);
								$name = $organization->name." - ".$assetType->name;
							}
			      	?>
			      	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $name;?></option>
			      	<?php
			      	$ok = $assetType->Next();
			      }
			      ?>
			    </select>
<?php // DebugOutput();?>
