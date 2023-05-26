<?php
//
//  Tracker - Version 1.9.0
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
include_once "tracker/user.php";
include_once "tracker/userToService.php";
include_once "tracker/service.php";
$serviceId = GetTextField("serviceId");
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
  DebugPause("/improperAccess/");
}
$userToService = new UserToService();
$user = new User();
$user->SetOrderBy("fullName");
$ok = $user->Get("active=1");
while ($ok)
{
  $field = "user".$user->userId;
  $param = AddEscapedParam("","serviceId",$serviceId);
  $param = AddEscapedParam($param,"userId",$user->userId);
  $userToService = new UserToService();
  $hasService = GetTextField($field,0);
  if (!$hasService && $userToService->Get($param))
  {
    $userToService->Delete();
  }
  else {
    if ($hasService && !$userToService->Get($param))
    {
      $userToService->userId = $user->userId;
      $userToService->serviceId = $serviceId;
      $userToService->Persist();
    }
  }
  $ok = $user->Next();
}
DebugPause("/listServices/");
