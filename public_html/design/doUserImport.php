<?php
//
//  Tracker - Version 1.6.0
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
include_once "tracker/user.php";
include_once "tracker/userGroup.php";
include_once "tracker/userToGroup.php";
include_once "tracker/organization.php";
include_once "tracker/userToOrganization.php";
include_once "tracker/permission.php";
//ProperAccessValidate();
$ignoreBasicPlan = GetTextField("ignoreBasicPlan",0);
$fname = $_FILES['importFile']['tmp_name'];
$originalName = $_FILES['importFile']['name'];
$uploadPath = $siteRootPath."/tmp";
DebugText("uploadPath:".$uploadPath);
?>
<div class="adminArea">
  <h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listUsers/">Users</a></h2>
  <table width="100%">
<?php
if (is_uploaded_file($fname))
{

	$uploadfile = $uploadPath."/".$originalName;
  DebugText("uploadFile:".$uploadfile);
	if (move_uploaded_file($fname, $uploadfile))
	{
    DebugText("File uploaded");
    $handle = fopen($uploadfile,"r");
    $cnt = 1;
    while (($line = fgets($handle)) !== false)
    {
      DebugText("cnt:".$cnt);
      if ($cnt > 1)
      {
        $blocked = getCSVField($line,1);
        DebugText("cnt:".$cnt);
        DebugText("blocked:".$blocked);
        $name = getCSVField($line,6);
        $license = getCSVField($line,13);
        if ($license == "Exchange Online (Plan 1)")
        {
          $license = "";
        }
        DebugText("name:".$name);
        if (strpos($name,"@") === false)
        {
        //  echo $line."<br>";

          $email = getCSVField($line,31);
          DebugText("email:".$email);
          $param = AddEscapedParam("","email",$email);
          $param1 = AddEscapedParam("","fullName",$name);
          $param = $param." or ".$param1;
          $user = new User();
          if (!$user->Get($param) && $blocked == "False" && strlen($license))
          {
            ?>
            <tr>
              <td>
                <?php echo $name;?>
              </td>
            <?php
            $user->fullName = $name;
            $user->email = $email;
            $user->password = "Password";
            $user->Persist();
            DebugText("userId:".$user->userId);
            $userGroup = new UserGroup();
            ?>
            <td valign="top">
            <?php
            $ok = $userGroup->Get("");
            while ($ok)
            {

              $userToGroup = new UserToGroup();
              $field = "userGroup".$userGroup->userGroupId;
              if (isset($_POST[$field]))
              {
                $userToGroup->userId = $user->userId;
                $userToGroup->userGroupId = $userGroup->userGroupId;
                $userToGroup->Insert();
                echo $userGroup->name."<br>";
              }
              $ok = $userGroup->Next();
            }
            ?>
            </td>
            <td>
            <?php
            $organization = new Organization();
            $ok = $organization->Get("");
            while ($ok)
            {
              $field = "organization".$organization->organizationId;
              $userToOrganization = new UserToOrganization();
              if (isset($_POST[$field]))
              {
                echo $organization->name."<br/>";
                $userToOrganization->userId = $user->userId;
                $userToOrganization->organizationId = $organization->organizationId;
                $userToOrganization->Insert();
              }
              $ok = $organization->Next();
            }
            ?>
            </td>
            <?php
          }
          else
          {
            if ($user->userId && $blocked == "True")
            {
              ?>
              <tr>
               <td>
                 <?php echo $user->fullName;?>
               </td>
              <td valign="top">
                Inactive
              </td>
              <td>
                &nbsp;
              </td>
            </tr>
              <?php
              $user->active = 0;
              $user->Persist();
            }
          }
        }
      }
      $cnt++;
    }
    fclose($handle);
  }
}
?>
</table>
</div>
<?php
function getCSVField($line,$index)
{
  $lastPos = 0;
  $prev = 0;
  for ($i = 0; $i <$index; $i++)
  {
    $lastPos = $prev;
    $pos = strpos($line,",",$prev);
    $prev = $pos+1;
  }
  $len = $pos - $lastPos;
  $val = substr($line,$lastPos,$len);
  return $val;

}
DebugOutput();
