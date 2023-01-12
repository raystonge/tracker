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
include_once "tracker/building.php";
include_once "tracker/organization.php";
$organizationId = GetTextField("organizationId",GetTextFromSession("searchAssetOrganizationId",0,0));
$searchBuildingId = GetTextField("searchBuildingId",GetTextFromSession("searchBuildingId",0,0));
$param = "";
if ($organizationId)
{
	$param = AddEscapedParam($param,"organizationId",$organizationId);
}
?>

			    <select name="searchBuildingId">
			      <option value="0">All</option>
			      <?php
			      $building = new Building();
			      $ok = $building->Get($param);
			      while ($ok)
			      {

			      	$selected = "";
			      	if ($building->buildingId == $searchBuildingId)
			      	{
			      		$selected = "selected=='selected'";
			      	}
							$name = $building->name;
							if (!$organizationId)
							{
								$organization = new Organization($building->organizationId);
								$name = $building->name." - ".$organization->name;
							}
			      	?>
			      	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $name;?></option>
			      	<?php
			      	$ok = $building->Next();
			      }
			      ?>
			    </select>
