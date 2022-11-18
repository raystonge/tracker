<?php
/*
 * Created on Aug 3, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/assetToTicket.php";
include_once "tracker/permission.php";
include_once "tracker/assetType.php";
ProperAccessTest();
$permission = new Permission();
$assetToTicket = new AssetToTicket();
$ticketId = GetTextField("ticketId");
$param = AddEscapedParam("","ticketId",$ticketId);
?>
<form method="post" name="attachedsearchedAssets">

<table width="100%">
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
    <th>&nbsp;</th>
  </tr>
  <?php
  $ok = $assetToTicket->Get($param);
  $showButton = $ok;
  while ($ok)
  {
  	$asset = new Asset($assetToTicket->assetId);
  	?>
  <tr id="<?php echo $asset->assetId;?>"  class="mritem">
    <td>
      	<?php
      	if ($permission->hasPermission("Asset: Edit"))
        {
        	CreateLink("/assetEdit/$asset->assetId",$asset->serialNumber);
        }
        else
        {
        	if ($permission->hasPermission("Asset: View"))
        	{
        		CreateLink("/assetView/$asset->assetId/",$asset->serialNumber);
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
    </td>
    <td>
    <?php
    if (strlen($asset->employeeName))
    {
      echo $asset->employeeName;
    }
    else
    {
      echo $asset->name;
    }
    ?>
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
      CreateCheckBox("attachedAsset".$asset->assetId,$asset->assetId,"",0,"Click to remove asset","toRemoveAsset");
      ?>
    </td>
  </tr>
  	<?php
  	$ok = $assetToTicket->Next();
  }
  ?>

</table>
<?php
if ($showButton)
{
?>
  <table width="100%">
    <tr>
      <td>
      <?php CreateButton("removeAsset","Remove");?>
      </td>
      <td align="right">
      <?php
      CreateButton("removeSelectAll","Select ALL");
      CreateButton("removeUnselectAll","Unselect ALL");
      PrintFormKey("ticketAssetsAdded");?>
      </td>
    </tr>
  </table>
<?php
}
?>

</form>
<?php // DebugOutput();?>
