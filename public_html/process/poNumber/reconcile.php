<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
<?php
include_once 'globals.php';
include_once "tracker/poNumber.php";
include_once "tracker/user.php";
include_once "tracker/history.php";
$poNumber = new poNumber();
ProperAccessValidate("rupdateKey");
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
