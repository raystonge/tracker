<?php
include_once "tracker/permission.php";
include_once "tracker/queue.php";
$button = "Create";
$queueId = 0;
$formKey = "";
PageAccess("Config: Queue");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$queueId = $request_uri[2];
		DebugText("using param 2:".$queueId);
	}
}
$queue = new Queue($queueId);
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
if ($queue->queueId)
{
	$button = "Update";
}

include $sitePath."/design/editors/queue.php";
?>