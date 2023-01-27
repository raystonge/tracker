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
include_once "tracker/asset.php";
$asset = new Asset($assetId);
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> Controls</h2>
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
    if (isset($_SESSION['formErrors']))
    {
    	if (strlen($_SESSION['formErrors']))
    	{
    		echo $_SESSION['formErrors'];
    	}
    }
    ?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/assetCredentials.php">
	  <table>
	    <tr>
	       <td>
	         User:
	       </td>
	       <td>
	         <input  <?php if ($showMouseOvers){echo 'title="Enter Username"';}?>type="text" name="userName" value="<?php echo  $assetCredentials->userName;?>"/>
	       </td>
	    </tr>
	    <tr>
	       <td>
	         Password:
	       </td>
	       <td>
	         <input  <?php if ($showMouseOvers){echo 'title="Enter Password"';}?>type="text" name="password" value="<?php echo  $assetCredentials->password;?>"/>
	       </td>
	    </tr>
	    <tr>
	      <td>
	        &nbsp;
	        <?php PrintFormKey();?>
	        <input type="hidden" name="submitTest" value="1"/>
	        <input type="hidden" name="assetId" value="<?php echo $assetId;?>"/>
	        <input type="hidden" name="assetCredentialsId" value="<?php echo $assetCredentials->assetCredentialsId;?>"/>
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
