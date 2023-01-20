<?php
include_once "tracker/permission.php";
include_once "tracker/organization.php";
include_once "tracker/contract.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/permission.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/set.php";

PageAccess("Report: Leases");

$contractId = GetTextField("contractId",0);
$contract = new Contract($contractId);
$poNumberId = $contract->poNumberId;
$param = AddEscapedParam("","poNumberId",$poNumberId);
if (!$contractId)
{
  $param = "expireDate >='".$today."' and isLease=1";
  $poNumbers = new Set(",");
  $ok = $contract->Get($param);
  while ($ok)
  {
    if ($contract->poNumberId)
    {
      $poNumbers->add($contract->poNumberId);
    }
    $ok = $contract->Next();
  }
  $param = "poNumberId in (".$poNumbers->data.")";
}
$asset = new Asset();
?>
<table class="width100">
  <tr>
    <th>Serial Number
    </th>
    <th>
    Asset Tag
    </th>
    <th>
    Name
    </th>
    <th>
    Asset Type
    </th>
    <th>Make
    </th>
    <th>
    Model
    </th>
    <th>
      <?php
      if (!$contractId)
      {
        ?>
        Contract
        <?php
      }
      else {
        PrintNBSP();
      }
       ?>
    </th>
  </tr>
  <?php
  $asset->setOrderBy("poNumberId");
  $ok = $asset->Search($param);
  $showButton = $ok;
  while ($ok)
  {
  	?>
  <tr class="mritem">
    <td>
      	<?php
      	if (!strlen($asset->serialNumber))
      	{
      		$asset->serialNumber = "Unknown";
      	}
      	if ($permission->hasPermission("Asset: Edit"))
        {
        	$building = new Building($asset->buildingId);
        	$title = "Building: ".$building->name;
        	if (strlen($asset->buildingLocation))
        	{
        		$title = $title." - ".$asset->buildingLocation;
        	}
        	$assetCondition = new AssetCondition($asset->assetConditionId);
        	$title = $title."\nCondition: ".$assetCondition->name;
        	CreateLink("/assetEdit/$asset->assetId/",$asset->serialNumber,"asset".$asset->assetId,$title);
        }
        else
        {
        	if ($permission->hasPermission("Asset: View"))
        	{
        		?>
        		<a href="/viewAsset/<?php echo $asset->assetId;?>/"><?php echo $asset->serialNumber;?></a>
        		<?php
        	}
        	else
        	{
        		echo $asset->serialNumber;
        	}
        }
	    ?>
    </td>
    <td>
    <?php echo $asset->assetTag;?>
    </td>    <td>
    <?php
    if (strlen($asset->employeeName))
    {
    	echo $asset->employeeName;
    }
    else
    {
        echo $asset->name;
    }?>
    </td>
    <td>
    <?php
    $assetType = new AssetType($asset->assetTypeId);
    echo $assetType->name;
    ?>
    </td>
    <td><?php echo $asset->make;?>
    </td>
    <td>
    <?php echo $asset->model;?>
    </td>
    <td>
      <?php
      if (!$contractId)
      {
        $contract = new Contract($asset->contractId);
        ?>
        <a href="/contractEdit/<?php echo $contract->contractId;?>/"><?php echo $contract->name;?></a>
        <?php
      }
      else {
        PrintNBSP();
      }
       ?>

    </td>
  </tr>
  	<?php
  	$ok = $asset->Next();
  }
  ?>
</table>
