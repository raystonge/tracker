<?php
/*
 * Created on Dec 7, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$htmlAction='<a href="/editInsuranceRepair/'.$insuranceRepair->insuranceRepairId.'/" class="edit_insuranceRepair" ';
if ($showMouseOvers)
{
	$htmlAction=$htmlAction.' title="Edit"';
}
$htmlAction=$htmlAction.' alt="Edit"><img src="/images/icon_edit.png"></a>';
$htmlAction=$htmlAction.'<a href="/deleteInsuranceRepair/'.$insuranceRepair->insuranceRepairId.'/" class="delete_insuranceRepair" ';
if ($showMouseOvers)
{
	$htmlAction = $htmlAction.' title="Delete"';
}
$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"></a>';
?>