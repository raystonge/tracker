<?php
//
//  Tracker - Version 1.11.0
//
//  v1.11.0
//   - added orderBy field
//   - fixed issue where fields were not popluated when there was an error
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
include_once "tracker/module.php";
include_once "tracker/user.php";

$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listModules/">Module</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
    	$module->moduleId = GetTextFromSession("moduleId",0);
   		$module->name = GetTextFromSession("moduleName");
			$module->description = GetTextFromSession("moduleDescription");
      $module->query = GetTextFromSession("moduleQuery");
      $module->orderByResults = GetTextFromSession('moduleOrderBy');
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/module.php">
  <table class="width100">
    <tr>
      <td>Name :
      </td>
      <td>
      <?php CreateTextField("name",$module->name,getFieldSize("module","name"),"Name for Module",$editFieldClass);?>
      </td>
      <td>
    </tr>
		<tr>
      <td>Description :
      </td>
      <td>
      <?php CreateTextField("description",$module->description,getFieldSize("module","description"),"Description for Module",$editFieldClass);?>
      </td>
      <td>
    </tr>
		<!--
		<tr>
			<td>Type :
			</td>
			<td>
				<select id="moduleType" name="moduleType">
					<option value="ticket">Ticket</option>
					<option value="asset">Asset</option>
				</select>
		  </td>
		</tr>
	-->
		<tr>
      <td>Query :
      </td>
      <td>
      <?php CreateTextAreaField("moduleQuery",$module->query,getFieldSize("module","query"),"Query for Module",$editFieldClass);?>
      </td>
      <td>
    </tr>
    <tr>
      <td>Order By :
      </td>
      <td>
      <?php CreateTextAreaField("moduleOrderBy",$module->orderByResults,getFieldSize("module","orderBy"),"Order by for Module",$editFieldClass);?>
      </td>
      <td>
    </tr>

    <tr>
      <td>&nbsp;
      <?php
			CreateHiddenField("moduleType","ticket");
			CreateHiddenField("adminOnly",1);
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("moduleId",$module->moduleId);
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
