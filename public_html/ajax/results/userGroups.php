<?php
//
//  AdSys - Version 1.0
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
include "globals.php";
include_once "cmsdb.php";
include_once "tracker/userGroup.php";
include_once "tracker/permission.php";
PageAccess("Config: User Group");
/*
if (!validateFormKey())
{
	exit();
}
*/
$permission = new Permission();
$userGroup = new UserGroup();
$user = new User($_SESSION['userId']);
$userGroup->SetPerPage(25);
$param = AddEscapedParam("","sectionValue",$user->initials);
$param = AddParam($param,"keyValue='numRowsPerPage'");
if($control->Get($param))
{
  	$userGroup->SetPerPage($control->valueInt);
}

$page = 1;
$param = "active = 1";
$param = "";
if (isset($_POST['page']))
{
	$page = $_POST['page'];
}
if (!isNumeric($page))
{
	$page=1;
}
if (isset($_POST['adRepId']))
{
	$adRepId = $_POST['adRepId'];
	if ($adRepId)
	{
		$param = AddEscapedParam($param,'adrepId',$adRepId);
	}
}
if (isset($_POST['name']))
{
	if (strlen(trim($_POST['name'])))
	{
	  $name = "%".trim($_POST['name'])."%";
	  $param = AddEscapedLikeParam($param,'fullName',$name);
	}
}
$pages = 1;
$numRows = $userGroup->Count($param);
if ($userGroup->perPage)
{
	$pages = ceil($numRows/$userGroup->perPage);
}
$userGroup->SetPage($page);
include $sitePath."/design/pagination/upper.php";
?>
    <div class="main_rlist">
	  <ul>
		  <?php
		  $cnt = ($page-1) * $userGroup->perPage+1;
		  //$userGroup->SetOrderBy("startDate desc, postId desc");
		  $ok = $userGroup->Get($param);
		  while ($ok)
		  {

		    ?>
      <li class='mritem' id='<?php echo $userGroup->userGroupId;?>'>

        <?php echo '<span class="userGroup_name">'.$userGroup->name.'</span>';?>

          <span class='list_num'><?php echo $cnt++;?>.</span>
          <?php
          include $sitePath."/design/actions/userGroup.php";
          echo $htmlAction;
          ?>
      </li>
		<?php
		     $ok = $userGroup->Next();

		 }
		?>
	  </ul>
    </div>
<?php include $sitePath."/design/pagination/lower.php";?>
<script language="javascript">
    	$("body").removeClass("waitng");
    	$("body").addClass("waitOver");
</script>    	
<?php DebugOutput();?>