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
include_once "tracker/attachment.php";
include_once "tracker/poNumber.php";
$type = "Contract";
$formKey = getFormKey();
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
if ($permission->hasPermission("poNumber: Add Attachment"))
{
	?>

<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/poNumber/attachment.php">
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
CreateHiddenField("submitText",1);
CreateHiddenField("poNumberId",$poNumber->poNumberId);
CreateSubmit("Submit","Submit");
?>
</form>
	<?php
}
?>
<?php
if ($permission->hasPermission("poNumber: View Attachments"))
{
	?>
<table class="width100">
<?php
$attachment = new Attachment();
$param = AddEscapedParam("","poNumberId",$poNumber->poNumberId);
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
