<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
<div class="adminArea">
<?php
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
$cnt = 0;
$imported = 0;
if (isset($_FILES['importFile']))
{
	$fname = $_FILES['importFile']['tmp_name'];
	$originalName = $_FILES['importFile']['name'];
	if (strlen($fname)==0)
	{
		exit;
	}
	if (is_uploaded_file($fname))
	{
		if ($fp = fopen($fname,"r"))
		{
			$isOk = 1;
			$delimiter = ",";
			$row = fgetcsv($fp, 1000, $delimiter);
			for ($i = 0;$isOk && ($i <=11);$i++)
			{
				if (!isset($row[$i]))
				{
					$isOk = 0;
				}
			}
			fclose($fp);
			if (!$isOk)
			{
				echo "File is not properly formated";
				exit();
			}
			$fp = fopen($fname,"r");
			?>
			<form method="post" action="/completeAssetImport/">
			<?php CreateHiddenField("fname",$fname);?>
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
			   	$delimiter = ",";
			   	$asset = new Asset();

			   	while (($row = fgetcsv($fp, 1000, $delimiter)) !== FALSE)
			   	{
			   		$asset->macAddress = $asset->FormatMacAddress(trim($row[1]));
			   		if (!$asset->IsValid($asset->macAddress))
			   		{
			   			$asset->macAddress = "";
			   		}
			   		$asset->assetTag = trim($row[2]);
			   		$asset->buildingLocation = trim($row[3]);
			   		$asset->make = trim($row[4]);
			   		$asset->model = trim($row[5]);
			   		$asset->modelNumber = trim($row[6]);
			   		$asset->serialNumber = trim($row[7]);

			   		$buildingName = trim($row[8]);
			   		$building = new Building();
			   		$param = AddEscapedParam("","name",$buildingName);
			   		$asset->buildingId = $building->Get($param);
			   		$type = trim($row[9]);
			   		if ($type == "desktop" || $type=="Desktop")
			   		{
			   			$type = "Computer";
			   		}

			   		$assetType = new AssetType();
			   		$param = AddEscapedParam("","name",$type);
			   		$asset->assetTypeId = $assetType->Get($param);
			   		if ($assetType->name == "iPad")
			   		{
			   			$firstChar = substr($asset->serialNumber,0,1);
			   			if ($firstChar == "S")
			   			{
			   				$asset->serialNumber = substr($asset->serialNumber,1);
			   			}
			   		}

			   		$asset->employeeName = trim($row[10]);
			   		$commentText = trim($row[11]);
			   		$param = "";
			   		$param1 = "";
			   		$param2 = "";
			   		if (strlen($asset->serialNumber))
			   		{
			   			$param1 = AddEscapedParam("","serialNumber",$asset->serialNumber);
			   		}
			   		if (strlen($asset->macAddress))
			   		{
			   			$param2 = AddEscapedParam("","macAddress",$asset->macAddress);
			   		}
			   		if (strlen($param1))
			   		{
			   			$param = $param1;
			   		}
			   		if (strlen($param2))
			   		{
			   			$param = AddParam($param,$param2);
			   		}
			   		$testAsset = new Asset();
			   		$testAsset->Get($param);
			   		$model = strtolower($asset->model);
			   		if ($model == "ibook" || $model == "ibook g4")
			   		{
			   			$testAsset->assetId = 1;
			   		}
			   		if (!$testAsset->assetId && ($cnt < 1000))
			   		{

			   			$disabled = "";
			   			if (strlen($building->name) && strlen($assetType->name))
			   			{
			   				$asset->Insert();
			   				$imported++;
			   			}
			   			else
			   			{
			   				//$inserted++;
			   				$cnt++;
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
			   		     	CreateHiddenField("buildingName".$cnt,$buildingName);;
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
			   		     <?php echo "($cnt)";?>
			   		   </td>
			   		  </tr>
			   		</tr>


			   		<?php
			   			}
			   		}
			   	}

			  ?>
			  </table>
			  <?php
			  CreateHiddenField("cnt",$cnt);
			  CreateSubmit();
			  ?>
			</form>
			<?php
			fclose($fp);
			echo $imported." devices imported<br>";
			echo $cnt." devices need to be fixed<br>";
		}
		else
		{
			echo "Error occurred opening file";
		}
	}
	else
	{
		echo "File upload failed";
	}
}
?>
</div>
