<?php
//
//  Tracker - Version 1.5.0
//
// v1.5.0
//  - added test for active buildings
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
<?php
include_once "tracker/asset.php";
include_once "tracker/user.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/comment.php";
include_once "tracker/permission.php";
include_once "tracker/contract.php";
include_once "tracker/poNumber.php";
$permission = new Permission();

$assets = "";
if (isset($_SESSION['assetJumbo']));
{
	$assets = $_SESSION['assetJumbo'];
	$_SESSION['assetJumbo'] = "";
}
$assetType = new AssetType();
$contractId = "--do_not_change--";
$commentText = "";
$formKey = getFormKey();
$contract = new Contract();
$asset->PrepJumboEditor();
?>
<script type="text/javascript">
adminFilePath="";
</script>

<script language="javascript">
function toggleAquireDate()
{
	var warrantyDate = document.getElementById('warrantyDate');
	aquireDate.disabled = !aquireDate.disabled;

}
function toggleWarrantyDate()
{
  var warrantyDate = document.getElementById('warrantyDate');
	warrantyDate.disabled = !warrantyDate.disabled;

}

function disableAquireDate()
{
  var aquireDate = document.getElementById('aquireDate');
 	aquireDate.disabled = true;
}

function disableWarrantyDate()
{
	var warrantyDate = document.getElementById('warrantyDate');
	warrantyDate.disabled = true;
}

