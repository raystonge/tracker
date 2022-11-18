<?php 
include_once 'globals.php';
include_once "tracker/poNumber.php";
include_once "tracker/user.php";
include_once "tracker/history.php";
$poNumber = new poNumber();

$param = "reconciled=0 or reconciled is null";
$ok = $poNumber->Get($param);
while ($ok)
{
	$field = "reconciled".$poNumber->poNumberId;
	if (GetTextField($field,0))
	{
		$poNumber->Reconcile();
	}

	$ok = $poNumber->Next();
}
$param = "receivedDate='0000-00-00 00:00:00' or receivedDate is null";
$ok = $poNumber->Get($param);
while ($ok)
{

    $field = "received".$poNumber->poNumberId;
    if (GetTextField($field,0))
    {
        $poNumber->Received();
    }
    $ok = $poNumber->Next();
}
DebugPause("/listpoNumber/");
?>