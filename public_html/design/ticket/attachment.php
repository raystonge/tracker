<?php
/*
 * Created on Jul 28, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
			include $sitePath."/design/actions/attachment.php";
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
