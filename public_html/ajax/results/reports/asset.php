<?php
/*
 * Created on Aug 24, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php

include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/permission.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/poNumber.php";
$param = "";

$asset = new Asset();
$asset->SetPerPage($maxAssetsPerPage);
$param = $module->GetParam();
$pages = 1;
//$ticket->SetOrderBy("dueDate desc,priorityId");
DebugText("report param:".$param);
$numRows = $asset->Count($param);
if ($asset->perPage)
{
	$pages = ceil($numRows/$asset->perPage);
}
DebugText("numRows:".$numRows);
DebugText("pages:".$pages);
$_SESSION['searchNumPerPage'] = $asset->perPage;
$page = 1;
DebugText("Compute page we are on");
//$page = GetURI(1,1);
$page = GetURI(4,1);
if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}
$page = GetTextField("page",$page);
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
<form name="assets" method="post" action="/process/asset/jumbo.php">
<?php CreateHiddenField("moduleId",$module->moduleId);?>
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
		PO Number
		</th>
		<th>
			Aquired Date
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
    <?php echo $asset->name;?>
    </td>
		<td>
			<?php
			$poNumber = new poNumber($asset->poNumberId);
			?>
			<a href="/poNumberEdit/<?php $poNumber->poNumberId;?>/" target="_blank">
			  <?php echo $poNumber->poNumber;?>
		  </a>
		</td>
		<td>
			<?php echo $asset->aquireDate; ?>
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
      <input type="checkbox" name="asset<?php echo $asset->assetId;?>" class="asset"/>
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
