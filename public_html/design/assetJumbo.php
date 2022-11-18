<?php
include_once "tracker/permission.php";
$permission = new Permission();
/*
if (!$permission->hasPermission("Config: Queue"))
{
	include $sitePath."/design/noAccess.php";
}*/
include_once "tracker/asset.php";
$asset = new Asset();
include $sitePath."/design/asset/jumboEditor.php";
?>