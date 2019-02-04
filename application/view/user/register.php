<div class="wrap">
  <div class="clear-top main-content-char-buff">
    <div class="login-container char-buff-container">

        <?php
        if (count($errorMessage) > 0) {

            foreach ($errorMessage as $error) {
                print "<div class=\"error\"> " . $error . "</div>";
            }
            print "<br>";
        }
        ?>

        <form class="form-group required register-form" name="registerform" method="post" action="register">
          <div class="form-group">
            <h2>Sign up</h2>
          </div>

          <div class="form-group">
            <label class="control-label" for"first_name">First name</label></br>
            <input required class="form-control" type='text' name ='first_name'  value="" maxlength="16"><br>
          </div>

          <div class="form-group">
            <label class="control-label" for"last_name">Last name</label></br>
            <input required class="form-control" type='text' name ='last_name'  value="" maxlength="16"><br>
          </div>

          <div class="form-group">
            <label for"email" class="control-label" >Email</label></br>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email address with anyone else.</small>
            <input required class="form-control" type='email' name ='email' value="" maxlength="50"><br>
          </div>

          <div class="form-group">
            <label class="control-label" for"password">Password</label></br>
            <input required class="form-control" type='password' name ='password' value="" maxlength="30"><br>
          </div>

          <div class="form-group">
            <label for="student" class="control-label">Are you a SFSU Student?</label><br>
            <input type='radio' name='student' value="0">No<br>
            <input type='radio' name='student' value="1">Yes<br>
          </div>

          <div>
            <p>By signing up, I agree to CharBuff's <a class="privacy-policy" target="_blank" href="<?php echo URL . 'home/privacy_policy' ?>">Privacy Policy</a></p>
          </div>
          <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
    </div>
  </div>
</div>

