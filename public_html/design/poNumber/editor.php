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
<?php
include_once "tracker/organization.php";
include_once "tracker/comment.php";
$commentText = "";
?>
<?php
DebugText("po organizationId:".$poNumber->organizationId);
DebugText("po date:".$poNumber->poDate);
 ?>
    <?php
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }
    $revieved = 0;
    if (strlen($poNumber->receivedDate))
    {
      $received = 1;
    }

    if (FormErrors())
    {
       	$poNumber->poNumber = GetTextFromSession('poNumberpoNumber');
       	$poNumber->vendor = GetTextFromSession('poNumberVendor');
       	$poNumber->description = GetTextFromSession('poNumberDescription');
       	$poNumber->poDate = GetTextFromSession('poNumberpoDate');
       	$poNumber->poType = GetTextFromSession("poNumberpoType");
       	$poNumber->organizationId = GetTextFromSession("poNumberOrganizationId");
       	$poNumber->cost = GetTextFromSession("poNumberCost");
       	$poNumber->reconciled = GetTextFromSession("poNumberReconciled",0);
        $poNumber->received = GetTextFromSession("poNumberReceived");
        $poNumber->vendorOrderID = GetTextFromSession("poNumberVendorOrderID");
        $commentText = GetTextFromSession("poNumberComment");
       	DisplayFormErrors();
    }
    DebugText("po organizationId:".$poNumber->organizationId);
    ?>

	<form method="post" autocomplete="<?php echo $autoComplete;?>"  action="/process/poNumber/poNumber.php">
	   <table>
    <?php
    if ($permission->hasPermission("Contract: Edit: Organization") || $permission->hasPermission("Contract: View: Organization"))
    {
    	?>
    <tr>
      <td>
      <?php echo $orgOrDept;?>:
      </td>
      <td>
        <?php
        if ($permission->hasPermission("Contract: Edit: Organization"))
        {
        	?>
        	<select name="organizationId">
        	  <option value="0">Select <?php echo $orgOrDept;?></option>
        	<?php

        	$param = "organizationId in (".GetMyOrganizations().")";
        	$organization= new Organization();
        	$ok = $organization->Get($param);
        	while ($ok)
        	{
        	  DebugText("po organizationId:".$poNumber->organizationId);
            DebugText("organization organizationId:".$organization->organizationId);
        		$selected = "";
        		if ($poNumber->organizationId == $organization->organizationId)
        		{
        			$selected = "selected='selected'";
        			DebugText("found match");
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
	     if ($permission->hasPermission("poNumber: Edit: PO Number"))
	     {
	     	?>
	     <tr>
	       <td>
	       PO Number:
	       </td>
	       <td>
	         <?php CreateTextField("poNumber",$poNumber->poNumber,getFieldSize("poNumber","poNumber"),"PO Number");?>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Number"))
	     	{
	     	?>
	     <tr>
	       <td>
	       PO Number:
	       </td>
	       <td>
	         <?php echo $poNumber->poNumber;
	         CreateHiddenField("poNumber",$poNumber->poNumber);
	         ?>
	       </td>
	     </tr>
	     	<?php
	     	}
	     	else
	     	{
	     		CreateHiddenField("poNumber",$poNumber->poNumber);
	     	}
	     }
	     ?>
       <?php
	     if ($permission->hasPermission("poNumber: Edit: PO Vendor"))
	     {
	     	?>
	     <tr>
	       <td>
	       Vendor:
	       </td>
	       <td>
	         <?php CreateTextField("vendor",$poNumber->vendor,getFieldSize("poNumber","vendor"),"Vendor of PO");?>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Vendor"))
	     	{
	     		echo $poNumber->vendor;
	     		CreateHiddenField("vendor",$poNumber->vendor);
	     	}
	     	CreateHiddenField("vendor",$poNumber->vendor);
	     }
	     ?>
       <?php
	     if ($permission->hasPermission("poNumber: Edit: PO Vendor Order ID"))
	     {
	     	?>
	     <tr>
	       <td>
	       Vendor Order ID:
	       </td>
	       <td>
	         <?php CreateTextField("vendorOrderID",$poNumber->vendorOrderID,getFieldSize("poNumber","vendorOrderID"),"Vendor Order ID for the PO");?>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Vendor Order ID"))
	     	{
	     		echo $poNumber->vendorOrderID;
	     		CreateHiddenField("vendor",$poNumber->vendorOrderID);
	     	}
	     	CreateHiddenField("vendor",$poNumber->vendorOrderID);
	     }
	     ?>




	     <?php
	     if ($permission->hasPermission("poNumber: Edit: PO Date"))
	     {
	     	?>
	     <tr>
	       <td>
	         Date :
	       </td>
	       <td>
           <?php
           CreateDatePicker("poDate",$poNumber->poDate);
            ?>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Date"))
	     	{
	     		?>
	     <tr>
	       <td>
	         Date :
	       </td>
	       <td>
	       <?php
	       echo $poNumber->poDate;
	       CreateHiddenField("poDate",$poNumber->poDate);
	       ?>
	       </td>
	     </tr>
	     		<?php
	     	}
	     	else
	     	{
	     		CreateHiddenField("poDate",$poNumber->poDate);
	     	}

	     }
	     ?>
	     <?php
	     if ($permission->hasPermission("poNumber: Edit: PO Type"))
	     {
	     	?>
	     <tr>
	       <td>
	       Type:
	       </td>
	       <td>
	         <select name="poType" id="poType">
	           <option value="">Select PO Type</option>
	           <option value="Asset" <?php if ($poNumber->poType == "Asset"){echo "selected='selected'";}?>>Asset</option>
	           <option value="Contract" <?php if ($poNumber->poType == "Contract"){echo "selected='selected'";}?>>Contract</option>
	           <option value="Ticket" <?php if ($poNumber->poType == "Ticket"){echo "selected='selected'";}?>>Ticket</option>
             <option value="AssetTicket" <?php if ($poNumber->poType == "AssetTicket"){echo "selected='selected'";}?>>Asset/Ticket</option>
	         </select>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Type"))
	     	{
	     		?>
	     <tr>
	       <td>
	       Type:
	       </td>
	       <td>
	         <?php echo $poNumber->poType;
	         CreateHiddenField("poType",$poNumber->poType);
	         ?>
	       </td>
	     </tr>
	     <?php
	     	}
	     	else
	     	{
	     		CreateHiddenField("poType",$poNumber->poType);
	     	}

	     }
	     ?>
	     <?php
	     if ($permission->hasPermission("poNumber: Edit: PO Desc"))
	     {
	     	?>
	     <tr>
	       <td>
	       Description:
	       </td>
	       <td>
	         <?php CreateTextField("description",$poNumber->description,getFieldSize("poNumber","description"),"Description of PO");?>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Desc"))
	     	{
	     		echo $poNumber->description;
	     		CreateHiddenField("description",$poNumber->description);
	     	}
	     	CreateHiddenField("description",$poNumber->description);
	     }
	     ?>
	     <?php
	     if ($permission->hasPermission("poNumber: Edit: PO Cost"))
	     {
	     	?>
	     <tr>
	       <td>
	       Cost:
	       </td>
	       <td>
	         <?php CreateTextField("cost",$poNumber->cost,getFieldSize("poNumber","cost"),"Total Cost of PO");?>
	       </td>
	     </tr>
	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Cost"))
	     	{
	     		echo $poNumber->cost;

	     	}
	     	CreateHiddenField("cost",$poNumber->cost);
	     }
	     ?>

       <?php
	     if ($poNumber->poNumberId && $permission->hasPermission("poNumber: Edit: PO Received"))
	     {
	     	?>
	     <tr>
	       <td>
	       Recevied:
	       </td>
	       <td>
	       <?php
	          CreateCheckBox("received",$poNumber->poNumberId, "",$poNumber->received,"Click to reconcile PO","toReconcilePO");
	       ?>

	       </td>
	     </tr>
	     <?php
	     if ($poNumber->received)
	     {
	     ?>
	     <tr>
	       <td>
	         By:
	       </td>
	       <td>
	         <?php
	           $user = new User($poNumber->receivedUserId);
	           echo $user->fullName;
	         ?>
	       </td>
	     </tr>
	     <tr>
	       <td>
	         On:
	       </td>
	       <td>
	         <?php
	           echo $poNumber->receivedDate;
	         ?>
	       </td>
	     </tr>
	     <?php
	     }?>

	     <?php
	     }
	     else
	     {
	     	if ($poNumber->poNumberId && $permission->hasPermission("poNumber: View: PO Received"))
	     	{
	     		if ($poNumber->reconciled)
	     		{
	     			echo "Reconciled";
	     		}
	     		else
	     		{
	     			echo "Not reconciled";
	     		}
	     	}
	     	CreateHiddenField("reconciled",$poNumber->received);
	     }
	     ?>

	     <?php
	     if ($poNumber->poNumberId && $permission->hasPermission("poNumber: Edit: PO Reconcile"))
	     {
	     	?>
	     <tr>
	       <td>
	       Reconcile:
	       </td>
	       <td>
	       <?php
	          CreateCheckBox("reconciled",$poNumber->poNumberId, "",$poNumber->reconciled,"Click to reconcile PO","toReconcilePO");
	       ?>

	       </td>
	     </tr>
	     <?php
	     if ($poNumber->poNumberId && $poNumber->reconciled)
	     {
	     ?>
	     <tr>
	       <td>
	         By:
	       </td>
	       <td>
	         <?php
	           $user = new User($poNumber->reconciledUserId);
	           echo $user->fullName;
	         ?>
	       </td>
	     </tr>
	     <tr>
	       <td>
	         On:
	       </td>
	       <td>
	         <?php
	           echo $poNumber->reconciledDateTime;
	         ?>
	       </td>
	     </tr>
	     <?php
	     }?>

	     <?php
	     }
	     else
	     {
	     	if ($permission->hasPermission("poNumber: View: PO Reconciled"))
	     	{
	     		if ($poNumber->reconciled)
	     		{
	     			echo "Reconciled";
	     		}
	     		else
	     		{
	     			echo "Not reconciled";
	     		}
	     	}
	     	CreateHiddenField("reconciled",$poNumber->reconciled);
	     }
	     ?>


	     <tr>
	       <td>
	       <?php
	       if ($permission->hasPermission("poNumber: Edit: PO Number") ||
	           $permission->hasPermission("poNumber: Edit: PO Date") ||
	           $permission->hasPermission("poNumber: Edit: PO Type") ||
	           $permission->hasPermission("poNumber: Edit: PO Desc")
	       )
	       {
	       	CreateSubmit();
	       }
	       ?>
	       </td>
	       <td>
	       &nbsp;
         <?php
     		if ($permission->hasPermission("poNumber: Edit: Add Comment"))
     		{
     			?>
     			    <textarea id="comment" name="comment" rows="5"  wrap="off"><?php echo $commentText;?></textarea>
     <br>
                    <?php
     		}
     		else
     		{
     			echo "<BR>";
     		}

         CreateHiddenField("poNumberId",$poNumber->poNumberId);
	       CreateHiddenField("submitTest",1);
	       PrintFormKey();
	       ?>
	     </tr>

	   </table>

    </form>

    <?php
    $comment = new Comment();
    $ok = $comment->GetByPoNumberId($poNumber->poNumberId);
    if ($ok && ($permission->hasPermission("poNumber: Edit: View Comments") || $permission->hasPermission("poNumber: View: View Comments")))
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
