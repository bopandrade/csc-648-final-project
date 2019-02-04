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
        <form class="form-group required login-form" name ="loginform" method ="post" action ="login">
          <div class="form-group">
            <h2>Login</h2>
          </div>
          <div class="form-group">
            <label class="control-label" for="email">Email</label></br>
            <input required class="form-control" type='email' name ='email'  value="" maxlength="50"><br>
          </div>

          <div class="form-group">
            <label class="control-label" for="password">Password</label></br>
            <input required class="form-control" type='password' name='password'  value="" maxlength="30">
          </div>

          <div>
            <p>Don't have an account? <a class="privacy-policy" href="<?php echo URL . 'user/register' ?>">Sign up</a></p>
          </div>

          <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
  </div>
</div>

