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
<?php
include_once "tracker/poNumber.php";
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}
include_once "tracker/asset.php";
$asset = new Asset($assetId);
$button = "Create";
if (FormErrors())
{
	DisplayFormErrors();
	$asset->purchasePrice = GetTextFromSession("purchasePrice",0);
}
if (FormSuccess())
{
	DisplayFormSuccess();
}

include $sitePath."/design/asset/assetInfoHeader.php";
?>
<div class="adminArea">
  <div id='main_column'>
    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/asset/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>

  <div class="clear"></div>
  <form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/asset/assetValue.php">
    <table class="width100">
			<tr>
			  <td valign="top">
			  <?php
			  if ($permission->hasPermission("Asset: Edit: PO Number"))
			  {
			  	?>
			  	Purchase Order:
			  	</td>
			  	<td>
			  	<div >
			  	<select name="poNumberId" id="poNumberId">
			  	  <option value="0">Select a PO</option>
			  	  <?php
			  	  $poNumber = new PoNumber();
			  	  $param = "organizationId=".$asset->organizationId." and poType='Asset'";
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
			</tr>
            <tr>
			  <td valign="top">
			  <?php
			  if ($permission->hasPermission("Asset: Edit: Vendor"))
			  {
			  	?>
			  	Vendor: </td><td> <?php CreateTextField("vendor",$asset->vendor,getFieldSize("asset","vendor"),"Vendor Asset was purchased from");?>
			  	<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Asset: View: Vendor"))
			  	{
			  		echo "Vendor: </td><td> ".$asset->vendor;
			  	}
			  	CreateHiddenField("vendor",$asset->vendor);
			  }
			  ?>
			  </td>
			</tr>

     <?php
      if ($permission->hasPermission("Asset: Edit: Purchase Price") ||$permission->hasPermission("Asset: View: Purchase Price"))
      {
     ?>
      <tr>
        <td>
          Cost:
        </td>
        <td>
          <?php
          if ($permission->hasPermission("Asset: Edit: Purchase Price"))
          {
          	CreateTextField("purchasePrice",$asset->purchasePrice);
          }
          else
          {
          	echo $asset->purchasePrice;
          }?>
        </td>
      </tr>
      <?php
      }
      ?>
     <?php
      if ($permission->hasPermission("Asset: Edit: Taxable") ||$permission->hasPermission("Asset: View: Taxable"))
      {
     ?>
      <tr>
        <td>
          Taxable:
        </td>
        <td>
          <?php
          if ($permission->hasPermission("Asset: Edit: Taxable"))
          {
          	CreateCheckBox("taxable", $asset->taxable);
          }
          else
          {
          	if ($asset->taxable)
          	{
          		echo "Yes";
          	}
          	else
          	{
          		echo "No";
          	}
          }?>
        </td>
      </tr>
      <?php
      }
      ?>

     <?php
      if ($permission->hasPermission("Asset: Edit: Sold") ||$permission->hasPermission("Asset: View: Sold"))
      {
     ?>
      <tr>
        <td>
          Sold:
        </td>
        <td>
          <?php
          if ($permission->hasPermission("Asset: Edit: Sold"))
          {
          	CreateCheckBox("Sold", $asset->sold);
          }
          else
          {
          	if ($asset->sold)
          	{
          		echo "Yes";
          	}
          	else
          	{
          		echo "No";
          	}
          }?>
        </td>
      </tr>
      <?php
      }
      ?>
     <?php
      if ($permission->hasPermission("Asset: Edit: Sold To") ||$permission->hasPermission("Asset: View: Sold To"))
      {
     ?>

      <tr id="showSoldInfo">
        <td>
          Sold To:
        </td>
        <td>
          <?php
          if ($permission->hasPermission("Asset: Edit: Sold TO"))
          {
          	CreateTextField("Sold", $asset->soldTo);
          }
          else
          {
          	echo $asset->soldTo;
          }?>
        </td>
      </tr>
      <?php
      }
      ?>

     <?php
      if ($permission->hasPermission("Asset: Edit: Sold Price") ||$permission->hasPermission("Asset: View: Sold Price"))
      {
     ?>
      <tr>
        <td>
          Sold Price:
        </td>
        <td>
          <?php
          if ($permission->hasPermission("Asset: Edit: Price"))
          {
          	CreateTextField("soldPrice",$asset->soldPrice);
          }
          else
          {
          	echo $asset->soldPrice;
          }?>
        </td>
      </tr>
      <?php
      }
      ?>
     <?php
      if ($permission->hasPermission("Asset: Edit: Sold Date") ||$permission->hasPermission("Asset: View: Sold Date"))
      {
     ?>
      <tr>
        <td>
          Sold Date:
        </td>
        <td>
          <?php
          if ($permission->hasPermission("Asset: Edit: Sold Date"))
          {
          	//CreateDateField("soldDate",$asset->soldDate);
						CreateDatePicker("soldDate",$asset->soldDate);
          }
          else
          {
          	echo $asset->soldDate;
          }?>
        </td>
      </tr>
      <?php
      }
      ?>
      <tr>
        <td>&nbsp;
        <?php
        CreateHiddenField("submitTest",1);
        CreateHiddenField("assetId",$asset->assetId);
        PrintFormKey();
        ?>
        </td>
      <td>
        <?php
        if ($asset->assetConditionId != 8)
        {
         ?>
          <input type="submit" name="submit" value="Update"/>
        <?php
        }
        else {
          PrintNBSP();
        } ?>
      </td>
    </tr>

    </table>
  </form>

</div>
</div>
