<?php

/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
				?>
				<a href="/contractEdit/<?php echo $asset->contractId;?>">View Contract</a>
				<?php
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
