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
