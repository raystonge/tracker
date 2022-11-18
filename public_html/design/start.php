<?php
$_SESSION['requestURI'] = $_SERVER['REQUEST_URI'];
?>
<table class="width100">
  <tr>
    <td class="alignTop" width="60%">
    <br />

    </td>
    <td class="alignTop" width="40%">
      <form method="POST" action="/process/login.php" autocomplete="<?php echo $autoComplete;?>">
        <table class="width100">
          <?php
          if (isset($_SESSION['failedLogin']))
          {
          	$failedLogin = $_SESSION['failedLogin'];
          	if ($failedLogin)
          	{
          		?>
                <tr>
                  <td colspan="2">
                  Login Failed
                  </td>
                </tr>
          		<?php
          	}
          }
          ?>
          <tr>
            <td>
              Email
            </td>
            <td>
              <input type="text" name="email" id="email" />
            </td>
          </tr>
          <tr>
            <td>
              Password
            </td>
            <td>
              <input type="password" name="password" id="password" />
            </td>
          </tr>
          <tr>
            <td>
            <?php PrintFormKey();?>
              &nbsp;<input type="hidden" name="formaction" value="1"/>
            </td>
            <td>
              <input type="submit" value="Login" name"submit" />
            </td>
          </tr>
          <tr class="antiSpam">
            <td>
              Leave Blank
            </td>
            <td>
              <input type="text" name="validator">
            </td>
          </tr>
          <tr>
            <td>&nbsp;
            </td>
            <td>
              <a href="/forgot/">Forgot Password?</a>
            </td>
          </tr>
          </table>
      </form>
    </td>
  </tr>
</table>
<?php SetFocus("email");?>