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
include "globals.php";
include_once "cmsdb.php";
include_once "tracker/user.php";
include_once "tracker/permission.php";

PageAccess("Config: User");
/*
if (!validateFormKey())
{
	exit();
}
*/
$permission = new Permission();
$user = new User($_SESSION['userId']);
$user->SetOrderBy("fullName");
$user->SetPerPage(25);
$param = AddEscapedParam("","sectionValue",$user->initials);
$param = AddParam($param,"keyValue='numRowsPerPage'");
if($control->Get($param))
{
  	$user->SetPerPage($control->valueInt);
}

$page = 1;
//$param = "active = 1";
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
$name = GetTextField("searchName");
if (strlen($name))
{
  $_SESSION['searchName'] = $name;
  $name = "%".trim($_POST['searchName'])."%";
  $param = AddEscapedLikeParam($param,'fullName',$name);
}
$email = GetTextField("searchEmail");
if (strlen($email))
{
  $_SESSION['searchEmail'] = $email;
  $name = "%".$name."%";
  $param = AddEscapedLikeParam($param,'email',$email);
}
$active = GetTextField("searchActive");
if ($active == -1)
{
	$active = "";
}
if (strlen($active))
{
  $_SESSION['searchActive'] = $active;
  $param = AddEscapedLikeParam($param,'active',$active);
}$numRows = $user->Count($param);
$pages = 1;
if ($user->perPage)
{
	$pages = ceil($numRows/$user->perPage);
}
$user->SetPage($page);
include $sitePath."/design/pagination/upper.php";
?>
    <div class="main_rlist">
	  <ul>
		  <?php
		  $cnt = ($page-1) * $user->perPage+1;
		  //$user->SetOrderBy("startDate desc, postId desc");
		  $ok = $user->Search($param);
		  while ($ok)
		  {

		    ?>
      <li class='mritem' id='<?php echo $user->userId;?>'>

        <?php echo '<span class="user_name">'.$user->fullName.'</span>';?>

          <span class='list_num'><?php echo $cnt++;?>.</span>
          <?php
          include $sitePath."/design/actions/user.php";
          echo $htmlAction;
          ?>
      </li>
		<?php
		     $ok = $user->Next();

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
