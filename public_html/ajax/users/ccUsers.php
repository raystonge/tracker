<?php
/*
 * Created on Aug 11, 2015
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
<?php
$organizationId= GetTextField("organization",0);
$queueId = GetTextField("queueId");
?>
<select name="cc[]" size="5" multiple>
			<?php
            $user = new User();
            $ok = $user->GetAssignees("uto.organizationId=".$organizationId);
            while ($ok)
            {
            	$defaultUser = new DefaultUser();
            	$param = "userType='cc' and queueId=".$queueId." and userId=".$user->userId;
            	$selected = "";
            	if ($defaultUser->Get($param))
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
