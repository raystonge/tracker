<?php

include_once "globals.php";
include_once "tracker/organization.php";
include_once "tracker/user.php";

$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;

?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listOrganization/"><?php echo $orgOrDept;?>s</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
    	$organization->organizationId = GetTextFromSession("organizationId",0);
   		$organization->name = GetTextFromSession("name");
   		$organization->assetPrefix = GetTextFromSession("assetPrefix");
   		$organization->defaultAssigneeId = GetTextFromSession("defaultAssigneeId",0);
			$organization->billable = GetTextFromSession("billable",0);
			$organization->showAllUsers = GetTextFromSession("showAllUsers",0);
			$organization->active = GetTextFromSession("active",1);
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/organization.php">
  <table class="width100">
    <tr>
      <td><?php echo $orgOrDept;?> :
      </td>
      <td>
      <?php CreateTextField("name",$organization->name,getFieldSize("organization","name"),"Name for Organization",$editFieldClass);?>
      </td>
      <td>
    </tr>
    <tr>
      <td>Asset Prefix :
      </td>
      <td>
      <?php CreateTextField("assetPrefix",$organization->assetPrefix,getFieldSize("organization","assetPrefix"),"Prefix for Asset",$editFieldClass);?>
      </td>
      <td>
    </tr>
    <tr>
      <td>
        Default Assignee :
      </td>
      <td>
        <select id="defaultAssigneeId" name="defaultAssgineeId">
          <?php
          $user = New User();
          $ok = $user->GetAssignees("");
          while ($ok)
          {
              $selected = "";
              if ($organization->defaultAssigneeId == $user->userId)
              {
                  $selected = "selected='selected'";
              }
              ?>
              <option value="<?php echo $user->userId;?>" <?php $selected;?>><?php echo $user->fullName;?></option>
              <?php
              $ok = $user->Next();
          }
          ?>

        </select>
      </td>
    </tr>
		<tr>
			<td>
				Billable:
			</td>
			<td>
				<?php CreateCheckBox("billable",1,"",$organization->billable); ?>
			</td>
		</tr>
		<tr>
			<td>
				Show All Users:
			</td>
			<td>
				<?php CreateCheckBox("showAllUsers",1,"",$organization->showAllUsers); ?>
			</td>
		</tr>
		<tr>
			<td>
				Active:
			</td>
			<td>
				<?php CreateCheckBox("active",1,"",$organization->active); ?>
			</td>
		</tr>
    <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("organizationId",$organization->organizationId);
      PrintFormKey();
      ?>
      </td>
      <td>
      <?php CreateSubmit("submit",$button);?>
      </td>
    </tr>
  </table>
</form>
</div>
