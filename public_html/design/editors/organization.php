<?php
//
//  Tracker - Version 1.13.0
//
// v1.13.0
//  - added support for limit sharing across orgs
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
include_once "tracker/organization.php";
include_once "tracker/user.php";
include_once "tracker/shareWithOrganization.php";

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
      <td>
        Share with:
      </td>
      <td>
        <select name="shareWith[]" id="shareWith" multiple="multiple" size="8">
          <?php
           $org = new Organization();
           $param = "active = 1;";
           if ($organization->organizationId)
           {
             $param = AddEscapedParamNotEqual("","organizationId",$organization->organizationId);

           }
           $ok = $org->Get($param);
           while ($ok)
           {
             $selected = "";
             $param1 = AddEscapedParam("","organizationId",$organization->organizationId);
             $param1 = AddEscapedParam($parma1,"shareWithId",$org->organizationId);
             $shareWithOrganization = new ShareWithOrganization();
             $shareWithOrganization->Get($param1);
             if ($shareWithOrganization->shareWithOrganizationId)
             {
              $selected = "selected='selected'";
             }
             ?>
             <option value="<?php echo $org->organizationId;?>" <?php echo $selected;?>><?php echo $org->name;?></option>

             <?php
             $ok = $org->Next();
           }

          ?>
        </select>
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
