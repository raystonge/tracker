<?php
//
//  Tracker - Version 1.13.1
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
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
   DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
$control = new Control();
$param = "sectionValue='Debug' and keyValue='Scripts'";
$ok = $control->Get($param);
$debugScript = GetTextField("debugScript");
$debugging = GetTextField("debug");
$_SESSION['debugging'] = $debugging;

$control->valueInt = $debugScript;
if (!$ok)
{
    $control->section = "Debug";
    $control->key = "Scripts";
    $control->datatype = "integer";
    
}
$control->Persist();
DebugPause("/debug");
?>