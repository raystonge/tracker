<?php
/*
 * Created on Oct 14, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/set.php";
include_once "tracker/assetType.php";
include_once "tracker/assetToTicket.php";
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/permission.php";
validateFormKey();
$permission = new Permission();
$assetSerialNumber = GetTextField("assetSerialNumber");
$searchAssetName = GetTextField("searchAssetName");
$assetAssetTag = GetTextField("assetAssetTag");
$searchBuildingId = GetTextField("searchBuildingId",0);
$searchAssetTypeId = GetTextField("searchAssetTypeId",0);
$formLength = strlen($assetAssetTag) + strlen($assetSerialNumber) + strlen($searchAssetName)+ $searchAssetTypeId + $searchBuildingId;
/*
if (!$formLength)
{
	exit();
}*/
$ticketId = GetTextField("ticketId",0);
$ticket = new Ticket($ticketId);
$tickets = new Set(",");
$assetToTicket = new AssetToTicket();

$ok = $assetToTicket->GetByTicket($ticketId);
while ($ok)
{
	$tickets->Add($assetToTicket->assetId);
	$ok = $assetToTicket->Next();
}
?>
<fieldset>
  <legend>Assets Searched</legend>
</fieldset>
<form method="post" name="searchedAssets" action="/process/ticket/addAsset.php">
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
    <th>&nbsp;</th>
  </tr>
  <?php
  $param = "";
	$doSearch = 0;
	if (strlen($searchAssetName)+strlen($assetAssetTag)==0)
	{
		$param = AddEscapedParam($param,"organizationId",$ticket->organizationId);
		DebugText("doSearch organization");
	}
  if (strlen($tickets->data))
  {
  	$param1 = "assetId not in (".$tickets->data.")";
		$param = AddParam($param,$param1);
  }
	if (strlen($assetSerialNumber))
	{
		$param = AddEscapedParamIfNotBlank($param,"serialNumber",$assetSerialNumber);
		$doSearch = 1;
		DebugText("doSearch serial number");
	}
	if (strlen($assetAssetTag))
	{
		$param = AddEscapedFullLikeParam($param,"assetTag",$assetAssetTag);
		$doSearch = 1;
		DebugText("doSearch asset tag");
	}
	if (strlen($searchAssetName))
	{
		$param1 = "";
		$param1 = AddEscapedLikeParamIfNotBlank($param1,"name",$searchAssetName);
	  //param1 = $param1." or ";
		$param2 = "";
		$param2 = AddEscapedLikeParamIfNotBlank($param2,"employeeName",$searchAssetName);
		//$param1 = "(".$param1.")";
		$param1 = "(".AddOrParam($param1,$param2).")";
		$param = AddParam($param,$param1);
		$doSearch = 1;
		DebugText("doSearch asset name");
	}
  if ($searchAssetTypeId)
  {
  	$param = AddParam($param,"assetTypeId=".$searchAssetTypeId);
		$doSearch = 1;
		DebugText("doSearch assetType");
  }
  if ($searchBuildingId)
  {
  	$param = AddParam($param,"buildingId=".$searchBuildingId);
		$doSearch = 1;
		DebugText("doSearch building");
  }
	DebugText("param:".$param);
	DebugText("doSearch:".$doSearch);
  $asset = new Asset();
	$ok = 0;
	if ($doSearch)
	{
		$ok = $asset->Get($param);
	}
  $showButton = $ok;
  while ($ok)
  {
  	?>
  <tr id="<?php echo $asset->assetId;?>" class="mritem">
    <td>
      	<?php
     		echo $asset->serialNumber;
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
      <?php CreateCheckbox("asset".$asset->assetId,$asset->assetId,"",0,"Select to Add to Ticket","toAddAsset");?>
    </td>
  </tr>
  	<?php
  	$ok = $asset->Next();
  }
  ?>

</table>
<?php
if ($showButton)
{
?>
  <table class="width100">
    <tr>
      <td>
        <?php CreateSubmit("addAsset","Add");?>
      </td>
      <td align="right">
        <?php
				CreateHiddenField("ticketId",$ticket->ticketId);
        CreateButton("addSelectAll","Select All");
        CreateButton("addUnselectAll","Unselect All");
        PrintFormKey("ticketAdd");?>
      </td>
    </tr>
  </table>
<?php
}
?>
<form>
<?php  // DebugOutput(); ?>
