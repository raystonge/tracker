<?php
//
//  Tracker - Version 1.7.1
//
//  v1.7.1
//   - fixing issue with wrong attachment file being included
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
include_once "tracker/attachment.php";
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
$linkName = "";
$link = "";
?>
<script language="javascript">
$(document).ready(function ()
{
	 var showingURL;
	 $(document).on('click', '#addUrl', function ()
        {
        	showingURL = !showingURL;
        	if (showingURL)
        	{
        		showURL();
        	}
        	else
        	{
        		hideURL();
        	}

        });
     function showURL()
     {
        	$('#fileAttachment').attr("class","hidden");
        	$('#urlAttachment').attr("class","showEdit");
     }
     function hideURL()
     {
        	$('#fileAttachment').attr("class","showEdit");
        	$('#urlAttachment').attr("class","hidden");

     }
     hideURL();
})
</script>
<?php
if ($permission->hasPermission("Ticket: Add Attachment"))
{
	?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/ticket/attachment.php">
<table>
  <tr id="fileAttachment">
    <td>
Attachment: </td>
<td><?php CreateFileField("attachment","Select file to Upload");?>

</td>
</tr>
  <tr>
    <td>
      <?php CreateCheckBox("addUrl",1,"Attach URL");?>
    </td>
    <td>
    &nbsp;
    </td>
  </tr>
  <tr id="urlAttachment">
    <td>Link Name: <?php CreateTextField("linkName",$linkName);?>
    </td>
    <td>Link: <?php CreateTextField("link",$link);?>
    </td>
  </tr>
</table>
			    <?php
			    PrintFormKey();
			    CreateHiddenField("submitTest",1);
			    CreateHiddenField("ticketId",$ticket->ticketId);
			    CreateSubmit("Submit");
			    ?>
</form>
	<?php
}
?>
<?php
if ($permission->hasPermission("Ticket: View Attachments"))
{
	?>
<table class="width100">
<?php
$type = "Ticket";
$attachment = new Attachment();
$param = AddEscapedParam("","ticketId",$ticket->ticketId);
$ok = $attachment->Get($param);
$type="Asset";
while ($ok)
{
	$attachmentViewer = $attachment->attachmentViewer();
	?>
	<tr class="mritem">
	  <td>
	<a href="<?php echo $attachmentViewer;?>" target="_blank"><?php echo $attachment->originalName;?></a>
	  </td>
	  <td>
	  <?php echo $attachment->uploadDate;?>
	  </td>
	  <td>
	  			<?php
			include $sitePath."/design/actions/ticketAttachment.php";
			echo $htmlAction;
			?>
	  </td>
	 </tr>
	<?php
	$ok = $attachment->Next();
}

?>
</table>
<?php
}
?>

<?php
if ($ticket->poNumberId && $permission->hasPermission("poNumber: View Attachments"))
{
	$po = new poNumber($ticket->poNumberId);
	echo "PO Number:".$po->poNumber;
	?>
	<table class="width100">
<?php
$type = "PO";
$attachment = new Attachment();
$param = AddEscapedParam("","poNumberId",$ticket->poNumberId);
$ok = $attachment->Get($param);
while ($ok)
{
	$attachmentViewer = $attachment->attachmentViewer();
	?>
	<tr class="mritem">
	  <td>
	<a href="<?php echo $attachmentViewer;?>" target="_blank"><?php echo $attachment->originalName;?></a>
	  </td>
	  <td>
	  <?php echo $attachment->uploadDate;?>
	  </td>
	  <td>
&nbsp;	  </td>
	 </tr>
	<?php
	$ok = $attachment->Next();
}

?>
</table>
	<?php
}
?>
