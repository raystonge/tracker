<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$searchSerialNumber = GetTextField("assetSerialNumber");
$searchAssetTag = GetTextField("assetAssetTag");
?>
<form name="accessorySearch" method="post"  autocomplete="<?php echo $autoComplete;?>">
    <?php
    CreateHiddenField("assetId",$assetId);
    CreateSubmit("search","Submit"); 
    PrintAJAXFormKey();?>
</form>
<div id="una"></div>
<div class="clear"></div>