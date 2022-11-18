<?php
/*
 * Created on Nov 12, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/asset.php";

$assetId = 0;
if (isset($_GET['assetId']))
{
	$assetId = $_GET['assetId'];
}
$asset = new Asset($assetId);
if (!$asset->assetId)
{
	DebugPause("/listAssets/");
}
$_SESSION['createTicketForAsset'] = $asset->assetId;
DebugPause("/ticketNew/");
?>