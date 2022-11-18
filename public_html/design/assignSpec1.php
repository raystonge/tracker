<?php
/*
 * Created on Dec 11, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
