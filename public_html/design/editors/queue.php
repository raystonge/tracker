<?php

include_once "globals.php";
include_once "tracker/user.php";
include_once "tracker/defaultUser.php";
include_once "tracker/organization.php";

$editingUserGroup = 0;
$organizationId = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;
$organization = new Organization();
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listQueues/">Queues</a></h2>
    <?php
    if (isset($_SESSION['formErrors'])) 
    {
    	if (strlen($_SESSION['formErrors']))
    	{
    		
    		$queue->name = $_SESSION['name'];
    		$queue->organizationId = $_SESSION['organizationId'];
    		?>
    		<div class="feedback error">
    		<?php
    		echo $_SESSION['formErrors'];
    		?>
    		</div>
    		<?php
    	}
    }
    ?>
    
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/queue.php">
  <table class="width100">
    <tr>
      <td>Queue:
      </td>
      <td>
       <input type="text" name="name" class="ui-corner-left ui-corner-right" value="<?php echo $queue->name;?>"/>
      </td>
      <td>
    </tr>
    <tr>
      <td><?php echo $orgOrDept;?> :
      </td>
      <td>
       <select id="organization" name ="organization" class="organization">
         <option value = "0">Select <?php echo $orgOrDept;?></option>
         <?php
           $param = "organizationId in (".GetMyOrganizations().")";
           $ok = $organization->Get($param);
           while ($ok)
           {
           	$selected = "";
           	if ($queue->organizationId == $organization->organizationId)
           	{
           		$selected = "selected='selected'";
           	}
           	?>
           	<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
           	<?php
           	$ok = $organization->Next();
           }
         ?>
       </select>
      </td>
    </tr>
    <tr>
      <td>
      Default Assignee:
      </td>
      <td>
      <div id="assigneeResults"></div>
      </td>
    </tr>
    <tr>
      <td>
      Default CC:
      </td>
      <td><div id="ccUsersResults"></div>
      </td>
    </tr>

    <tr>
      <td>&nbsp;
      <input type="hidden" value="<?php echo $cnt;?>" name="cnt">
      <input type="hidden" value="1" name="submitTest">
      <input type="hidden" name="queueId" value="<?php echo $queue->queueId;?>"/>
      <input type="hidden" name="ajaxFormKey" value="<?php echo getAJAXFormKey();?>" />
      </td>
      <td>
        <input type="submit" name="submit" value="<?php echo $button;?>"/>
      </td>
    </tr>
  </table>
</form>
</div>
