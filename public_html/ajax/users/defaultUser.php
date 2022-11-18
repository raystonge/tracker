<?php
/*
 * Created on Aug 8, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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