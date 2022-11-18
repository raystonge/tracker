<?php
/*
 * Created on Feb 26, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }

    if (FormErrors()) 
    {
       	$assetToAsset->serialNumber = GetTextFromSession('assetSerialNumber');
    }
?>
Software: <?php echo $asset1->make." ".$asset1->model;?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/asset/assetAssignSerialNumber.php">
 <table>
   <tr>
     <td>
       Serial Number:
     </td>
     <td>
       <?php CreateTextField("serialNumber",$assetToAsset->serialNumber,getFieldSize("assetToAsset","serialNumber"),"Software Serial Number");?>
     </td>
   </tr>
   <tr>
     <td>
     <?php
     PrintFormKey();
     CreateHiddenField("assetToAssetId",$assetToAssetId);
     CreateSubmit();
     ?>
     </td>
     <td>
     </td>
   </tr>
 </table>
</form>
