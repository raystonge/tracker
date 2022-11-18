<?php
/*
 * Created on Jan 23, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<script type="text/javascript">
$(document).ready(function () {
	url = '<?php echo $url;?>';
	$("#yes").click(function () {
        link = "/process/attachment/delete.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData), function (theResponse) {
        }
	document.location.href=url;
	});
	$("#no").click(function () {
		document.location.href=url;
	});
	
	
});
</script>
<form method="post" >
<p>Are you sure you want to delete <?php echo $attachment->originalName;?>?
</p>
<?php CreateHiddenField("attachmentId",$attachment->attachmentId);?>
<?php CreateYesNo();?>
</form>