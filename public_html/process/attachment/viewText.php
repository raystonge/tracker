<?php
include_once "globals.php";
include_once "tracker/attachment.php";
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
$fname = $attachment->attachmentPath();
//echo $fname."|<br>";
if (($fh = fopen($fname,"r")) == null)
{
	exit;
}
fclose($fh);
echo "<pre>";
echo file_get_contents($attachment->attachmentPath());
echo "</pre>";
?>