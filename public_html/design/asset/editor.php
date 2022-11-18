<?php
include_once "tracker/asset.php";
include_once "tracker/user.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
include_once "tracker/comment.php";
include_once "tracker/poNumber.php";
include_once "tracker/organization.php";
include_once "tracker/validCondition.php";
include_once "tracker/permission.php";
$permission = new Permission();

$assetType = new AssetType();
$commentText = "";
$formKey = getFormKey();
?>
<script type="text/javascript">
adminFilePath="";
</script>
  <!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->
  <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
  <script src="https://cdn.tiny.cloud/1/udklcg4ghf32p6fo376bvfap162ddwbu1oq6jhb0tgs9qoi0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

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

<!--
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/config.js"></script>
-->
<!-- Removing this to get tinymce to work
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" 	src="<?php echo $hostPath;?>/ckeditor/adapters/jquery.js"></script>
-->

<!--
<script type="text/javascript"  src="<?php echo $hostPath;?>/js/jquery.ui.autocomplete.js"></script>
-->
<script type="text/javascript"  src="<?php echo $hostPath;?>/js/calendarDateInput.js"></script>
<script type="text/javascript" >
$(document).ready(function ()
{


	 $('#make').autocomplete({minLength:1,
      source: function (request, response) {
        var make = $("#make").val(),
            assetTypeId= $("#assetTypeId").val();
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

   $("#poNumberId").change(function(){
	   poNumberId = $("#poNumberId").val();
	   if (poNumberId == 0)
	   {
		   return;
	   }
	   theLink = "<a href='/poNumberEdit/"+poNumberId+"/'>View PO</a>";
	   $("#poNumberLink").html(theLink);

   });
   $("#poNumberId").change();
   $("#organization").change(function() {
      link = "/ajax/controls/poNumber.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#poNumberResults").html(theResponse);
       });
   });
   $("#organization").change();

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
    $enableWarranty = 0;
    if (strlen($asset->warrantyDate))
    {
    	$enableWarranty = 1;
    }
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
       	$asset->warrantyDate = GetTextFromSession('assetWarrantyDate');
       	$enableWarranty = GetTextFromSession("assetEnableWarranty");
       	$commentText = GetTextFromSession('assetComment');
       	$asset->organizationId = GetTextFromSession("assetOrganizationId");
       	DisplayFormErrors();
    }
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }
    DebugText("serialNumber:".$asset->serialNumber);
    DebugText("assetTag:".$asset->assetTag);
    ?>
