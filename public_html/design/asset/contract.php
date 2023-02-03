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
include_once "tracker/contract.php";
include_once "tracker/assetToContract.php";
include_once "tracker/building.php";

$button = "Update";
$param = "assetId = " . $asset->assetId;
$building = new Building($asset->buildingId);
$assetToContract = new AssetToContract();
if ($assetToContract->Get($param)) {
	$button = "Update";
}
if (FormErrors())
{
	DisplayFormErrors();
  $assetToContract->contractId = GetTextFromSession("contractId",0);
  $asset->leased = GetTextFromSession("leased");
}
if (FormSuccess())
{
	DisplayFormSuccess();
}
?>

<table>
<!--
  <tr>
    <td>
    Name:<?php echo $asset->name;?>
    </td>
    <td>
    Serial Number:<?php echo $asset->serialNumber;?>
    </td>
  </tr>
-->
  <tr>
    <td>
    Building: <?php echo $building->name;?>
    </td>
    <td>Location: <?php echo $asset->buildingLocation;?>
    </td>
    <td><div id="assetState"></div>
    </td>
  </tr>
<?php



?>
</table>
<form method="post" action="/process/asset/contract.php">
<table>
  <tr>
    <td>Contract:
			<?php
      $contract = new Contract($asset->contractId);
			echo $contract->name;
			 ?>

    </td>
    <td>
			<?php
			if ($asset->contractId)
			{
				if ($permission->hasPermission("Contract: Edit"))
				{
				?>
				<a href="/contractEdit/<?php echo $asset->contractId;?>">View Contract</a>
				<?php
			  }
				if ($permission->hasPermission("Contract: View"))
				{
				?>
				<a href="/contractView/<?php echo $asset->contractId;?>">View Contract</a>
				<?php
			  }

			}
			 ?>
    </td>
  </tr>
  <tr>
   <td>
		 <?php
     $isLeased = "Not Leased";
		 if ($contract->isLease)
		 {
			 $isLeased = "Leased";
		 }
		  ?>
     Leased : <?php echo $isLeased; ?>
   </td>
   <td>
     &nbsp;
   </td>
  </tr>
</table>
</form>
