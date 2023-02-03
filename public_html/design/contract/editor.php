<?php
//
//  Tracker - Version 1.5.0
//
//  v1.5.0
//   - added code to handle edit vs view
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
include_once "tracker/organization.php";
include_once "tracker/poNumber.php";
$permission = new Permission();
$contractType = new AssetType();
$commentText = "";
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

?>
<script type="text/javascript">
adminFilePath="";
</script>

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

<script type="text/javascript" >
$(document).ready(function ()
{

	   $("#organizationId").change(function() {
		      link = "/ajax/controls/poNumber.php";
		      var formData = $(":input").serializeArray();
		      $.post(link, formData, function (theResponse) {
		        // Display Results.
		        $("#poNumberResults").html(theResponse);
		       });
		   });
		$("#organizationId").change();
});
</script>
    <?php
    if (isset($_SESSION['formErrors']))
    {
        if (strlen($_SESSION['formErrors']))
        {
        	DebugText("Using Session Data");

        	$contract->name = GetTextFromSession('contractName');
        	$contract->address1 = GetTextFromSession('contractAddress1');
        	$contract->address2 = GetTextFromSession('contractAddress2');
        	$contract->city = GetTextFromSession('contractCity');
        	$contract->state = GetTextFromSession('contractState');
        	$contract->zipCode = GetTextFromSession('contractZipCode');
        	$contract->phone = GetTextFromSession('contractPhone');
        	$contract->fax = GetTextFromSession('contractFax');
        	$contract->email = GetTextFromSession('contractEmail');
        	$contract->contactName = GetTextFromSession('contractContactName');
        	$contract->contactPhone = GetTextFromSession('contractContactPhone');
        	$contract->contactEmail = GetTextFromSession('contractContactEmail');
        	$contract->supportName = GetTextFromSession('contractSupportName');
        	$contract->supportPhone = GetTextFromSession('contractSupportPhone');
        	$contract->supportEmail = GetTextFromSession('contractSupportEmail');
        	$contract->contractNumber = GetTextFromSession('contractContractNumber');
        	$contract->expireDate = GetTextFromSession('contractExpireDate');
        	$contract->poNumberId = GetTextFromSession('contractpoNumberId',0);
        	$contract->organizationId = GetTextFromSession("organizationId",0);
					$contract->isLease = GetTextFromSession("contractIsLease",0);
        	$commentText = GetTextFromSession('contractComment');
            ?>
            <div class="feedback error">
            <?php
            echo $_SESSION['formErrors'];
            ?>
            </div>
            <?php
        }
    }
    $_SESSION['formErrors'] = "";
    ?>

	<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/contract/contract.php">
  <table class="width100">
   <tr>
     <td valign="top">
  <table class="width100">

    <?php
    if ($permission->hasPermission("Contract: Edit: Organization") || $permission->hasPermission("Contract: View: Organization"))
    {
    	?>
    <tr>
      <td>
      <?php echo $orgOrDept;?> :
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Organization"))
        {
					DebugText("contract->organizationId:".$contract->organizationId);
        	?>
        	<select name="organizationId" id="organizationId">
        	  <option value="0">Select <?php echo $orgOrDept;?></option>
        	<?php

        	$param = "organizationId in (".GetMyOrganizations().")";
        	$organization= new Organization();
        	$ok = $organization->Get($param);
        	while ($ok)
        	{
        		$selected = "";
        		if ($contract->organizationId == $organization->organizationId)
        		{
        			$selected = "selected='selected'";
        		}
        		?>
        		<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
        		<?php
        		$ok = $organization->Next();
        	}
        	?>
        	</select>
        	<?php
        }
        else
        {
        	$organization = new Organization($contract->organizationId);
        	echo $organization->name;
        }
        ?>
      </td>
      <td>&nbsp;
      </td>
      <td>&nbsp;
      </td>

    </tr>
    <?php
    }
    ?>
    <?php
    if ($permission->hasPermission("Contract: Edit: Name") || $permission->hasPermission("Contract: View: Name"))
    {
    	?>
    <tr>
      <td>Company Name:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Name"))
        {
        	CreateTextField("name",$contract->name,getFieldSize("contract","name"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: Name"))
        	{
        		echo $contract->name;
        	}
        		CreateHiddenField("name",$contract->name);
        }
        ?>
      </td>
      <td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("name",$contract->name);
    }
    if ($permission->hasPermission("Contract: Edit: Address 1") || $permission->hasPermission("Contract: View: Address 1"))
    {
    ?>
    <tr>
      <td>
      Address 1:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Address 1"))
        {
        	CreateTextField("address1",$contract->address1,getFieldSize("contract","address1"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: Address 1"))
        	{
        		echo $contract->address1;
        	}
       		CreateHiddenField("address1",$contract->address1);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("address1",$contract->address1);
    }
    if ($permission->hasPermission("Contract: Edit: Address 2") || $permission->hasPermission("Contract: View: Address 2"))
    {
    ?>
    <tr>
      <td>
      Address 2:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Address 2"))
        {
        	CreateTextField("address2",$contract->address2,getFieldSize("contract","address2"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: Address 2"))
        	{
        		echo $contract->address2;
        	}
        	CreateHiddenField("address2",$contract->address2);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("address2",$contract->address2);
    }
    if ($permission->hasPermission("Contract: Edit: City") || $permission->hasPermission("Contract: View: City"))
    {
    ?>
    <tr>
      <td>
      City:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: City"))
        {
        	CreateTextField("city",$contract->city,getFieldSize("contract","city"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: City"))
        	{
        		echo $contract->city;
        	}
        	CreateHiddenField("city",$contract->city);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("city",$contract->city);
    }
    if ($permission->hasPermission("Contract: Edit: State") || $permission->hasPermission("Contract: View: State"))
    {
    ?>
    <tr>
      <td>
      State:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: State"))
        {
        	CreateTextField("state",$contract->state,getFieldSize("contract","state"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: State"))
        	{
        		echo $contract->state;
        	}
        	CreateHiddenField("state",$contract->state);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("state",$contract->state);
    }
    if ($permission->hasPermission("Contract: Edit: Zip") || $permission->hasPermission("Contract: View: Zip"))
    {
    ?>
    <tr>
      <td>
      Zip:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Zip"))
        {
        	CreateTextField("zip",$contract->zipCode,getFieldSize("contract","zipCode"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: Zip"))
        	{
        		echo $contract->zipCode;
        	}
        	CreateHiddenField("zip",$contract->zipCode);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("zip",$contract->zipCode);
    }
    if ($permission->hasPermission("Contract: Edit: Phone") || $permission->hasPermission("Contract: View: Phone"))
    {
    ?>
    <tr>
      <td>
      Phone:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Phone"))
        {
        	CreateTextField("phone",$contract->phone,getFieldSize("contract","phone"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: Phone"))
        	{
        		echo $contract->phone;
        	}
        	CreateHiddenField("phone",$contract->phone);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("phone",$contract->phone);
    }
    if ($permission->hasPermission("Contract: Edit: Fax") || $permission->hasPermission("Contract: View: Fax"))
    {
    ?>
    <tr>
      <td>
      Fax:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Fax"))
        {
        	CreateTextField("fax",$contract->fax,getFieldSize("contract","fax"));
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: Fax"))
        	{
        		echo $contract->fax;
        	}
        	CreateHiddenField("fax",$contract->fax);
        }
        ?>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("fax",$contract->fax);
    }
    if ($permission->hasPermission("Contract: Edit: Po Number") || $permission->hasPermission("Contract: View: PO Number"))
    {
    ?>
    <tr>
      <td>
      PO Number: <?php CreateHiddenField("hideLabel",1);?>
      </td>
      <td>
       <div id="poNumberResults"></div>
      </td>
    </tr>
    <?php
    }
    else
    {
    	CreateHiddenField("poNumberId",$contract->poNumberId);
    }
    ?>
    <tr>
      <td>&nbsp;
      <?php CreateHiddenField("type","Contract");?>
      <input type="hidden" value="1" name="submitTest">
      <input type="hidden" name="contractId" value="<?php echo $contract->contractId;?>"/>
      <input type="hidden" name="formKey" value="<?php echo getFormKey();?>" />
      </td>
      <td>
&nbsp;
      </td>
    </tr>
  </table>
    </td>
    <td valign="top">
    <?php
    if ($permission->hasPermission("Contract: Edit: Contract Number") ||
        $permission->hasPermission("Contract: Edit: Expire Date") ||
        $permission->hasPermission("Contract: View: Contract Number") ||
        $permission->hasPermission("Contract: View: Expire Date"))
    {
    	?>
      <fieldset>
        <legend>Contract</legend>
        <table class="width100">
          <tr>
            <td>
              Contract Number: <?php
              if ($permission->hasPermission("Contract: Edit: Contract Number"))
              {
               CreateTextField("contractNumber",$contract->contractNumber,getFieldSize("contract","contractNumber"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Contract Number"))
              	{
              		echo $contract->contractNumber;
              	}
              	CreateHiddenField("contractNumber",$contract->contractNumber);
              }
              ?>
            </td>
          </tr>
          <tr>
            <td>
              Expire Date: <?php
              if ($permission->hasPermission("Contract: Edit: Expire Date"))
              {
              	CreateDatePicker("expireDate",$contract->expireDate);
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Expire Date"))
              	{
              		echo $contract->expireDate;
              	}
              	CreateHiddenField("expireDate",$contract->expireDate);
              }?>
            </td>
          </tr>
					<tr>
						<td>
							Lease: <?php
							        if ($permission->hasPermission("Contract: Edit"))
											{
												CreateCheckBox("isLease",1,"",$contract->isLease);
											}
											else {
												if ($contract->isLease)
												{
													echo "Yes";
												}
												else {
													echo "No";
												}
											}
											?>
						</td>
					</tr>
        </table>
      </fieldset>
     <?php
    }
    else
    {
    	CreateHiddenField("contractNumber",$contract->contractNumber);
    	CreateHiddenField("expireDate",$contract->expireDate);
    }
    if ($permission->hasPermission("Contract: Edit: Contact Name") ||
        $permission->hasPermission("Contract: Edit: Contact Phone") ||
        $permission->hasPermission("Contract: Edit: Contact Email") ||
        $permission->hasPermission("Contract: View: Contact Name") ||
        $permission->hasPermission("Contract: View: Contact Phone") ||
        $permission->hasPermission("Contract: View: Contact Email") )
    {
    ?>
      <fieldset>
        <legend>Contact Info</legend>
        <table class="width100">
          <tr>
            <td>
              Name: <?php
              if ($permission->hasPermission("Contract: Edit: Contact Name"))
              {
              	CreateTextField("contactName",$contract->contactName,getFieldSize("contract","contactName"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Contract Name"))
              	{
              		echo $contract->contactName;
              	}
              	CreateHiddenField("contactName",$contract->contactName);
              }?>
            </td>
          </tr>
          <tr>
            <td>
              Phone: <?php
              if ($permission->hasPermission("Contract: Edit: Contact Phone"))
              {
              	CreateTextField("contactPhone",$contract->contactPhone,getFieldSize("contract","contactPhone"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Contact Phone"))
              	{
              		echo $contract->contactPhone;
              	}
              	CreateHiddenField("contactPhone",$contract->contactPhone);
              }
              ?>
            </td>
          </tr>
          <tr>
            <td>
              Email: <?php
              if ($permission->hasPermission("Contract: Edit: Contact Email"))
              {
              	CreateTextField("contactEmail",$contract->contactEmail,getFieldSize("contract","contactEmail"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Contract Email"))
              	{
              		echo $contract->contactEmail;
              	}
              	CreateHiddenField("contactEmail",$contract->contactEmail);
              }?>
            </td>
          </tr>
        </table>
      </fieldset>
      <?php
    }
    else
    {
    	CreateHiddenField("contactName",$contract->contactName);
    	CreateHiddenField("contactEmail",$contract->contactEmail);
    	CreateHiddenField("contactPhone",$contract->contactPhone);
    }
    if ($permission->hasPermission("Contract: Edit: Support Name") ||
        $permission->hasPermission("Contract: Edit: Support Phone") ||
        $permission->hasPermission("Contract: Edit: Support Email") ||
        $permission->hasPermission("Contract: View: Support Name") ||
        $permission->hasPermission("Contract: View: Support Phone") ||
        $permission->hasPermission("Contract: View: Support Email") )
    {
    ?>
      <fieldset>
        <legend>Support Info</legend>
        <table class="width100">
          <tr>
            <td>
              Name: <?php
              if ($permission->hasPermission("Contract: Edit: Support Name"))
              {
              	CreateTextField("supportName",$contract->supportName,getFieldSize("contract","supportName"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Support Name"))
              	{
              		echo $contract->supportName;
              	}
              	CreateHiddenField("supportName",$contract->supportName);
              }?>
            </td>
          </tr>
          <tr>
            <td>
              Phone: <?php
              if ($permission->hasPermission("Contract: Edit: Support Phone"))
              {
              	CreateTextField("supportPhone",$contract->supportPhone,getFieldSize("contract","supportPhone"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Support Phone"))
              	{
              		echo $contract->supportPhone;
              	}
              	CreateHiddenField("supportPhone",$contract->supportPhone);
              }?>
            </td>
          </tr>
          <tr>
            <td>
              Email: <?php
              if ($permission->hasPermission("Contract: Edit: Support Email"))
              {
              	CreateTextField("supportEmail",$contract->supportEmail,getFieldSize("contract","supportEmail"));
              }
              else
              {
              	if ($permission->hasPermission("Contract: View: Support Email"))
              	{
              		echo $contract->supportEmail;
              	}
              	CreateHiddenField("supportEmail",$contract->supportEmail);
              }?>
            </td>
          </tr>
        </table>
      </fieldset>
      <?php
    }
    else
    {
    	CreateHiddenField("supportName",$contract->supportName);
    	CreateHiddenField("supportEmail",$contract->supportEmail);
    	CreateHiddenField("supportPhone",$contract->supportPhone);
    }
    ?>
    </td>
  </tr>
  </table>
  <?php
  if ($permission->hasPermission("Contract: Add Comment"))
  {
  	?>
  Comment:
			    <textarea id="description" name="description" rows="5"  wrap="off"></textarea>
    <?php
  }
	CreateHiddenField("type","contract");
  //CreateHiddenField("poNumberId",$contract->poNumberId);
  ?>
<br>
 <?php
	 PrintFormKey();
	 CreateHiddenField("submitTest",1);
	 if ($permission->hasPermission("Asset: Edit Spec"))
	 {
		 CreateSubmit("submit",$button);
	 }
 ?>
	</form>


	<?php
	$comment = new Comment();

	$ok = $comment->GetByContractId($contract->contractId);

	if ($ok && $permission->hasPermission("Contract: View Comments"))
	{
		?><hr>
		<?php
	}
	?>
	<table>
	<?php
	while ($ok)
	{
		$user = new User($comment->userId);
		?>
		<tr>
		  <td><?php echo $user->fullName." on ".$comment->posted;?>
		  </td>
		</tr>
		<tr>
		  <td>
				<hr/>
		  <?php echo $comment->comment;?>
		  </td>
		</tr>
		<?php
		$ok = $comment->Next();
	}
	?>
	</table>
