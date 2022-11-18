<?php

include_once "globals.php";

$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;

?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listStatus/">Status</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
   		$status->name = GetTextFromSession("name");

    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/status.php">
  <table class="width100">

    <tr>
      <td>Status :
      </td>
      <td>
      <?php CreateTextField("name",$status->name,getFieldSize("status","name"),"Name for Status",$editFieldClass);?>
      </td>
      <td>
    </tr>
    <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("statusId",$status->statusId);
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
