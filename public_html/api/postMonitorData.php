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
include_once "tracker/user.php";
include_once "tracker/monitorToUser.php";
include_once "tracker/asset.php";
include_once "tracker/monitorMessages.php";
include_once "tracker/monitorServer.php";
include_once "tracker/mailSupport.php";
$debug = 1;
$key = GetURLVar("key");
$data = GetURLVar("data");
echo "postMonitorData\n<br>";
echo "key:".$key."\n<br>";
echo "data:".$data."\n<br>";
$fp = fopen("data.txt","w");
if (!$fp)
{
    echo "can't create file\n";
    exit;
}
fwrite($fp,$data);
fclose($fp);
$apiKey = new apiKey();
$param = AddEscapedParam("","apiKey",$key);
if (!$apiKey->Get($param))
{
    echo "no key";
    return;
}
$name = GetURLVar("monitor");
if (!strlen($name))
{
  echo "no monitor server\n<br>";
  return;
}
$param = AddEscapedParam("","name",$name);
$monitorServer = new MonitorServer();
if (!$monitorServer->Get($param))
{
  return;
}
$remoteAddress = $_SERVER['REMOTE_ADDR'];
if ($remoteAddress != $apiKey->ip)
{
    echo "ip don't match";
    return;
}
$separator = "\n";
$line = strtok($data,$separator);
$cnt = 1;
$data = array();
$monitor = new Monitor();
$monitor->ResetStatus($monitorServer->monitorServerId);
$monitor->ResetStateForWhine($monitorServer->monitorServerId);
echo "parse lines\n";
while ($line !== false)
{
    echo $cnt.":".$line."\n<br>";
    $data[] = str_getcsv($line,"|");
    $data = explode("|",$line);
    $monitor = new Monitor($data[0]);
    if ($data[2] != $monitor->state)
    {
        $monitor->state = $data[2];
        $monitor->UpdateStatus();
    }

    $cnt++;
    $line = strtok($separator);
}

$monitor = new Monitor();
$param = "active = 1 and statusChange  = 1";

$user = new User();
$user->clearEmailMessage();
$monitorMessage = new MonitorMessages();
$monitorMessage->clearEmailMessage($monitorServer->monitorServerId);
$ok = $monitor->Get($param);

while ($ok)
{
    $asset = new Asset($monitor->assetId);
    $msg = $asset->name;
    if ($monitor->state)
    {
        $msg = $msg." is now UP<br>";
    }
    else
    {
        $msg = $msg." is now DOWN<br>";
    }
    $history = new History();
    $history->assetId = $monitor->assetId;
    $history->action = $msg;
    $history->actionDate = $now;
    $history->Insert();
    $param1 = AddEscapedParam("","monitorId",$monitor->monitorId);
    $monitorToUser = new MonitorToUser();
    $ok1 = $monitorToUser->Get($param1);

    while ($ok1)
    {
        $monitorMessage = new MonitorMessages();
        $monitorMessage->GetByUserId($monitorToUser->userId,$monitorServer->monitorServerId);
        $monitorMessage->msg = $monitorMessage->msg.$msg;
        $monitorMessage->userId = $monitorToUser->userId;
        $monitorMessage->monitorServerId = $monitorServer->monitorServerId;
        $monitorMessage->Persist();
        $ok1 = $monitorToUser->Next();
    }
    $ok = $monitor->Next();
}
$monitorMessage = new MonitorMessages();
$param = AddEscapedParam("","monitorServerId",$monitorServer->monitorServerId);
$ok = $monitorMessage->Get($param);
while ($ok)
{
    $user = new User($monitorMessage->userId);
    echo "Getting ready to send email to:".$user->email."\n";
    SendMail($user->email,"Device Status has changed",$monitorMessage->msg);
    $ok = $monitorMessage->Next();
}

//DebugOutput();