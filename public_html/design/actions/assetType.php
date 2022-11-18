<?php
/*
 * Created on Dec 7, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$htmlAction='<a href="/editAssetType/'.$assetType->assetTypeId.'/" class="edit_assetType" ';
if ($showMouseOvers)
{
	$htmlAction=$htmlAction.' title="Edit"';
}
$htmlAction=$htmlAction.' alt="Edit"><img src="/images/icon_edit.png"></a>';

if ($assetType->hasSpecs)
{
$htmlAction=$htmlAction.'<a href="/assignSpec/'.$assetType->assetTypeId.'/" class="assign_spec" ';
if ($showMouseOvers)
{
	$htmlAction = $htmlAction.' title="Assign Specs"';
}
$htmlAction=$htmlAction.' alt="Assign"><img src="/images/icons/icon_settings.gif"></a>';
}
else {
	$htmlAction = $htmlAction.'<img src="/images/icon_blank.png">';
}
$htmlAction=$htmlAction.'<a href="/deleteAssetType/'.$assetType->assetTypeId.'/" class="delete_assetType" ';
if ($showMouseOvers)
{
	$htmlAction = $htmlAction.' title="Delete"';
}
$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"></a>';
?>