$(document).ready(function ()
{
	 $('#make').autocomplete({source:'/ajax/lookups/make.php', minLength:1});
	 $('#buildingLocation').autocomplete({source:'/ajax/lookups/buildingLocation.php', minLength:1});
	 $('#vendor').autocomplete({source:'/ajax/lookups/vendor.php', minLength:1});
	 $('#model').autocomplete({minLength:1,
      source: function (request, response) {
        var make = $("#make").val(),
            model = $("#model").val();

        $.ajax({
            url: '/ajax/lookups/model.php?make=' + make + '&model='+model,
            success: function(data) {
                response(parseLineSeperated(data));
            },
            error: function(req, str, exc) {
                alert(str);
            }
        });
    }
});

	 $('#modelNumber').autocomplete({minLength:1,
      source: function (request, response) {
        var make = $("#make").val(),
            model = $("#model").val();
            modelNumber = $("#modelNumber").val();

        $.ajax({
            url: '/ajax/lookups/modelNumber.php?make=' + make + '&model='+model + '&modelNumber=' + modelNumber,
            success: function(data) {
                response(parseLineSeperated(data));
            },
            error: function(req, str, exc) {
                alert(str);
            }
        });
    }
});

   function parseLineSeperated(data)
   {
   	data = data.split("\n");
    return data;
   }
});
</script>
<?php
    if (FormErrors())
    {
        	DebugText("Using Session Data");
        	$asset->buildingId = $_SESSION['assetJumboBuildingId'];
        	$asset->buildingLocation = $_SESSION['assetJumboBuildingLocation'];
        	$asset->assetTypeId = $_SESSION['assetJumboAssetType'];
        	$asset->assetConditionId = $_SESSION['assetJumboConditionId'];
        	$asset->make = $_SESSION['assetJumboMake'];
        	$asset->model = $_SESSION['assetJumboModel'];
        	$asset->modelNumber = $_SESSION['assetJumboModelNumber'];
        	$asset->poNumberId = $_SESSION['assetJumboPONumber'];
        	$asset->vendor = $_SESSION['assetJumboVendor'];
        	$asset->aquireDate = $_SESSION['assetJumboAquireDate'];
        	$asset->name = $_SESSION['assetJumboName'];
        	$commentText = $_SESSION['assetJumboComment'];
        	$contractId = $_SESSION['assetJumboContractId'];
        	DisplayErrors();
    }
    DebugText("serialNumber:".$asset->serialNumber);
    DebugText("assetTag:".$asset->assetTag);
    ?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/asset/assetJumbo.php">
		<table>
			<tr>
				<td valign="top">    Asset Type:
				<?php if ($permission->hasPermission("Asset: Edit"))
				{
					?>
				<select name="assetTypeId" id="assetTypeId">
            <option value="--do_not_change--">--do_not_change--</option>
            <?php
            $assetType = new AssetType();
            $ok = $assetType->Get("selectable = 1");
            while ($ok)
            {
            	$selected = "";
            	if ($asset->assetTypeId == $assetType->assetTypeId)
            	{
            		$selected = "selected='selected'";
            	}            	?>
            	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $assetType->name;?></option>
            	<?php
            	$ok = $assetType->Next();
            }
            ?>
          </select>
          <?php
				}
				else
				{
					$assetType = new AssetType($asset->assetTypeId);
					echo $assetType->name;
				}
				?>
				</td>
				<td>
				&nbsp;
				</td>
			</tr>
			<tr>
			  <td>Make: <?php CreateTextField("make",$asset->make,getFieldSize("asset","make"),"Make for assets",$editFieldClass);?>
			  </td>
			  <td>
			  Model: <?php CreateTextField("model",$asset->model,getFieldSize("asset","model"),"Model for assets",$editFieldClass);?>
			  </td>
			</tr>
			<tr>
			  <td>Model Number: <?php CreateTextField("modelNumber",$asset->modelNumber,getFieldSize("asset","modelNumber"),"Model Number for assets",$editFieldClass);?>
			  </td>
			  <td>
			  Condition:
				<?php if ($permission->hasPermission("Asset: Edit"))
				{
					?>
				<select name="conditionId" id="conditionId">
            <option value="--do_not_change--">--do_not_change--</option>
            <?php
            $condition = new AssetCondition();
            $ok = $condition->Get("");
            while ($ok)
            {
            	$selected = "";
            	if ($condition->assetConditionId == $asset->assetConditionId)
            	{
            		$selected = "selected='selected'";
            	}            	?>
            	<option value="<?php echo $condition->assetConditionId;?>" <?php echo $selected;?>><?php echo $condition->name;?></option>
            	<?php
            	$ok = $condition->Next();
            }
            ?>
          </select>
          <?php
				}
				else
				{
					$assetType = new AssetType($asset->assetTypeId);
					echo $assetType->name;
				}
				?>
			  </td>
			</tr>
			<tr>
				<td>Building:<select name="buildingId">
            <option value="--do_not_change--">--do_not_change--</option>
            <?php
            $building = new Building();
            $ok = $building->Get("active = 1");
            while ($ok)
            {
            	$selected = "";
            	if ($asset->buildingId == $building->buildingId)
            	{
            		$selected = "selected='selected'";
            	}            	?>
            	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $building->name;?></option>
            	<?php
            	$ok = $building->Next();
            }
            ?>
            </select>
				</td>
				<td>
				Building Location: <?php CreateTextField("buildingLocation",$asset->buildingLocation,getFieldSize("asset","buildingLocation"),"Location in the building for assets",$editFieldClass);?>
				</td>
			</tr>

			<tr>
			  <td>
			  PO Number: <select name="assetpoNumberId">
                           <option value="--do_not_change--">--do_not_change--</option>
                           <?php
                           $po = new poNumber();
                           $ok = $po->Get("poType='Asset'");
                           while ($ok)
                           {
                           	?>
                           	<option value="<?php echo $po->poNumberId;?>"><?php echo $po->poNumber." - ".$po->description;?></option>
                           	<?php
                           	$ok = $po->Next();
                           }
                           ?>
                         </select>
			  </td>
			  <td>			  Vendor: <?php CreateTextField("vendor",$asset->vendor,getFieldSize("asset","vendor"),"Vendor which assets were purchased from",$editFieldClass);?>

			  </td>
			</tr>
			<tr>
			  <td>
			  			   Warranty Date:
			   <?php CreateDatePicker("warrantyDate",$asset->warrantyDate);?>
						<input type="checkbox" name="useWarrantyDate"
						onclick="toggleWarrantyDate()" /> Change Warranty Date
			  </td>
			  <td >
			   Aquire Date:
         <?php CreateDatePicker("aquireDate",$asset->aquireDate);?>
						<input type="checkbox" name="useAquireDate"
						onclick="toggleAquireDate()" /> Change Aquire Date
			  </td>
			</tr>
			<tr>
			  <td>Contract:
            <select name="contractId">
            <option value="--do_not_change--">--do_not_change--</option>
            <?php
            $contract = new Contract();
            $ok = $contract->Get("");
            while ($ok)
            {
            	$selected = "";
            	if ($contractId == $contract->contractId)
            	{
            		$selected = "selected='selected'";
            	}
            	?>
            	<option value="<?php echo $contract->contractId;?>" <?php echo $selected;?>><?php echo $contract->name." - ".$contract->expireDate;?></option>
            	<?php
            	$ok = $contract->Next();
            }
            ?>
            </select>
			  </td>
			  <td >&nbsp;
			  </td>
			</tr>

		</table>


			    <textarea id="description" name="description" rows="5"  wrap="off"></textarea>
<br>
<?php
PrintFormKey();
CreateHiddenField("submitTest","1");
CreateHiddenField("assetIds",$assets);
CreateSubmit();
?>
				</td>

	</form>


<script src="https://cdn.tiny.cloud/1/udklcg4ghf32p6fo376bvfap162ddwbu1oq6jhb0tgs9qoi0/tinymce/<?php echo $tinyMCE;?>/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
tinymce.init({
//  selector: '#myeditablediv',
//  inline: true
	selector: 'textarea',
	height: 250,
	statusbar: false,
	toolbar: 'undo redo  bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
	plugins: 'code',
	menubar: false
});
</script>
<script type="text/javascript">
disableAquireDate();
disableWarrantyDate();
</script>
