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
<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25%">Name: </td>
    <td><?php CreateTextField("fullName",$user->fullName,getFieldSize("users","fullName"),"Enter User&apos;s Full Name",$editFieldClass);?>
    </td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><?php CreatePasswordField("password","",getFieldSize("users","password"),"Enter Password",$editFieldClass);?>
    </td>
  </tr>
  <tr>
    <td>Confirm Password:</td>
    <td><?php CreatePasswordField("confirmPassword","",getFieldSize("users","password"),"Confirm Password",$editFieldClass);?>
  </td>
  </tr>

  <tr>
    <td>Email:</td>
    <td><?php CreateTextField("email",$user->email,getFieldSize("users","email"),"Enter Email address. Also used to login",$editFieldClass);?>
    </td>
  </tr>
  <tr>
    <td>
    Max Tickets per Page:
    </td>
    <td>
      <select name="maxTicketsPerPage" <?php if ($showMouseOvers) { echo "title='Maximum number of tickets per page'";}?>>
        <option value="25" <?php if ($maxTicketsPerPage == 25) {echo "selected='selected'";}?>>25</option>
        <option value="50" <?php if ($maxTicketsPerPage == 50) {echo "selected='selected'";}?>>50</option>
        <option value="75" <?php if ($maxTicketsPerPage == 75) {echo "selected='selected'";}?>>75</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>
    Max Assets per Page:
    </td>
    <td>
      <select name="maxAssetsPerPage" <?php if ($showMouseOvers) { echo "title='Maximum number of assets per page'";}?>>
        <option value="25" <?php if ($maxAssetsPerPage == 25) {echo "selected='selected'";}?>>25</option>
        <option value="50" <?php if ($maxAssetsPerPage == 50) {echo "selected='selected'";}?>>50</option>
        <option value="75" <?php if ($maxAssetsPerPage == 75) {echo "selected='selected'";}?>>75</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>Show Mouse overs:
    </td>
    <td>
    <?php CreateCheckbox("showMouseOvers",1,"",$showMouseOvers,"When passing over fields, show tooltips");?>
    </td>
  </tr>
  <?php
  if ($permission->hasPermission("View: ICS") && $useICS)
  {
  	?>
  <tr>
    <td>Show Internet Storm Center:
    </td>
    <td>
    <?php CreateCheckbox("showISC",1,"",$showISC,"Show ISC icon on home page");?>
    </td>
  </tr>
  	<?php
  }
  ?>
  <?php
  if ($permission->hasPermission("View: Google Apps") && $useGoogleApps)
  {
  	?>
  <tr>
    <td>Show Google Apps Status:
    </td>
    <td>
    <?php CreateCheckbox("showGoogleRSS",1,"",$showGoogleRSS,"Show Google Apps RSS Feed");?>
    </td>
  </tr>
  	<?php

  }
  ?>


  <tr>
    <td>
	<?php
	CreateHiddenField("userId",$user->userId);
	CreateHiddenField("submitTest","1");
	PrintAJAXFormKey();
	?>
	</td>
    <td><?php CreateSubmit();?></td>
  </tr>
</table>
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
