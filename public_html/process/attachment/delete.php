<?php
/*
 * Created on Jan 23, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/attachment.php";
ProperAccessValidate();
$attachmentId = GetTextField("attachmentId",0);
$attachment = new Attachment($attachmentId);
if ($attachment->attachmentId)
{
	$attachment->Delete();
}
?>
