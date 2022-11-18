<script language="javascript" src="/js/validate_form.js"></script>
<script language="javascript" src="/js/ajax.js"></script>

<script language="javascript">

function validateForm(theForm)
{
  if (!validRequired(theForm.password,"Password"))
  {
    return false;
  }
  if (!validRequired(theForm.password2,"Confirmation password"))
  {
    return false;
  }
  var p1 = document.getElementById('password');
  var p2 = document.getElementById('password2');
  if (p1.value!= p2.value)
  {
    alert("Passwords do not match");
	return false;
  }
  return true;
}
</script>
<?php
include_once "tracker/tmpLink.php";
$key = "";
$userId = 0;
$canReset = 0;
parse_str($_SERVER['REQUEST_URI'],$params);
if (isset($params['userId']))
{
	$userId = $params['userId'];
}
if (isset($params['key']))
{
	$key = $params['key'];
}
DebugText("userId:".$userId);
DebugText("key:".$key);
if (strlen($key) && strlen($userId))
{
	$yesterday = date("Y-m-d H:i:s", time() - 60 * 60 * 24);
	
	$tmpLink = new TmpLink();
	$param = AddEscapedParam("","rndString",$key);
	$param = AddEscapedParam($param,"userId",$userId);
	$param = AddParam($param,"ts>'$yesterday'");
	if ($tmpLink->Get($param))
	{
		$canReset=1;
	}
	$user = new User();
	$user->GetById($userId);
}
?>

    <h2 id="post-">Reset Password</h2>
    <div class="postwrap fix">	
	  <div class="post-8 page type-page hentry" id="post-8">
		<div class="copy fix">
		  <div class="textcontent">
			<p>Reset Password </p>
            <div class="wpcf7" id="f1-p8-o1">
              <?php
              if ($canReset)
              {
              	$user->GetById($tmpLink->userId);
              	$user->password = $tmpLink->password;
              	$user->SetPassword();
              	echo "The password has been reset to : ".$tmpLink->password;
              	$tmpLink->Delete();
              }
              else
              {
              	echo "Password reset is invalid";
              }
              ?>
			  
			</div>
          </div>	
		  <div class="tags">
					&nbsp;
		  </div>
		</div>
	  </div><!--post -->
    </div>
	<div class="clear"></div>
