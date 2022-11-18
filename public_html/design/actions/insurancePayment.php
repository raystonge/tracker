<?php
/*
 * Created on Dec 7, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$htmlAction='<a href="/editInsurancePayment/'.$insurancePayment->insurancePaymentId.'/" class="edit_insurancePayment" ';
if ($showMouseOvers)
{
	$htmlAction=$htmlAction.' title="Edit"';
}
$htmlAction=$htmlAction.' alt="Edit"><img src="/images/icon_edit.png"></a>';
$htmlAction=$htmlAction.'<a href="/deleteInsurancePayment/'.$insurancePayment->insurancePaymentId.'/" class="delete_insurancePayment" ';
if ($showMouseOvers)
{
	$htmlAction = $htmlAction.' title="Delete"';
}
$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"></a>';
?>