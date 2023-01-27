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
PageAccess("Asset: Account Info");
include_once "tracker/assetType.php";
include_once "tracker/asset.php";
include_once "tracker/contract.php";
?>
<div class="adminArea">
<?php
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$asset = new Asset($assetId);
$assetType = new AssetType($asset->assetTypeId);
include $sitePath."/design/asset/assetInfoHeader.php";

?>
<style>
.dialog{
  border:5px solid #666;
  padding:10px;
  background:#3A3A3A;
  position:absolute;
  display:none;
}
</style>
<script type="text/javascript">
$userPassword = "<?php echo $_SESSION['userPassword'];?>";
</script>
<div id='main_column'>
	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/asset/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>
       <div class="clear"></div>
       <?php
       if (FormSuccess())
       {
       	DisplayFormSuccess();
       }
       ?>

       <div id='tab-editor'>
         <form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/asset/account.php">
           <table>
             <tr>
               <td>
                 Admin Account:
               </td>
               <td>
                 <?php CreateTextField("adminUser",$asset->adminUser,getFieldSize("asset", "adminUser"));?>
               </td>
             </tr>
             <tr>
               <td>
               Admin Password:
               </td>
               <td>
                <?php
                 $formPWDField="show";
                 $formPWDPrompt="hide";
                 if (strlen($asset->adminPassword))
                 {
                    // $formPWDField="hide";
                     $formPWDPrompt="show";

                 }
                ?>
                <div id="formPWDField" class="<?php echo $formPWDField;?>">
                 <?php CreatePasswordField("adminPassword",$asset->adminPassword,getFieldSize("asset", "adminPassword"));?>
                </div>
                <div id="formPWDprompt" class="<?php echo $formPWDPrompt;?>">
                   <input type="button" class="button" value="Show Password" id="btn1">
                    <div class="dialog" id="myform">
    <form>
      <label id="valueFromMyButton">
      </label>
      <input type="password" id="name">
      <div align="center">
        <input type="button" value="Ok" id="btnOK">
      </div>
	</form>
  </div>
                </div>
               </td>
             </tr>
             <tr>
               <td>
               <?php
               CreateHiddenField("assetId",$asset->assetId);
               PrintFormKey();
               CreateHiddenField("submitTest",1);
               CreateSubmit("submit");
               ?>
               </td>
               <td>
                 <?php PrintNBSP();?>
               </td>
             </tr>
           </table>
         </form>
       </div>

</div>
</div>
