<?php
//
//  Tracker - Version 1.13.0
//
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
include_once "globals.php";
include_once "tracker/apiKey.php";
include_once "tracker/monitor.php";
$key = GetURLVar("key");
if (!strlen($key))
{
    return;
}
$apiKey = new apiKey();
$param = AddEscapedParam("","apiKey",$key);
if (!$apiKey->Get($param))
{
    return;
}
$monitor = new Monitor();
$monitor->orderBy = "monitorId desc";
$param = "active = 1";
$ok = $monitor->Get($param);
while ($ok)
{
    echo $monitor->monitorId.",".$monitor->pingAddress."\n";
    $ok = $monitor->Next();
}

