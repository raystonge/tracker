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
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Controls</h2>
    <script type="text/javascript" >
jQuery(document).ready(function()
{
	jQuery("#datatype").change(function(){

    		if (jQuery('#datatype').val() == "integer")
    		{
    			jQuery('#valueInt').css('display', '');
    			jQuery('#valueChar').css('display','none');
    		}
    		else
    		{
    			jQuery('#valueChar').css('display', '');
    			jQuery('#valueInt').css('display','none');
    		}
    		});
});

</script>
    <?php
    if (isset($_SESSION['formErrors']))
    {
    	if (strlen($_SESSION['formErrors']))
    	{
    		echo $_SESSION['formErrors'];
    	}
    }
    ?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/control.php">
	  <table>
	    <tr>
	       <td>
	         Section:
	       </td>
	       <td>
	         <input  <?php if ($showMouseOvers){echo 'title="Enter Section Name"';}?>type="text" name="sectionName" value="<?php echo  $control->section;?>"/>
	       </td>
	    </tr>
	    <tr>
	       <td>
	         Key:
	       </td>
	       <td>
	         <input  <?php if ($showMouseOvers){echo 'title="Enter Key Value"';}?>type="text" name="keyName" value="<?php echo  $control->key;?>"/>
	       </td>
	    </tr>
	    <tr>
	       <td>
	         DataType:
	       </td>
	       <td>
	       <?php DebugText("dataType:".$control->datatype);?>
	         <select id="datatype" name="datatype"  <?php if ($showMouseOvers){echo 'title="Select Data Type"';}?>>
	         <option value="text" <?php if ($control->datatype=="text"){echo "selected='selected'";}?>>Text</option>
	         <option value="integer" <?php if ($control->datatype=="integer"){echo "selected='selected'";}?>>Integer</option>

	         </select>
	       </td>
	    </tr>

	    <?php
	    $style="";
	    if ($control->datatype=="text")
	    {
	    	$style =  'style="display: none;"';
	    }
	    ?>
	    <tr id="valueInt" <?php echo $style;?>>
	       <td>
	         valueInt:
	       </td>
	       <td>
	         <input <?php if ($showMouseOvers){echo 'title="Enter Integer Value"';}?> type="text" name="valueInt" value="<?php echo  $control->valueInt;?>"/>
	       </td>
	    </tr>

	    <?php
	    $style="";
	    if ($control->datatype=="integer")
	    {
	    	$style =  'style="display: none;"';
	    }
	    ?>
	    <tr id="valueChar" <?php echo $style;?>>
	       <td class="alignTop">
	         valueChar:
	       </td>
	       <td>
	         <textarea <?php if ($showMouseOvers){echo 'title="Enter Text Value"';}?> name="valueChar" rows="5" cols="50"><?php echo $control->valueChar;?></textarea>
	       </td>
	    </tr>
        <?php
        if ($permission->hasPermission("Developer"))
        {
        ?>
	    <tr>
	      <td>
	      Developer
	      </td>
	      <td>
	        <input  <?php if ($showMouseOvers){echo 'title="Select if this is only available to a Developer"';}?>type="checkbox" class="checkbox" name="developer" value="1" <?php if ($control->developer){echo "checked";}?> />
	      </td>
	    </tr>
	    <?php
        }
        ?>
	    <tr>
	      <td>
	        &nbsp;
	        <input type="hidden" name="ajaxFormKey" value="<?php echo getAJAXFormKey();?>" />
	        <input type="hidden" name="submitTest" value="1"/>
	        <input type="hidden" name="controlId" value="<?php echo $control->controlId;?>"/>
	      </td>
	      <td><input type="submit" name="submit" value="<?php echo $button;?>"/>
	      </td>
	    </tr>
	  </table>
	</form>
</div>
<?php
$_SESSION['formErrors'] ="";
?>
