<?php
/*
 * Created on Oct 29, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once 'globals.php';
include_once 'tracker/asset.php';
include_once 'tracker/ticket.php';
include_once 'tracker/attachment.php';
include_once "tracker/mimeType.php";
$assetId=0;
$postId=0;
$mm_type="";
$userId = 0;
$sessionUserId = "userId";
if(isset($_SESSION[$sessionUserId]))
{
	$userId = $_SESSION[$sessionUserId];
}
$currentUser = new User($userId);
if (!$currentUser->userId)
{
	exit;
}
$attachmentId = 0;
if (isset($_GET['id']))
{
   $attachmentId = $_GET['id'];
}
if ($attachmentId==0)
{
	exit;
}
$attachment = new Attachment($attachmentId);
if ($attachment->attachmentId==0)
{
	exit;
}

$mimeType = new MimeType($attachment->mimeTypeId);
$path = $attachment->attachmentPath();
$mm_type=$mimeType->mimeType; // modify accordingly to the file type of $path, but in most cases no need to do so
$id = 0;
$type = "";
if ($attachment->assetId)
{
	$type = "asset";
	$id = $attachment->assetId;
}
else
{
	$type = "ticket";
	$id = $attachment->ticketId;
}
?>
<img src="/attachments/<?php echo $type;?>/<?php echo $id;?>/<?php echo $attachment->originalName;?>"/>