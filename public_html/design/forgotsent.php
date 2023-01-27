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
include_once "tracker/tmpLink.php";
include_once "tracker/user.php";

if (isset($_POST['submit']))
{
  $to = trim($_POST['email']);
  $email = trim($_POST['email']);
  $from = 'noreply@raywaresoftware.com';
  $subject = $siteName." Password Reset";
  $headers = 'From: '.$from . "\r\n" .
    'Reply-To: '.$from . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
  $user = new User();
  $param = "email='".mysqli_real_escape_string($link_cms,$email)."'";
  if ($user->Get($param))
  {
  	$tmpLink = new TmpLink();
  	$tmpLink->userId=$user->userId;

    $tmpLink->Insert();
  	DebugText("User account found");
    $message = "To change your password please follow the link below:\r\n";
    $message = $message. $hostPath."/resetpassword/?reset=1&userId=".$user->userId."&key=".$tmpLink->rndString;
    mail($to, $subject, $message, $headers);
  }
  else
  {
  	DebugText("user account not found");
  }
}
?>

    <h2 id="post-">Password Sent</h2>
    <div class="postwrap fix">
	  <div class="post-8 page type-page hentry" id="post-8">
		<div class="copy fix">
		  <div class="textcontent">
		    <p>Please check your email for a link to reset your password.</p><p>Also, please check your spam filter.</p>

			<?php echo $siteName;?> </div>
		  <div class="tags">
					&nbsp;
		  </div>
		</div>
	  </div><!--post -->
    </div>
	<div class="clear"></div>
