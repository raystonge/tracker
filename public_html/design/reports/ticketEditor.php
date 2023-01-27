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
include_once "tracker/status.php";
include_once "tracker/queue.php";
include_once "tracker/priority.php";
include_once "tracker/status.php";
include_once "tracker/user.php";
include_once "tracker/module.php";
include_once "tracker/moduleQuery.php";
include_once "tracker/organization.php";
$moduleId = GetURI(2,0);
$module = new Module($moduleId);
?>
<script language="javascript">
$(document).ready(function () {

  $('#queueIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#queueId').attr('multiple','multiple');
        $('#queueId option[value="0"]').remove();
    }
    else
    {
        $('#queueId').removeAttr('multiple');
        var optionExists = ($('#queueId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#queueId').prepend("<option value='0'>Select Queue</option>");
        	$('#queueId').val(0);
        }
    }
  })

  $('#statusIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#statusId').attr('multiple','multiple');
        $('#statusId option[value="0"]').remove();
    }
    else
    {
        $('#statusId').removeAttr('multiple');
        var optionExists = ($('#statusId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#statusId').prepend("<option value='0'>Select Status</option>");
        	$('#statusId').val(0);
        }
    }
  })

  $('#priorityIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#priority').attr('multiple','multiple');
        $('#priority option[value="0"]').remove();
    }
    else
    {
        $('#priorityId').removeAttr('multiple');
        var optionExists = ($('#priorityId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#priorityId').prepend("<option value='0'>Select Priority</option>");
        	$('#priorityId').val(0);
        }
    }
  })

  $('#requestorIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#requestorId').attr('multiple','multiple');
        $('#requestorId option[value="0"]').remove();
    }
    else
    {
        $('#requestorId').removeAttr('multiple');
        var optionExists = ($('#requestorId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#requestorId').prepend("<option value='0'>Select Requestor</option>");
        	$('#requestorId').val(0);
        }
    }
  })
  $('#assigneeIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#assigneeId').attr('multiple','multiple');
        $('#assigneeId option[value="0"]').remove();
    }
    else
    {
        $('#assigneeId').removeAttr('multiple');
        var optionExists = ($('#assigneeId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#assigneeId').prepend("<option value='0'>Select Assignee</option>");
        	$('#assigneeId').val(0);
        }
    }
  })

});
</script>
<form method="post" action="/process/report/ticket.php" autocomplete="<?php echo $autoComplete;?>">
Name: <?php CreateTextField("moduleName",$module->name);?>
<?php CreateHiddenField("moduleId",$module->moduleId);?>
<table>
  <tr>
    <th>
    Field
    </th>
    <th>
    IdTest
    </th>
    <th>
    Value
    </th>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='ticketId'");
    $moduleQuery->Get($param);
    $lessThan = "<";
    ?>
    Ticket Id:
    </td>
    <td valign="top">
      <select id="ticketIdTest" name="ticketIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?> >Equals</option>
        <option value="<?php echo $lessThan;?>" <?php if ($moduleQuery->fieldTest == $lessThan) {echo "selected='selected'";}?> >Less Than</option>
        <option value="<=" <?php if ($moduleQuery->fieldTest == "<="){echo "selected='selected'";}?>>Less Than or Equal</option>
        <option value=">" <?php if ($moduleQuery->fieldTest == ">"){echo "selected='selected'";}?>>Greater Than</option>
        <option value=">=" <?php if ($moduleQuery->fieldTest == ">="){echo "selected='selected'";}?>>Greater Than or Equal</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("ticketId","");?>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='subject'");
    $moduleQuery->Get($param);
    ?>      Subject:
    </td>
    <td valign="top">
      <select id="subjectTest" name="subjectTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("subject",$moduleQuery->testValue);?>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='queueId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Queue:
    </td>
    <td valign="top">
      <select id="queueIdTest" name="queueIdTest">
        	<option value="">Select Test</option>

        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="queueId" name="queueId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <?php
        DebugText("test Len:".strlen($moduleQuery->testValue));
        if (strlen($moduleQuery->testValue)==0)
        {
        	?>
        <option value="0">Select Queue</option>
        	<?php
        }
        $queue = new Queue();
        $ok = $queue->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($queue->queueId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $queue->queueId;?>" <?php echo $selected;?>><?php echo $queue->name;?></option>
        	<?php
        	$ok = $queue->Next();
        }
        ?>
      </select>
    </tr>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='statusId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Status:
    </td>
    <td valign="top">
      <select id="statusIdTest" name="statusIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="statusId" name="statusId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <option value="0">Select Status</option>
        <?php
        $status = new Status();
        $ok = $status->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($status->statusId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $status->statusId;?>" <?php echo $selected;?>><?php echo $status->name;?></option>
        	<?php
        	$ok = $status->Next();
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='priorityId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Priority:
    </td>
    <td valign="top">
      <select id="priorityIdTest" name="priorityIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="priority" name="priorityId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <option value="0">Select Priority</option>
        <?php
        $priority = new Priority();
        $ok = $priority->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($priority->priorityId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $priority->priorityId;?>" <?php echo $selected;?>><?php echo $priority->name;?></option>
        	<?php
        	$ok = $priority->Next();
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='requestorId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Requestor:
    </td>
    <td valign="top">
      <select id="requestorIdTest" name="requestorIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="requestorId" name="requestorId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <option value="0">Select Requestor</option>
        <?php
        $user = new User();
        $ok = $user->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($status->statusId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $user->fullName;?></option>
        	<?php
        	$ok = $user->Next();
        }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='assigneeId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Assignee:
    </td>
    <td valign="top">
      <select id="assigneeIdTest" name="assigneeIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="assigneeId" name="assigneeId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <option value="0">Select Assignee</option>
        <?php
        $user = new User();
        $ok = $user->GetAssignees("");
        while ($ok)
        {
        	?>
        	<option value="<?php echo $user->userId;?>"><?php echo $user->fullName;?></option>
        	<?php
        	$ok = $user->Next();
        }
        ?>
      </select>
    </td>
  </tr>
</table>
<?php CreateSubmit();?>
</form>
