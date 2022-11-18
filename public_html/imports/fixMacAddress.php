<?php
/*
 * Created on Oct 28, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";
$asset = new Asset();
$ok = $asset->Get("");
while ($ok)
{
	//echo $asset->macAddress."-".$asset->FormatMacAddress($asset->macAddress)."<br>";
	$asset->Update();
	$ok = $asset->Next();
}
DebugOutput();
?>