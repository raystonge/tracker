<?php
include_once "tracker/building.php";
include_once "tracker/permission.php";
$button = "Create";
PageAccess("Config: Building");
$building = new Building();
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
<script src="/ajax/editBuilding.js"></script>
<?php 
include $sitePath."/design/editors/building.php";
?>