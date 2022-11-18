<?php
include_once "tracker/control.php";
include_once "tracker/permission.php";
$button = "Update";
PageAccess("Config: Controls");
$controlId = 0;
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$controlId = $request_uri[2];
		DebugText("using param 2:".$controlId);
	}
}
$control = new Control($controlId);
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
