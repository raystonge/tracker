<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/building.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
$ticketId = GetURI(2,0);
$ticket = new Ticket($ticketId);
$organizationId = $ticket->organizationId;
$building = new Building();
$param = "queueId=".$ticket->queueId;
//$building->Get($param);
$searchSerialNumber = GetTextField("assetSerialNumber");
$searchAssetName = GetTextField("searchAssetName");
$searchAssetTag = GetTextField("assetAssetTag");
$searchBuildingId = GetTextField("searchBuildingId",$building->buildingId);
$searchAssetTypeId = GetTextField("searchAssetTypeId",0);
?>
<form name="assetSeaarch" method="post"  autocomplete="<?php echo $autoComplete;?>">
<?php 
if ($permission->hasPermission("Ticket: Add Asset"))
{
	?>
	<table>
	  <tr>
	    <td>Serial Number: <?php CreateTextField("assetSerialNumber",$searchSerialNumber);?></td>
	    <td>Asset Tag: <?php CreateTextField("assetAssetTag",$searchAssetTag);?></td>
	  </tr>
	  <tr>
	    <td>
	    Asset Type:<select name="searchAssetTypeId">
	      <option value="0">All</option>
	      <?php
	      $param = "organizationId=".$organizationId;
	      $assetType = new AssetType();
	      $ok = $assetType->Get($param);
	      while ($ok)
	      {
	      	$selected = "";
	      	if ($assetType->assetTypeId == $searchAssetTypeId)
	      	{
	      		$selected = "selected='selected'";
	      	}
	      	?>
	      	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $assetType->name;?></option>
	      	<?php
	      	$ok = $assetType->Next();
	      }
	      ?>

	    </select>
	    </td>
	    <td>
	    Building:<select name="searchBuildingId">
	      <option value="0">All</option>
	      <?php
	      $param = "organizationId=".$organizationId;
	      $building = new Building();
	      $ok = $building->Get($param);
	      while ($ok)
	      {
	      	$selected = "";
	      	if ($building->buildingId == $searchBuildingId)
	      	{
	      		$selected = "selected='selected'";
	      	}
	      	?>
	      	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $building->name;?></option>
	      	<?php
	      	$ok = $building->Next();
	      }
	      ?>	    </select>
	    </td>
	  </tr>
	  <tr>
	    <td>
	    Name : <?php CreateTextField("searchAssetName",$searchAssetName);?>
	    </td>
	    <td>
	    &nbsp;
	    </td>
	  </tr>
	</table>
	<?php 
}
	CreateHiddenField("ticketId",$ticketId);
	PrintFormKey();
	$class = "";
	if (!$permission->hasPermission("Ticket: Add Asset"))
	{
		$class = "hidden";
	}
	CreateSubmit("search","Submit",$class);
    ?>
	
</form>
<div id="assetResults"></div>
<div class="clear"></div>
<fieldset>
  <legend>
    Associated Assets
  </legend>
</fieldset>
<div id="assetTickets"></div>