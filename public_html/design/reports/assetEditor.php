<?php
/*
 * Created on Feb 3, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/module.php";
include_once "tracker/moduleQuery.php";
include_once "tracker/assetType.php";
include_once "tracker/building.php";
include_once "tracker/assetCondition.php";
$moduleId = GetURI(2,0);
$module = new Module($moduleId); 
?>
<script language="javascript">
$(document).ready(function () {

  $('#assetTypeIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#assetTypeId').attr('multiple','multiple');
        $('#assetTypeId option[value="0"]').remove();
    }
    else
    {
        $('#assetTypeId').removeAttr('multiple');
        var optionExists = ($('#assetTypeId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#assetTypeId').prepend("<option value='0'>Select Asset Type</option>");
        	$('#assetTypeId').val(0);
        }
    }
  })
  $('#buildingIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#buildingId').attr('multiple','multiple');
        $('#buildingId option[value="0"]').remove();
    }
    else
    {
        $('#buildingId').removeAttr('multiple');
        var optionExists = ($('#buildingId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#buildingId').prepend("<option value='0'>Select Asset Building</option>");
        	$('#buildingId').val(0);
        }
    }
  })
  $('#assetConditionIdTest').change(function()
  {
  	test = $(this).val();
    if (test == "In")
    {
        $('#assetConditionId').attr('multiple','multiple');
        $('#assetConditionId option[value="0"]').remove();
    }
    else
    {
        $('#assetConditionId').removeAttr('multiple');
        var optionExists = ($('#assetConditionId option[value="0"]').length > 0);
        if(!optionExists)
        {
        	$('#assetConditionId').prepend("<option value='0'>Select Asset Type</option>");
        	$('#assetConditionId').val(0);
        }
    }
  })
  $('#warrantyDateTest').change(function()
  {
  	test = $(this).val();
    if (test == "numDays")
    {
        $('#warrantyDateField').hide();
        $('#warrantyNumDaysField').show();
    }
    else
    {
        $('#warrantyDateField').show();
        $('#warrantyNumDaysField').hide();
    }
  })
  $('#aquireDateTest').change(function()
  {
  	test = $(this).val();
    if (test == "numDays")
    {
        $('#aquireDateField').hide();
        $('#aquireNumDaysField').show();
    }
    else
    {
        $('#aquireDateField').show();
        $('#aquireNumDaysField').hide();
    }
  })  
$('#warrantyDateTest').change();
$('#aquireDateTest').change();
	 $('#make').autocomplete({source:'/ajax/lookups/make.php', minLength:1});
	 $('#buildingLocation').autocomplete({source:'/ajax/lookups/buildingLocation.php', minLength:1});
	 $('#vendor').autocomplete({source:'/ajax/lookups/vendor.php', minLength:1});
	 $('#model').autocomplete({minLength:1,
      source: function (request, response) {
        var make = $("#make").val(),
            model = $("#model").val();
         $.ajax({
            url: '/ajax/lookups/model.php?make=' + make + '&model='+model,
            success: function(data) {
                response(parseLineSeperated(data));
                //response(data);
            },
            error: function(req, str, exc) {
                alert(str);
            }
        });
    }
});

        function parseLineSeperated(data){

        data = data.split("\n");
        return data;
        
    }

});  
</script>
<script type="text/javascript">
adminFilePath="";
</script>
<script type="text/javascript"  src="<?php echo $hostPath;?>/js/calendarDateInput.js"></script>

<form method="post" action="/process/report/asset.php" autocomplete="<?php echo $autoComplete;?>">
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
    $param = AddParam($param,"fieldToTest='assetId'");
    $moduleQuery->Get($param);
    $lessThan = "<";
    ?>
    Asset Id:
    </td>
    <td valign="top">
      <select id="assetIdTest" name="assetIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<?php echo $lessThan;?>" <?php if ($moduleQuery->fieldTest == $lessThan){echo "selected='selected'";}?>>Less Than</option>
        <option value="<=" <?php if ($moduleQuery->fieldTest == "<="){echo "selected='selected'";}?>>Less Than or Equal</option>
        <option value=">" <?php if ($moduleQuery->fieldTest == ">"){echo "selected='selected'";}?>>Greater Than</option>
        <option value=">=" <?php if ($moduleQuery->fieldTest == ">="){echo "selected='selected'";}?>>Greater Than or Equal</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("assetId","");?>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='serialNumber'");
    $moduleQuery->Get($param);
    ?>
    Serial Number:
    </td>
    <td valign="top">
      <select id="serialNumberTest" name="serialNumberTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("serialNumber",$moduleQuery->testValue);?>
    </td>
  </tr>
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='assetTag'");
    $moduleQuery->Get($param);
    ?>
    Asset Tag:
    </td>
    <td valign="top">
      <select id="assetTagTest" name="assetTagTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("assetTag",$moduleQuery->testValue);?>
    </td>
  </tr>  
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='macAddress'");
    $moduleQuery->Get($param);
    ?>
    Mac Address:
    </td>
    <td valign="top">
      <select id="macAddressTest" name="macAddressTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("macAddress",$moduleQuery->testValue);?>
    </td>
  </tr>    
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='assetTypeId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>    
    Asset Type:
    </td>
    <td valign="top">
      <select id="assetTypeIdTest" name="assetTypeIdTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="assetTypeId" name="assetTypeId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <?php 
        DebugText("test Len:".strlen($moduleQuery->testValue));
        if (strlen($moduleQuery->testValue)==0)
        {
        	?>
        <option value="0">Select Asset Type</option>
        	<?php
        }
        $assetType = new AssetType();
        $ok = $assetType->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($assetType->assetTypeId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $assetType->name;?></option>
        	<?php
        	$ok = $assetType->Next();
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
    $param = AddParam($param,"fieldToTest='buildingId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>    
    Building:
    </td>
    <td valign="top">
      <select id="buildingIdTest" name="buildingIdTest">
       	<option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="buildingId" name="buildingId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <?php 
        DebugText("test Len:".strlen($moduleQuery->testValue));
        if (strlen($moduleQuery->testValue)==0)
        {
        	?>
        <option value="0">Select Building</option>
        	<?php
        }
        $building = new Building();
        $ok = $building->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($building->buildingId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $building->buildingId;?>" <?php echo $selected;?>><?php echo $building->name;?></option>
        	<?php
        	$ok = $building->Next();
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
    $param = AddParam($param,"fieldToTest='assetConditionId'");
    $moduleQuery->Get($param);
    $values = new Set(",");
    $values->SetData($moduleQuery->testValue);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>    
    Condition:
    </td>
    <td valign="top">
      <select id="assetConditionIdTest" name="assetConditionIdTest">
       	<option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<>" <?php if ($moduleQuery->fieldTest == "<>"){echo "selected='selected'";}?>>Does not Equal</option>
        <option value="In" <?php if ($moduleQuery->fieldTest == "In"){echo "selected='selected'";}?>>In</option>
      </select>
    </td>
    <td valign="top">
      <select id="assetConditionId" name="assetConditionId[]" <?php if ($moduleQuery->fieldTest == "In") {echo "multiple='multiple'";};?>>
        <?php 
        DebugText("test Len:".strlen($moduleQuery->testValue));
        if (strlen($moduleQuery->testValue)==0)
        {
        	?>
        <option value="0">Select Condition</option>
        	<?php
        }
        $condition = new AssetCondition();
        $ok = $condition->Get("");
        while ($ok)
        {
        	$selected = "";
        	if ($values->InSet($condition->assetConditionId))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $condition->assetConditionId;?>" <?php echo $selected;?>><?php echo $condition->name;?></option>
        	<?php
        	$ok = $condition->Next();
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
    $param = AddParam($param,"fieldToTest='name'");
    $moduleQuery->Get($param);
    ?>
    Name:
    </td>
    <td valign="top">
      <select id="nameTest" name="nameTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("name",$moduleQuery->testValue);?>
    </td>
  </tr> 
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='make'");
    $moduleQuery->Get($param);
    ?>
    Make:
    </td>
    <td valign="top">
      <select id="makeTest" name="makeTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("make",$moduleQuery->testValue);?>
    </td>
  </tr> 
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='model'");
    $moduleQuery->Get($param);
    ?>
    Model:
    </td>
    <td valign="top">
      <select id="modelTest" name="modelTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("model",$moduleQuery->testValue);?>
    </td>
  </tr>   
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='poNumber'");
    $moduleQuery->Get($param);
    ?>
    PO Number:
    </td>
    <td valign="top">
      <select id="poNumberTest" name="poNumberTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("poNumber",$moduleQuery->testValue);?>
    </td>
  </tr>      
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='vendor'");
    $moduleQuery->Get($param);
    ?>
    Vendor:
    </td>
    <td valign="top">
      <select id="vendorTest" name="vendorTest">
        <option value="">Select Test</option>
        <option value="matches">Matches</option>
      </select>
    </td>
    <td valign="top">
      <?php CreateTextField("vendor",$moduleQuery->testValue);?>
    </td>
  </tr>  
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='warrantyDate'");
    $moduleQuery->Get($param);
    $numDays = "";
    if ($moduleQuery->fieldTest == "numDays")
    {
    	$numDays = $moduleQuery->testValue;
    }
    if ((strlen($moduleQuery->testValue) == 0)|| $moduleQuery->fieldTest == "numDays")
    {
    	$moduleQuery->testValue = $today;
    }
    DebugText("fieldToTest:".$moduleQuery->fieldToTest);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Warranty Date:
    </td>
    <td valign="top">
      <select id="warrantyDateTest" name="warrantyDateTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<?php echo $lessThan;?>" <?php if ($moduleQuery->fieldTest == $lessThan){echo "selected='selected'";}?>>Less Than</option>
        <option value="<=" <?php if ($moduleQuery->fieldTest == "<="){echo "selected='selected'";}?>>Less Than or Equal</option>
        <option value=">" <?php if ($moduleQuery->fieldTest == ">"){echo "selected='selected'";}?>>Greater Than</option>
        <option value=">=" <?php if ($moduleQuery->fieldTest == ">="){echo "selected='selected'";}?>>Greater Than or Equal</option>
        <option value="numDays" <?php if ($moduleQuery->fieldTest == "numDays") { echo "selected='selected'";}?>>Expires in</option>
      </select>
    </td>
    <td valign="top">
      <span id="warrantyDateField">
      <?php CreateDateField("warrantyDate",$moduleQuery->testValue);?>
      </span>
      <span id="warrantyNumDaysField">
        <select id="warrantyDateNumDays" name="warrantyDateNumDays">
          <option value="0">Any Date in Future</option>
          <option value="30" <?php if ($numDays == 30){echo "selected='selected'";}?>>30 Days</option>
          <option value="60" <?php if ($numDays == 60){echo "selected='selected'";}?>>60 Days</option>
          <option value="120" <?php if ($numDays == 120){echo "selected='selected'";}?>>120 Days</option>
        </select>
      </span>
    </td>
  </tr>       
  <tr>
    <td valign="top">
    <?php
    $moduleQuery = new ModuleQuery();
    $param = AddParam("","moduleId=".$module->moduleId);
    $param = AddParam($param,"fieldToTest='aquireDate'");
    $moduleQuery->Get($param);
    $numDays = "";
    if ($moduleQuery->fieldTest == "numDays")
    {
    	$numDays = $moduleQuery->testValue;
    }
    if ((strlen($moduleQuery->testValue) == 0) || $moduleQuery->fieldTest == "numDays")
    {
    	$moduleQuery->testValue = $today;
    }    
    DebugText("fieldToTest:".$moduleQuery->fieldToTest);
    DebugText("fieldTest:".$moduleQuery->fieldTest);
    DebugText("testValue:".$moduleQuery->testValue);
    ?>
    Aquire Date:
    </td>
    <td valign="top">
      <select id="aquireDateTest" name="aquireDateTest">
        <option value="">Select Test</option>
        <option value="=" <?php if ($moduleQuery->fieldTest == "="){echo "selected='selected'";}?>>Equals</option>
        <option value="<?php $lessThan;?>" <?php if ($moduleQuery->fieldTest == $lessThan){echo "selected='selected'";}?>>Less Than</option>
        <option value="<=" <?php if ($moduleQuery->fieldTest == "<="){echo "selected='selected'";}?>>Less Than or Equal</option>
        <option value=">" <?php if ($moduleQuery->fieldTest == ">"){echo "selected='selected'";}?>>Greater Than</option>
        <option value=">=" <?php if ($moduleQuery->fieldTest == ">="){echo "selected='selected'";}?>>Greater Than or Equal</option>
        <option value="numDays" <?php if ($moduleQuery->fieldTest == "numDays") { echo "selected='selected'";}?>>Expires in</option>
      </select>
    </td>
    <td valign="top">
      <span id="aquireDateField">
      <?php CreateDateField("aquireDate",$moduleQuery->testValue);?>
      </span>
      <span id="aquireNumDaysField">
        <select id="aquireDateNumDays" name="aquireDateNumDays">
          <option value="0">Any Date in Future</option>
          <option value="30" <?php if ($numDays == 30){echo "selected='selected'";}?>>30 Days</option>
          <option value="60" <?php if ($numDays == 60){echo "selected='selected'";}?>>60 Days</option>
          <option value="120" <?php if ($numDays == 120){echo "selected='selected'";}?>>120 Days</option>
        </select>
      </span>
    </td>
  </tr>   
</table>
<?php CreateSubmit();?>
</form>