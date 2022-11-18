<?php
/*
 * Created on Aug 24, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include "globals.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/permission.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/set.php";
$param = "";
$asset = new Asset();
$_SESSION['searchAssetTag'] = "";
$_SESSION['searchAssetType'] = "";
$_SESSION['searchBuildingId'] = 0;
$_SESSION['searchConditionId'] = 0;
$_SESSION['searchMacAddress'] = "";
$_SESSION['searchSerialNumber'] = "";
$_SESSION['searchName'] = "";
$_SESSION['searchNumPerPage'] = $maxAssetsPerPage;
$_SESSION['searchEmployeeName'] = "";
$_SESSION['searchpoNumberId'] = 0;
$_SESSION['searchOrganizationId'] =0;
$_SESSION['searchMake'] = "";
$searchAssetTag = GetTextField("searchAssetTag");
$searchAssetType = GetTextField("searchAssetTypeId",0);
$searchBuildingId = GetTextField("searchBuildingId",0);
$searchConditionId = GetTextField("searchConditionId",0);
$searchMacAddress = GetTextField("searchMacAddress",0);
$searchSerialNumber = GetTextField("searchSerialNumber");
$searchName = GetTextField("searchName");
$searchpoNumberId = GetTextField("searchpoNumberId",GetTextField("poNumberId",0));
$searchEmployeeName = GetTextField("searchEmployeeName");
$searchOrganizationId = GetTextField("searchOrganizationId");
$searchMake = GetTextField("searchMake");
if (strlen($searchAssetTag))
{
	$_SESSION['searchAssetTag'] = $searchAssetTag;
	if (is_numeric($searchAssetTag))
	{
		$param = AddEscapedParam($param,"assetId",$searchAssetTag);
	}
	else
	{
		$param = AddEscapedParam($param,"assetTag",$searchAssetTag);
	}
}
if ($searchAssetType)
{
	$_SESSION['searchAssetType'] = $searchAssetType;
	$param = AddEscapedParam($param,'assetTypeId',$searchAssetType);
}
if ($searchBuildingId)
{
	$_SESSION['searchBuildingId'] = $searchBuildingId;
	$param = AddEscapedParam($param,'buildingId',$searchBuildingId);
}

if ($searchConditionId)
{
	$_SESSION['searchConditionId'] = $searchConditionId;
	$param = AddEscapedParam($param,'assetConditionId',$searchConditionId);
}
else
{
	$assetCondition = new AssetCondition();
	$ok = $assetCondition->Get("showall = 1");
	$conditions = new Set();
	$conditions->separator=",";
	while ($ok)
	{
		$conditions->Add($assetCondition->assetConditionId);
		$ok = $assetCondition->Next();
	}
	$paramCondition = "assetConditionId in (".$conditions->data.")";
	$param = AddParam($param, $paramCondition);
}
if (strlen($searchMacAddress))
{
	$mac = $asset->FormatMacAddress($searchMacAddress);
	$_SESSION['searchMacAddress'] = $mac;
	$param = AddEscapedParamIfNotBlank($param,"macAddress",trim($mac));
}
if (strlen($searchSerialNumber))
{
	$_SESSION['searchSerialNumber'] = $searchSerialNumber;
	$param = AddEscapedParam($param,"serialNumber",$searchSerialNumber);
}
if (strlen($searchName))
{
	$_SESSION['searchName'] = $searchName;
	$param = AddEscapedLikeParam($param,"name","%".$searchName."%");
}
if ($searchpoNumberId)
{
	$_SESSION['searchpoNumberId'] = $searchpoNumberId;
	$param = AddEscapedParam($param,'poNumberId',$searchpoNumberId);
}
if (strlen($searchEmployeeName))
{
	$_SESSION['searchEmployeeName'] = $searchEmployeeName;
	$param = AddEscapedLikeParam($param,"employeeName","%".$searchEmployeeName."%");
}
if (strlen($searchMake))
{
    $_SESSION['searchMake'] = $searchMake;
    $param = AddEscapedLikeParam($param,"make","%".$searchMake."%");
}
if ($searchOrganizationId)
{
	$_SESSION['searchOrganizationID'] = $searchOrganizationId;
	$param = AddEscapedParam($param, "organizationId", $searchOrganizationId);
}
else
{
	$param1 = "organizationId in (".GetMyOrganizations().")";
	$param = AddParam($param, $param1);
}

$permission = new Permission();

$asset->SetPerPage(GetTextField("searchNumPerPage",$maxAssetsPerPage));
$numRows = $asset->Count($param);
$pages = 1;
if ($asset->perPage)
{
	$pages = ceil($numRows/$asset->perPage);
}
$_SESSION['searchNumPerPage'] = $asset->perPage;
$page = 1;
DebugText("Compute page we are on");
$page = GetURI(1,1);
$page = GetURI(2,1);
if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}
if (isset($_POST['page']))
{
	$page = $_POST['page'];
}
$asset->SetPage($page);
?>
<div class='result_bar'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      $firstDir = "listAssets";
      if ($pages > $maxAssetPages)
      {
      	$pages = $maxAssetPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = "is_selected";
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php

      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
<form name="assets" method="post" action="/process/asset/jumbo.php">
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
    &nbsp;
    </th>
  </tr>
  <?php

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
    if ($permission->hasPermission("Asset: Jumbo"))
    {
    	?>
      <input type="checkbox" name="asset<?php echo $asset->assetId;?>" class="asset"/>
      <?php
    }
    ?>
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
        <input type="submit" value="Jumbo" name="jumbo" id="jumboAsset"/>
      </td>
      <td align="right">
        <input type="button" value="Select All" name="addSelectAll" id="addSelectAll" />
        <input type="button" value="Unselect All" name="addUnselectAll" id="addUnselectAll" />
      </td>
    </tr>
  </table>
<?php
}
?>
</form>
<div class='result_bar'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      $firstDir = "listAssets";
      if ($pages > $maxAssetPages)
      {
      	$pages = $maxAssetPages;
      }
      //Pagination Numbers
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = 'class="is_selected"';
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php

      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
<?php
DebugOutput();
?>
