<?php
include_once "tracker/asset.php";
include_once "tracker/user.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/comment.php";
include_once "tracker/poNumber.php";
include_once "tracker/permission.php";
$permission = new Permission();

$assetType = new AssetType();
$commentText = "";
$formKey = getFormKey();
?>
<script type="text/javascript">
adminFilePath="";
</script>

<script src="https://cdn.tiny.cloud/1/udklcg4ghf32p6fo376bvfap162ddwbu1oq6jhb0tgs9qoi0/tinymce/<?php echo $tinyMCE;?>/tinymce.min.js" referrerpolicy="origin"></script>


<script type="text/javascript"  src="<?php echo $hostPath;?>/js/calendarDateInput.js"></script>
<script type="text/javascript" >

function toggle()
{
  var expireDate_Month_ID = document.getElementById('expireDate_Month_ID');
  var expireDate_ID = document.getElementById('expireDate_Day_ID');
  var expireDate_Year_ID = document.getElementById('expireDate_Year_ID');
  expireDate_Month_ID.disabled = !expireDate_Month_ID.disabled;
  expireDate_Day_ID.disabled = !expireDate_Day_ID.disabled;
  expireDate_Year_ID.disabled = !expireDate_Year_ID.disabled;

}
function disableExpireDate()
{
  var expireDate_Month_ID = document.getElementById('expireDate_Month_ID');
  var expireDate_Day_ID = document.getElementById('expireDate_Day_ID');
  var expireDate_Year_ID = document.getElementById('expireDate_Year_ID');
  expireDate_Month_ID.disabled = true;
  expireDate_Day_ID.disabled = true;
  expireDate_Year_ID.disabled = true;
}
function enableExpireDate()
{
  var expireDate_Month_ID = document.getElementById('expireDate_Month_ID');
  var expireDate_Day_ID = document.getElementById('expireDate_Day_ID');
  var expireDate_Year_ID = document.getElementById('expireDate_Year_ID');
  expireDate_Month_ID.disabled = false;
  expireDate_Day_ID.disabled = false;
  expireDate_Year_ID.disabled = false;
}


