<?php
include_once "tracker/queue.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: Queue");
$queue = new Queue();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

include $sitePath."/design/editors/queue.php";
?>