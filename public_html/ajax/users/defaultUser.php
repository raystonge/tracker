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
include_once "globals.php";
include_once "tracker/defaultUser.php";
include_once "tracker/user.php";

?>
<select name="assignee">
  <option value="0">Select Default Assignee</option>
  <?php
  $organizationId = GetTextField("organization",0);
  $queueId = GetTextField("queueId",0);
  $defaultUser = new DefaultUser();
  $param = "userType='assignee' and queueId=".$queueId;
  $defaultUser->Get($param);
  $user = new User();
  $ok = $user->GetAssignees("uto.organizationId=".$organizationId);
  while ($ok)
  {
  	$selected="";
    if ($defaultUser->userId==$user->userId)
    {
    	$selected="selected='selected'";
    }
   	?>
   	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $user->fullName;?></option>
   	<?php
   	$ok = $user->Next();
  }
  ?>
</select>
<?php // DebugOutput();?>
