<?php
/*
 * Created on Jan 17, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<div class="adminArea">
<?php
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/comment.php";
$cnt = 0;
$cntItemsImported = 0;
$numItems = GetTextField("cnt",0);
?>
  <form method="post" action="/completeAssetImport/">
    <table class="width100">
	  <tr>
		<th>
		 Serial Number
		</th>
		<th>
		 Mac Address
		</th>
		<th>
		 Make
		</th>
		<th>
		 Model
		</th>
	    <th>
	     Building
	    </th>
	    <th>
	     Asset Type
	    </th>
	    <th>
	     Import
	    </th>
	   </tr>
	   <?php
	   for ($i = 1; $i <= $numItems; $i++)
	   {
	   	  $doImport = GetTextField("doImport".$i,0);
	   	  	$asset = New Asset();
	   	  	$buildingName = GetTextField("buildingName".$i);
	   	  	$type =  GetTextField("assetTypeName".$i);
	   	  	$asset->serialNumber = GetTextField("serialNumber".$i);
	   	  	$asset->macAddress = GetTextField("macAddress".$i);
	   	  	$asset->assetTypeId = GetTextField("assetType".$i);
	   	  	$asset->buildingId = GetTextField("buildingId".$i);
	   	  	$asset->assetTag = GetTextField("assetTag".$i);
	   	  	$asset->make = GetTextField("make".$i);
	   	  	$asset->model = GetTextField("model".$i);
	   	  	$asset->modelNumber = GetTextField("modelNumber".$i);
	   	  	$asset->buildingLocation = GetTextField("buildingLocation".$i);
	   	  	$asset->employeeName = GetTextField("employeeName".$i);
	   	  	$commentText = GetTextField("comment".$i);
	   	  	if (!$asset->buildingId)
	   	  	{
	   	  		$doImport = 0;
	   	  	}
	   	  	if (!$asset->assetTypeId)
	   	  	{
	   	  		$doImport = 0;
	   	  	}

	   	  if ($doImport)
	   	  {
	   	  	
	   	  	$asset->Insert();
	   	  	if (strlen($commentText))
	   	  	{
	   	  		$comment= new Comment();
	   	  		$comment->assetId = $asset->assetId;
	   	  		$comment->comment = $commentText;
	   	  	}
	   	  
	   	  }
	   	  else
	   	  {
	   	  	$building = new Building();
	   	  	$assetType = new AssetType();
	   	  	?>
			   		<tr>
			   		  <tr>
			   		   <td width="100px">
			   		     <?php
			   		     if (strlen($asset->serialNumber))
			   		     {
			   		     	CreateTextField("serialNumber".$cnt);
			   		     }
			   		     else
			   		     {
			   		     	echo $asset->serialNumber;
			   		     	CreateHiddenField("serialNumber".$cnt,$asset->serialNumber);
			   		     }
			   		     CreateHiddenField("assetTag".$cnt,$asset->assetTag);
			   		     ?>
			   		   </td>
			   		   <td width="100px">
			   		     <?php 
			   		     if (!strlen($asset->macAddress))
			   		     {
			   		     	CreateTextField("macAddress".$cnt);
			   		     }
			   		     else
			   		     {
			   		     	echo $asset->macAddress;
			   		     	CreateHiddenField("macAddress".$cnt,$asset->macAddress);
			   		     }
			   		     ?>
			   		   </td>
			   		   <td>
			   		     <?php echo $asset->make;
			   		     CreateHiddenField("make".$cnt,$asset->make);
			   		     ?>
			   		   </td>
			   		   <td>
			   		     <?php echo $asset->model;
			   		     CreateHiddenField("model".$cnt,$asset->model);
			   		     CreateHiddenField("modelNumber".$cnt,$asset->modelNumber);
			   		     ?>
			   		   </td>
			   		   <td  width="100px">
			   		     <?php
			   		     if (strlen($building->name))
			   		     {
			   		     	echo $building->name;
			   		     	CreateHiddenField("buildingId".$cnt,$asset->buildingId);
			   		     }
			   		     else
			   		     {
			   		     	$disabled = "disabled";
			   		     	?>
			   		     	<select name="buildingId<?php echo $cnt;?>">
			   		     	  <option value="0"><?php echo $buildingName;?></option>
			   		     	  <?php
			   		     	  $ok = $building->Get("");
			   		     	  while ($ok)
			   		     	  {
			   		     	  	?>
			   		     	  	<option value="<?php echo $building->buildingId;?>"><?php echo $building->name;?></option>
			   		     	  	<?php
			   		     	  	$ok = $building->Next();
			   		     	  }
			   		     	  ?>
			   		     	</select>
			   		     	<?php		
			   		     }
			   		     CreateHiddenField("buildingLocation".$cnt,$asset->buildingLocation);
			   		     ?>
			   		   </td>
			   		   <td width="100px">
			   		     <?php
			   		     if (strlen($assetType->name))
			   		     {
			   		     	echo $assetType->name;
			   		     	CreateHiddenField("assetType".$cnt,$asset->assetTypeId);
			   		     }
			   		     else
			   		     {
			   		     	$disabled = "disabled";
			   		     	?>
			   		     	<select name="assetType<?php echo $cnt;?>">
			   		     	  <option value="0"><?php echo $type;?></option>
			   		     	  <?php
			   		     	  $ok = $assetType->Get("");
			   		     	  while ($ok)
			   		     	  {
			   		     	  	?>
			   		     	  	<option value="<?php echo $assetType->assetTypeId;?>"><?php echo $assetType->name;?></option>
			   		     	  	<?php
			   		     	  	$ok = $assetType->Next();
			   		     	  }
			   		     	  ?>
			   		     	</select>
			   		     	<?php
			   		     }
			   		     ?>
			   		   </td>
			   		   <td>
			   		   <?php
			   		   CreateHiddenField("employeeName".$cnt,$asset->employeeName);
			   		   CreateHiddenField("comment".$cnt,$commentText);
			   		   $class = "checkbox";
			   		   $checked = "checked='checked'";
			   		   if ($disabled)
			   		   {
			   		   	$checked = "";
			   		   }
			   		   ?>
			   		     <input type="checkbox" <?php echo $checked;?> class="<?php echo $class;?>" name="doImport<?php echo $cnt;?>" value="1" />
			   		     <?php echo "($i)";?>
			   		   </td>
			   		  </tr>
			   		</tr>
	   	  	
	   	  	<?php
	   	  }
	   	  
	   	
	   }
	   ?>
    </table>
  </form>
</div>