$(document).ready(function ()
{

	 $('#make').autocomplete({minLength:1,
      source: function (request, response) {
        var make = $("#make").val(),
            assetTypeId=22;
        $.ajax({
            url: '/ajax/lookups/make.php?make=' + make + '&assetTypeId='+assetTypeId,

            success: function(data) {
                response(parseLineSeperated(data));
                //response(data);
            },
            error: function(req, str, exc) {
                alert(str);
            }
        });
    }

});
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
                //response(data);
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
                //response(data);
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
       	$asset->serialNumber = GetTextFromSession('assetSerialNumber');
       	$asset->assetTag = GetTextFromSession('assetAssetTag');
       	$asset->buildingId = GetTextFromSession('assetBuildingId');
       	$asset->buildingLocation = GetTextFromSession('assetBuildingLocation');
       	$asset->assetTypeId = GetTextFromSession('assetAssetType');
       	$asset->assetConditionId = GetTextFromSession('assetConditionId');
       	$asset->macAddress = GetTextFromSession('assetMacAddress');
       	$asset->make = GetTextFromSession('assetMake');
       	$asset->model = GetTextFromSession('assetModel');
       	$asset->modelNumber = GetTextFromSession('assetModelNumber');
       	$asset->poNumberId = GetTextFromSession('assetPONumberId',0);
       	$asset->vendor = GetTextFromSession('assetVendor');
       	$asset->aquireDate = GetTextFromSession('assetAquireDate');
       	$asset->name = GetTextFromSession('assetName');
       	$asset->employeeName = GetTextFromSession('assetEmployeeName');
       	$commentText = GetTextFromSession('assetComment');
       	DisplayFormErrors();
    }
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }
    DebugText("serialNumber:".$asset->serialNumber);
    DebugText("assetTag:".$asset->assetTag);
    ?>

	<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/asset/asset.php">
	   <?php CreateHiddenField("assetTag",$asset->assetTag);?>
		<table>
			<tr>
				<td valign="top">    Asset Type:
				<?php
					$assetType = new AssetType($asset->assetTypeId);
					echo $assetType->name;
					CreateHiddenField("assetTypeId",$asset->assetTypeId);
				?>
				</td>
				<td>
				&nbsp;
				</td>
			</tr>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software Company"))
			  {?>
			  Software Company: <?php CreateTextField("make",$asset->make,getFieldSize("asset","make"),"Company that makes the Software");?>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Software Company"))
			  	{
			  		echo "Software Company: ".$asset->make;
			  	}
			  	CreateHiddenField("make",$asset->make);
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software"))
			  {
			  	?>
			  Software: <?php CreateTextField("model",$asset->model,getFieldSize("asset","model"),"Name of Software");?>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Software"))
			  	{
			  		echo "Software: ".$asset->model;
			  	}
			  	CreateHiddenField("model",$asset->model);
			  }
			  ?>
			  </td>
			</tr>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software Version"))
			  {
			  	?>
			  Version: <?php CreateTextField("modelNumber",$asset->modelNumber,getFieldSize("asset","modelNumber"),"Software Version");?>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Software Version"))
			  	{
			  		echo "Version: ".$asset->modelNumber;
			  	}
			  	CreateHiddenField("modelNumber",$asset->modelNumber);
			  }
			  ?>
			  </td>
			  <td>&nbsp;
			  </td>
			</tr>
		  <tr>
		    <td valign="top" >
		      <?php
		      if ($permission->hasPermission("Asset: Edit: Software Serial Number"))
		      {
		      	?>
		         Serial Number: <?php CreateTextField("serialNumber",$asset->serialNumber,getFieldSize("asset","serialNumber"),"Asset SerialNumber");?>
		         <?php
		      }
		      else
		      {
		      	if ($permission->hasPermission("Asset: View: Software Serial Number"))
		      	{
		      		echo "Serial Number: ".$asset->serialNumber;
		      	}
		      	CreateHiddenField("serialNumber",$asset->serialNumber);
		      }
		      ?>
		    </td>
		    <td>
		    <?php
		    if ($permission->hasPermission("Asset: Edit: Software Number of Licenses"))
		    {
		    	?>
		    	Number of Licenses: <?php CreateTextfield("numOfLicenses",$asset->numOfLicenses,getFieldSize("asset","numOfLicenses"),"Number of Licenses Purchased");?>
		    	<?php
		    }
		    else
		    {
		    	if ($permission->hasPermission("Asset: View: Software Number of Licenses"))
		    	{
		    		echo "Number of Licenses: ".$asset->numOfLicenses;
		    	}
		    	CreateHiddenField("numOfLicenses",$asset->numOfLicenses);
		    }
		    ?>
		    </td>
		  </tr>
			<tr>
				<td>
				<?php
				if ($permission->hasPermission("Asset: Edit: Software Building"))
				{
					?>

				Building:<select name="buildingId">
            <option value="0">Select a Building</option>
            <?php
            $building = new Building();
            $ok = $building->Get("");
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
            <?php
				}
				else
				{
					if ($permission->hasPermission("Asset: View: Software Building"))
					{
						$building = new Building($asset->buildingId);
						echo "Building: ".$building->name;
					}
					CreateHiddenField("buildingId",$asset->buildingId);
				}
				?>
				</td>
				<td>
				<?php
				if ($permission->hasPermission("Asset: Edit: Software Building Location"))
				{
					?>
				    Building Location: <?php CreateTextField("buildingLocation",$asset->buildingLocation,getFieldSize("asset","buildingLocation"),"Location of asset");?>
				    <?php
				}
				else
				{
					if ($permission->hasPermission("Asset: View: Software Building Location"))
					{
						echo "Building Location: ".$asset->buildingLocation;
					}
				}
				?>
				</td>
			</tr>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software PO Number"))
			  {
			  	?>
			    PO Number:
					<select id="poNumberId" name="poNumberId">
					  <option value="0">Select PO</option>
					<?php
					$poNumber = new poNumber();
					$ok = $poNumber->Get("poType='Asset'");
					while ($ok)
					{
						$selected = "";
						if ($poNumber->poNumberId == $asset->poNumberId)
						{
							$selected = "selected='selected'";
						}
						?>
						<option value="<?php echo $poNumber->poNumberId;?>" <?php echo $selected;?> ><?php echo $poNumber->poNumber." - ".$poNumber->description;?></option>
						<?php
						$ok = $poNumber->Next();
					}
					?>
					</select>
					<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Software PO Number"))
			  	{
			  		$po = new poNumber($asset->poNumberId);
			  		echo "PO Number:".$po->poNumber;
			  	}
			  	CreateHiddenField("poNumberId",$asset->poNumberId);
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software Expire Date"))
			  {
			  	?>
			   Expire Date: <?php CreateDateField("expireDate",$asset->expireDate);
			  $on = 0;
			  if (strlen($asset->expireDate))
			  {
			  	$on = 1;
			  }
			  CreateCheckBox("useExpireDate",1,"Enable Expire Date",$on,"Click to enable the expire date","","onclick='toggle()'");
			  ?>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Software Expire Date"))
			  	{
			  		echo "Expire Date: ".$asset->expireDate;
			  	}
			  	CreateHiddenField("expireDate",$asset->expireDate);
			  }
			  ?>
			  </td>
			</tr>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software Vendor"))
			  {
			  	?>
			  Vendor: <?php CreateTextField("vendor",$asset->vendor,getFieldSize("asset","vendor"),"Vendor Asset was purchased");?>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Software Vendor"))
			  	{
			  		echo "Vendor: ".$asset->vendor;
			  	}
			  	CreateHiddenField("vendor",$asset->vendor);
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Software Aquire Date"))
			  {
			  	?>
			   Aquired:
			   <script language="javascript">DateInput('aquireDate', true, 'YYYY/MM/DD','<?php echo $asset->aquireDate;?>');</script>
			   <?php
			  }
			  else
			  {
			  	 if ($permission->hasPermission("Asset: View: Software Aquire Date"))
			  	 {
			  	 	echo "Aquired: ".$asset->aquireDate;
			  	 }
			  	 CreateHiddenField("aquireDate",$asset->aquireDate);
			  }
			  ?>
			  </td>
			</tr>
		</table>
		<?php
		if ($permission->hasPermission("Asset: Edit: Software Add Comment"))
		{
			?>
		    <textarea id="description" name="description" rows="5"  wrap="off"><?php echo $commentText;?></textarea>
		    <?php
		}
		?>
<br>
               <?php
               PrintFormKey();
               CreateHiddenField("submitTest",1);
               CreateHiddenField("assetId",$asset->assetId);
               CreateSubmit("Submit","Submit");
               ?>
	</form>


	<?php
	$comment = new Comment();

	$ok = $comment->GetByAssetId($asset->assetId);
	if (!$permission->hasPermission("Asset: View: Software Comments"))
	{
		$ok = 0;
	}
	if ($ok)
	{
		?><hr>
		<?php
	}
	?>
	<table class="width100">
	<?php
	while ($ok)
	{
		$user = new User($comment->userId);
		?>
		<tr>
		  <td><?php echo $user->fullName." on ".$comment->posted;?>
		  <hr>
		  </td>
		</tr>
		<tr>
		  <td>
		  <?php echo $comment->comment;?>
		  </td>
		</tr>
		<?php
		$ok = $comment->Next();
	}
	?>
	</table>

<?php
if (!strlen($asset->expireDate))
{
	?>
<script type="text/javascript">
disableExpireDate();
</script>
<?php
}
else
{
	?>
<script type="text/javascript">
enableExpireDate();
</script>
<?php
}
?>
