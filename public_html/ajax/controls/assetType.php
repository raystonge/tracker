<?php
/*
 * Created on Aug 23, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/assetType.php";
include_once "tracker/organization.php";
$organizationId = GetTextField("organization",GetTextField("searchOrganizationId",0));
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
