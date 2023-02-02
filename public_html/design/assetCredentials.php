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
include_once "tracker/assetCredentials.php";
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
PageAccess("Asset: User Credentials");
$userGroup = new UserGroup();
$formKey = "";
if (isset($_POST['formKey']))
{
    $formKey = strip_tags($_POST['formKey']);
}
else
{
    $formKey = getFormKey();
}
$assetId = 0;
if (isset($request_uri[2]))
{
    $assetId = $request_uri[2];
}
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}

$asset = new Asset($assetId);
$assetType = new AssetType($asset->assetTypeId);

include $sitePath."/design/asset/assetInfoHeader.php";
?>
<div class="adminArea">
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
<!--
<h2><a href="/assetEdit/<?php echo $assetId;?>/" class="breadCrumb">Asset</a></h2>
-->

<a href="/newUserCredentials/<?php echo $assetId?>/">New User Credentials</a>
<div id="results">
 <div class="main_rlist">
	  <ul>
		  <?php
		 // $cnt = ($page-1) * $userGroup->perPage+1;
		  $assetCredentials = new AssetCredentials();
		  //$userGroup->SetOrderBy("startDate desc, postId desc");
		  $param = AddEscapedParam("", "assetId", $assetId);
		  $ok = $assetCredentials->Get($param);
      $cnt = 1;
		  while ($ok)
		  {

		    ?>
      <li class='mritem' id='<?php echo $assetCredentials->assetCredentialsId;?>'>

        <?php echo '<span class="userGroup_name">'.$assetCredentials->userName.'</span>';?>

          <span class='list_num'><?php echo $cnt++;?>.</span>
          <?php
          include $sitePath."/design/actions/userCredentials.php";
          echo $htmlAction;
          ?>
      </li>
		<?php
		     $ok = $assetCredentials->Next();

		 }
		?>
	  </ul>
    </div>
</div>

  </div>
</div>
<div class="clear"></div>
</div>
</div>
