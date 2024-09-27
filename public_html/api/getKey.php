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

$remoteAddress = $_SERVER['REMOTE_ADDR'];

if (!validSource($remoteAddress))
{
   // echo $remoteAddress;
    return;
}

$key = md5($remoteAddress.$now);
$apiKey = new apiKey();
$apiKey->ip = $remoteAddress;
$apiKey->apiKey = $key;
$apiKey->dateTime = $now;
$apiKey->Persist();
echo $key;

function validSource($remoteAddress)
{
    $valid = 0;
    if ($remoteAddress == '192.168.16.226' || $remoteAddress == '142.0.109.205' || $remoteAddress == '127.0.0.1' || $remoteAddress == '192.168.16.107')
    {
        $valid = 1;
    }
    return $valid;
}