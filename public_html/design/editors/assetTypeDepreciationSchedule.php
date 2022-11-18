<?php

include_once "globals.php";
include_once "tracker/user.php";
include_once "tracker/defaultUser.php";
include_once "tracker/organization.php";
$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;

?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listAssetType/">Asset Types</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();

    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/asset/assetTypeDepreciationSchedule.php">
  <table class="width100">
    <?php
     for ($i=1; $i <= $assetType->depreciationSchedule; $i++)
     {
       ?>
       <tr>
         <td>
           Year <?php echo $i;?>
         </td>
         <td>
           <?php
           $fieldName = "year".$i;
           CreateTextField($fieldName,$assetTypeDepreciationSchedule->$fieldName);
           ?>
         </td>
       </tr>
       <?php
     }
     ?>
	  <tr>
      <td>&nbsp;
      <?php

      CreateHiddenField("submitTest",1);
      CreateHiddenField("assetTypeId",$assetType->assetTypeId);
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
