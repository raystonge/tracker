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
   		$module->name = GetTextFromSession("name");
			$module->description = GetTextFromSession("description");
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