<script language="javascript">
function toggle()
{
  var warrantyDate_Month_ID = document.getElementById('warrantyDate_Month_ID');
  var warrantyDate_ID = document.getElementById('warrantyDate_Day_ID');
  var warrantyDate_Year_ID = document.getElementById('warrantyDate_Year_ID');
  warrantyDate_Month_ID.disabled = !warrantyDate_Month_ID.disabled;
  warrantyDate_Day_ID.disabled = !warrantyDate_Day_ID.disabled;
  warrantyDate_Year_ID.disabled = !warrantyDate_Year_ID.disabled;

}
function disableWarrantyDate()
{
  var warrantyDate_Month_ID = document.getElementById('warrantyDate_Month_ID');
  var warrantyDate_Day_ID = document.getElementById('warrantyDate_Day_ID');
  var warrantyDate_Year_ID = document.getElementById('warrantyDate_Year_ID');
  warrantyDate_Month_ID.disabled = true;
  warrantyDate_Day_ID.disabled = true;
  warrantyDate_Year_ID.disabled = true;
}
</script>
	<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/asset/asset.php">
		<table>
          <tr>
            <td>
            <?php echo $orgOrDept;?> :
            <?php
            $organization = new Organization($asset->organizationId);
            echo $organization->name;
            if (($asset->assetId && $permission->hasPermission("Asset: Move")) && !$asset->isEwasted())
            {
             ?>
              <a href="/moveAsset/<?php echo $asset->assetId;?>">Move <?php echo $orgOrDept;?></a>
            <?php
            }
            CreateHiddenField("organizationId",$organization->organizationId);
             ?>

            </td>
            <td>&nbsp;
            </td>
          </tr>

		  <tr>
		    <td valign="top" >

		      <?php
		      if ($permission->hasPermission("Asset: Edit: Serial Number"))
		      {
		      	echo "Serial Number: ";
		        if ((strlen($asset->serialNumber) == 0) || (strtolower($asset->serialNumber) == "unknown") || (strtolower($asset->serialNumber) == "ordered") || $permission->hasPermission("Asset: Edit: Serial Number Override"))
		        {
		      	  CreateTextField("serialNumber",$asset->serialNumber,getFieldSize("asset","serialNumber"),"Asset Serial Number");
		        }
		        else
		        {
		      	  CreateHiddenField("serialNumber",$asset->serialNumber);
		      	  echo $asset->serialNumber;
		        }
		      }
		      else
		      {
		      	if ($permission->hasPermission("Asset: View: Serial Number"))
		      	{
		      		echo "Serial Number:".$asset->serialNumber;
		      	}
		      	CreateHiddenField("serialNumber",$asset->serialNumber);
		      }?>
		    </td>
		    <td>
		    <?php
		    if ($permission->hasPermission("Asset: Edit: Asset Tag"))
		    {
		    	?>
		    	Asset Tag: <?php CreateTextField("assetTag",$asset->assetTag,getFieldSize("asset","assetTag"),"Asset Tag");  ?>
		    	<?php
		    }
		    else
		    {
		    	if ($permission->hasPermission("Asset: View: Asset Tag"))
		    	{
		    		echo "Asset Tag: ".$asset->assetTag;
		    	}
		    	CreateHiddenField("assetTag",$asset->assetTag);
		    }
		    ?>
		    </td>
		  </tr>
			<tr>
				<td valign="top">
				<?php if ($permission->hasPermission("Asset: Edit: Asset Type"))
				{
					?>
					Asset Type:
				<select name="assetTypeId" id="assetTypeId">
				<?php
				if ($asset->assetTypeId==0)
				{
					?>
				    <option value="0">Select a Asset Type</option>
					<?php
				}
				?>
            <?php
            $assetType = new AssetType();
            $param = AddEscapedParam("selectable=1","organizationId", $asset->organizationId);
            $ok = $assetType->Get($param);
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
					if ($permission->hasPermission("Asset: View: Asset Type"))
					{
						echo "Asset Type: ".$assetType->name;
					}
					CreateHiddenField("assetTypeId",$asset->assetTypeId);
				}
				?>
				</td>
				<td>
				<?php if ($permission->hasPermission("Asset: Edit: MAC"))
				{
					?>
					MAC Address: <?php CreateTextField("macAddress",$asset->macAddress,getFieldSize("asset","macAddress"),"MAC Address, with or without colon");?>
					<?php
				}
				else
				{
					if ($permission->hasPermission("Asset: View: MAC"))
					{
						echo "MAC Address: ".$asset->macAddress;
					}
					CreateHiddenField("macAddress",$asset->macAddress);
				}
					?>
				</td>
			</tr>
			<tr>
			 <td>
			 <?php
			 if ($permission->hasPermission("Asset: Edit: Name"))
			 {
			 	?>
			 	Name: <?php CreateTextField("name",$asset->name,getFieldSize("asset","name"),"Name for asset");?>
			 	<?php
			 }
			 else
			 {
			 	if ($permission->hasPermission("Asset: View: Name"))
			 	{
			 		echo "Name: ".$asset->name;
			 	}
			 	CreateHiddenField("name",$asset->name);
			 }
			 ?>
			 </td>
			<td>
			<?php
			if ($permission->hasPermission("Asset: Edit: Employee"))
			{
				?>
				Employee Name: <?php CreateTextField("employeeName",$asset->employeeName,getFieldSize("asset","employeeName"),"Name of employee Asset is assigned");?>
				<?php
			}
			else
			{
				if ($permission->hasPermission("Asset: View: Employee"))
				{
					echo "Employee Name: ".$asset->employeeName;
				}
				CreateHiddenField("employeeName",$asset->employeeName);
			}
			?>
			 </td>
			</tr>

			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Make"))
			  {
			  	?>
			  	Make: <?php CreateTextField("make",$asset->make,getFieldSize("asset","make"),"Make of asset");?>
			  	<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Make"))
			  	{
			  		echo "Make: ".$asset->make;
			  	}
			  	CreateHiddenField("make",$asset->make);
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Model"))
			  {
			  	?>
			     Model: <?php CreateTextField("model",$asset->model,getFieldSize("asset","model"),"Model of asset");?>
			   <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Model"))
			  	{
			  		echo "Model: ".$asset->model;
			  	}
			  	CreateHiddenField("model",$asset->model);
			  }
			  ?>
			  </td>
			</tr>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Model Number"))
			  {
			  	?>
			     Model Number: <?php CreateTextField("modelNumber",$asset->modelNumber,getFieldSize("asset","modelNumber"),"Model Number of Asset");?>
			   <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Model Number"))
			  	{
			  		echo "Model Number: ".$asset->modelNumber;
			  	}
			  	CreateHiddenField("modelNumber",$asset->modelNumber);
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Condition"))
			  {
			  	?>
			  	Condition:
				<select name="assetConditionId" id="assetConditionId">
            <option value="0">Select Asset Condition</option>
            <?php
            //$condition = new AssetCondition();
            $condition = new ValidCondition();
            $param = AddEscapedParam("","currentassetConditionId",$asset->assetConditionId);
            $ok = $condition->Get($param);
            while ($ok)
            {
              $assetCondition = new AssetCondition($condition->assetConditionId);
            	$selected = "";
            	if ($assetCondition->assetConditionId == $asset->assetConditionId)
            	{
            		$selected = "selected='selected'";
            	}            	?>
            	<option value="<?php echo $assetCondition->assetConditionId;?>" <?php echo $selected;?>><?php echo $assetCondition->name;?></option>
            	<?php
            	$ok = $condition->Next();
            }
            ?>
          </select>
          <?php
				}
				else
				{
					if ($permission->hasPermission("Asset: View: Condition"))
					{
						$condition = new AssetCondition($asset->assetConditionId);
						echo $condition->name;
					}
					CreateHiddenField("assetConditionId",$asset->assetConditionId);
				}
				?>
			  </td>
			</tr>

			<tr>
				<td>
				<?php
				if ($permission->hasPermission("Asset: Edit: Building"))
				{
					?>
				Building:<select name="buildingId">
            <option value="0">Select a Building</option>
            <?php
            $building = new Building();
            $param = AddEscapedParam("","organizationId",$asset->organizationId);
            $ok = $building->Get($param);
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
					if ($permission->hasPermission("Asset: View: Building"))
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
				if ($permission->hasPermission("Asset: Edit: Building Location"))
				{
					?>
				Building Location: <?php CreateTextField("buildingLocation",$asset->buildingLocation,getFieldSize("asset","buildingLocation"),"Location of asset");?>
				<?php
				}
				else
				{
					if ($permission->hasPermission("Asset: View: Building Location"))
					{
						echo "Building Location: ".$asset->buildingLocation;
					}
					CreateHiddenField("buildingLocation",$asset->buildingLocation);
				}
				?>
				</td>
			</tr>
			<tr>
			  <td valign="top">
			  <?php
			  if ($permission->hasPermission("Asset: Edit: PO Number"))
			  {
			  	?>
			  	Purchase Order:
			  	<div class="poNumberWrapper">
			  	<select name="poNumberId" id="poNumberId">
			  	  <option value="0">Select a PO</option>
			  	  <?php
			  	  $poNumber = new PoNumber();
			  	  //$param = "organizationId=".$asset->organizationId." and (poType='Asset' or poType='AssetTicket')";
            $param = "(poType='Asset' or poType='AssetTicket')";
            $poNumber->SetOrderBy("poNumberId desc");
			  	  $ok = $poNumber->Get($param);
			  	  while ($ok)
			  	  {
			  	  	$selected = "";
			  	  	if ($poNumber->poNumberId == $asset->poNumberId)
			  	  	{
			  	  		$selected = "selected='selected'";
			  	  	}
			  	  	?>
			  	  	<option value="<?php echo $poNumber->poNumberId;?>" <?php echo $selected;?>><?php echo $poNumber->poNumber;?></option>
			  	  	<?php
			  	  	$ok = $poNumber->Next();
			  	  }
			  	  ?>
			  	</select>
			  	<div id="poNumberLink"></div>
			  	</div>
			  	<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: PO Number"))
			  	{
			  		$poNumber = new PoNumber($asset->poNumberId);
			  		echo "PO Number: ".$poNumber->poNumber;
			  	}
			  	CreateHiddenField("vendor",$asset->vendor);
			  }
			  ?>
			  </td>
			  <td valign="top">
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Vendor"))
			  {
			  	?>
			  	Vendor: <?php CreateTextField("vendor",$asset->vendor,getFieldSize("asset","vendor"),"Vendor Asset was purchased from");?>
			  	<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Vendor"))
			  	{
			  		echo "Vendor: ".$asset->vendor;
			  	}
			  	CreateHiddenField("vendor",$asset->vendor);
			  }
			  ?>
			  </td>
			</tr>
      <?php
      if ($permission->hasPermission("Asset: Edit: Price"))
      {
        ?>
        <tr>
          <td>
            Asset Cost:
            <?php
            if (!$asset->assetId)
            {
              CreateTextField("cost",$asset->purchasePrice,getFieldSize("asset","purchasePrice"),"Cost of the Asset");
            }
            else {
              echo $asset->purchasePrice;
              CreateHiddenField("cost",$asset->purchasePrice);
            }

             ?>
          </td>
          <td>
            &nbsp;
          </td>
        </tr>
        <?php
      }

       ?>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Warranty Date"))
			  {
			  DebugText("warrantyDate:".$asset->warrantyDate);
			  if (!strlen($asset->warrantyDate))
			  {
			  	$asset->warrantyDate = $oneYear;
			  }
			  ?>
  			   Warranty:
			   <script>DateInput('warrantyDate', true, 'YYYY/MM/DD','<?php echo $asset->warrantyDate;?>')</script>
			   <?php CreateCheckBox("enableWarranty",1,"Use Warranty Date",$enableWarranty,$title="Enable the Warranty Date Field","","onclick='toggle();'");?>
			   <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Warranty Date"))
			  	{
			  		echo "Warranty Date: ".$asset->warrantyDate;
			  	}
			  	CreateHiddenField("warrantyDate",$asset->warrantyDate);
			  }
			  ?>
			  </td>
			  <td valign="top">
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Aquire Date"))
			  {
			  	?>
			   Acquired:
			   <script>DateInput('aquireDate', true, 'YYYY/MM/DD','<?php echo $asset->aquireDate;?>')</script>
			   <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Aquire Date"))
			  	{
			  		echo "Acquired: ".$asset->aquireDate;
			  	}
			  	CreateHiddenField("aquireDate",$asset->aquireDate);
			  }
			  ?>
			  </td>
			</tr>
		</table>
		<?php
		if ($permission->hasPermission("Asset: Edit: Add Comment"))
		{
			?>
			    <textarea id="description" name="description" rows="5"  wrap="off"><?php echo $commentText;?></textarea>
<br>
               <?php
		}
		else
		{
			echo "<BR>";
		}

               PrintFormKey();
               CreateHiddenField("submitTest",1);
               CreateHiddenField("assetId",$asset->assetId);
               CreateHiddenField("type","Asset");
               if (($permission->hasPermission("Asset: Edit") || $permission->hasPermission("Asset: Edit: Add Comment")) && !$asset->isEwasted())
               {
               	CreateSubmit("Submit","Submit");
               }
               ?>
	</form>
	<?php
	$comment = new Comment();
	$ok = $comment->GetByAssetId($asset->assetId);
  DebugText("ok:".$ok);
  DebugText("Asset: View: View Comments:".$permission->hasPermission("Asset: View: View Comments"));
  DebugText("Asset: Edit: View Comments:".$permission->hasPermission("Asset: Edit: View Comments"));
	if ($ok && ($permission->hasPermission("Asset: Edit: View Comments") || $permission->hasPermission("Asset: View: View Comments")))
	{
		?><hr>
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
	}
	?>

<!--
<script type="text/javascript">
$(document).ready(function()
{

	var config = {
		skin:'v2',
		height: 500,
		toolbar:  [
['Source','DocProps'],
['Cut','Copy','Paste','PasteText','PasteFromWord','-',
'Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['SpellChecker','Scayt'],

'/',
['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','HorizontalRule'],
['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],['Link','Unlink','Maximize','ShowBlocks'] // No comma for the last row.
]
	};

 // alert('config editor');
	$('#description').ckeditor(config);
});
</script>
<script type="text/javascript">
//<![CDATA[
CKEDITOR.replace( 'description',
{
//extraPlugins : 'uicolor',
height: '200px',
} );
//]]>
</script>
-->
<?php
if (!$enableWarranty)
{
	?>
<script language="javascript">
disableWarrantyDate();
</script>
<?php
}
?>
