<script language="javascript" src="/js/validate_form.js"></script>
<script language="javascript" src="/js/ajax.js"></script>

<script language="javascript">
function validateForm(theForm)
{
  if (!validRequired(theForm.email,"Email"))
  {
    return false;
  }
  if (!validEmail(theForm.email,"Email",1))
  {
    return false;
  }
  return true;
}
</script>

    <h2 id="post-">Forgot Password</h2>
    <div class="postwrap fix">	
	  <div class="post-8 page type-page hentry" id="post-8">
		<div class="copy fix">
		  <div class="textcontent">
			<p>If you have forgotten your password, please enter your email address and we will send you a link to reset your password.</p>
            <div class="wpcf7" id="f1-p8-o1">
			  <form action="/forgotsent/" method="post" class="form" onsubmit="return validateForm(this);">
                <p>Your Email (required)<br>
                  <span class="form-control-wrap your-email"><input name="email" type="text" class="text validates-as-email validates-as-required" id="email" size="60" >
                  </span>
			    </p>
				  <input value="Send" name="submit" class="submitButton" type="submit"> 
				  <img class="ajax-loader" style="visibility: hidden;" alt="ajax loader" src="/images/ajax-loader.gif">
				</p>
                <div class="response-output display-none"></div>
				<input type="hidden" value="0" name="validEmail" />
			  </form>
			</div>
          </div>	
		  <div class="tags">
					&nbsp;
		  </div>
		</div>
	  </div><!--post -->
    </div>
	<div class="clear"></div>
 