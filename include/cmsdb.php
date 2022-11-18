<?php
//
//  AdSys - Version 1.0
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
$hostname_cms = "localhost";
$database_cms = "trackerVS";
$username_cms = "root";
$password_cms = "";
$port_cms = 3306;
DebugText("hostname_cms:".$hostname_cms);
DebugText("database_cms:".$database_cms);
$link_cms = @mysqli_connect($hostname_cms, $username_cms, $password_cms,$database_cms,$port_cms);// or trigger_error(mysqli_error(),E_USER_ERROR);
if (!$link_cms)
{
  $redirectstr = "Location: /dbDown.html";
  header($redirectstr);
	exit;
}
DebugText("mysqli_connect:".mysqli_error($link_cms));
/*
@mysqli_select_db($link_cms,$database_cms);
$iLink_cms = mysqli_connect($hostname_cms, $username_cms, $password_cms,$database_cms);
if (strlen(mysqli_connect_error()))
{
    DebugText('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
*/
?>
