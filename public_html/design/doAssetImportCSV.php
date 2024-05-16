<?php
//
//  Tracker - Version 1.12.0
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
include_once "tracker/organization.php";
$cnt = 0;
$imported = 0;
$organizationId = 11;
$organization = new Organization($organizationId);
$assetConditionId =3;
$buildingId = GetTextField("buildingId",0);
$poNumberId = GetTextField("poNumberId",0);
echo "Processing<br>";
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
			for ($i = 0;$isOk && ($i <=10);$i++)
			{
				if (!isset($row[$i]))
				{
					$isOk = 0;
				}
			}
			if (sizeof($row) != 11)
			{
				$isOk = 0;
			}
			fclose($fp);
			if (!$isOk)
			{
				echo "File is not properly formated";
				print_r($row);
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
			      Make
			      </th>
			      <th>
			      Model
			      </th>

			      <th>
			      RAM
			      </th>
			      <th>
			       Hard Drive
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
			   		//$asset->assetTag = trim($row[2]);
			   		//$asset->buildingLocation = trim($row[3]);
			   		$asset->make = trim($row[1]);
			   		$asset->model = trim($row[2]);
			   		//$asset->modelNumber = trim($row[6]);
			   		$asset->serialNumber = trim($row[0]);
					$asset->organizationId = $organizationId;
					$asset->assetConditionId = $assetConditionId;
					$asset->poNumberId = $poNumberId;
					$asset->vendor = "Connection";

			   		//$buildingName = trim($row[8]);
			   		$building = new Building($buildingId);
			   		//$param = AddEscapedParam("active = 1","name",$buildingName);
			   		$asset->buildingId = $building->buildingId;
			   		$type = trim($row[2]);

					if ($type == "ThinkCentre M715")
					{
						$type = "Computer";
					}
					else
					{
						$type = "Laptop";
					}

			   		$assetType = new AssetType();
			   		$param = AddEscapedParam("organizationId=".$organizationId,"name",$type);
			   		$asset->assetTypeId = $assetType->Get($param);


			   		$asset->employeeName = trim($row[8]);
			   		//$commentText = trim($row[8]);
					$commentText = "";
			   		$param = "";
			   		$param1 = "";
			   		$param2 = "";
			   		if (strlen($asset->serialNumber))
			   		{
			   			$param1 = AddEscapedParam("","serialNumber",$asset->serialNumber);
			   		}
			   		if (strlen($param1))
			   		{
			   			$param = $param1;
			   		}
			   		$testAsset = new Asset();
			   		$testAsset->Get($param);
			   		$model = strtolower($asset->model);

			   		if (!$testAsset->assetId && ($cnt < 1000))
			   		{

			   			$disabled = "";
			   			if (strlen($building->name) && strlen($assetType->name))
			   			{
			   				$asset->Insert();
							$asset->assetTag = $organization->assetPrefix."-".$asset->assetId;
							$asset->Update();
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
			   		     	  $ok = $building->Get("active = 1");
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
