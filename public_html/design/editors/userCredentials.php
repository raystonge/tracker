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
