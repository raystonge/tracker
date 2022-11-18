<?php
include_once "tracker/control.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: Controls");
$control = new Control();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}

?>
<!--
<script
	language="javascript"
	src="/js/listControls-jquery.js"></script>
	-->
<?php include $sitePath.$designPath."/editors/control.php";?>
