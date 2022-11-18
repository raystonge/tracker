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
      <select name="contractId" id="contractId" >
        <option value="0">Select Contract</option>
        <?php

$contract = new Contract();
$ok = $contract->Get("");
while ($ok)
{
  $selected = "";
	if ($assetToContract->contractId == $contract->contractId)
	{
		$selected = "selected='selected'";
	}
?>
        	<option value="<?php echo $contract->contractId;?>" <?php echo $selected;?>><?php echo $contract->name." - ".$contract->expireDate;?></option>
        	<?php

	$ok = $contract->Next();
}
?>
      </select>
    </td>
    <td>
			<?php
			if ($assetToContract->assetToContractId)
			{
				?>
				<a href="/contractEdit/<?php echo $assetToContract->contractId;?>">View Contract</a>
				<?php
			}
			 ?>
    </td>
  </tr>
  <tr>
   <td>
     Leased : <?php CreateCheckBox("leased",1, "",$asset->leased,"Click if asset is leased","toLease"); ?>
   </td>
   <td>
     &nbsp;
   </td>
  </tr>
  <tr>
    <td>
    &nbsp;
    </td>
    <td>
    <?php
    PrintFormKey();
    PrintAJAXFormKey();
    CreateHiddenField("assetId",$asset->assetId);
    //CreateHiddenField("contractId",$contract->contractId);
    CreateSubmit("submit",$button);
    ?>
    </td>
  </tr>
</table>
</form>
