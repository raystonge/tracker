<?php
/*
 * Created on Mar 11, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";
set_time_limit(60000);
$asset = new Asset();
$ok = $asset->Get("");
while ($ok)
{
	$asset->Update();
	$ok = $asset->Next();
}
DebugOutput();
?>