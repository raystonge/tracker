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
<div class="adminArea">
	<h2>User Profile</h2>
    <?php
    $user = new User($currentUser->userId);
    $password = "";
    if (FormErrors())
    {
    	$user->fullName = GetFromSession("userProfileFullName");
    	$user->email = GetFromSession("userProfileEmail");
    	DisplayFormErrors();
    }
    ?>

<form  method="post" name="form1" id="form1"  autocomplete="<?php echo $autoComplete;?>" action="/process/userProfile.php">
<table class="width100">
 <tr>
   <td valign="top">

  </td>
  <td valign="top">
  <?php
  if ($permission->hasPermission("Select Modules"))
  {
  	?>
    <table width="600px">
     <tr>
       <th>
       Available Modules
       </th>
       <th>
       My Modules
       </th>
     </tr>
<tr>
 <td valign="top" width="50%">
   <div class='pane' id='availableModules'>
  </div>
 </td>
 <td valign="top">
   <div class='pane' id='myModules'>
  </div>
  </td>
</tr>

    </table>
    <?php
  }
  ?>
  </td>
</tr>
</table>
</form>
</div>
