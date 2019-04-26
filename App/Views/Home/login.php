<div class="jumbotron shadow-1 cornered">
  <?php display();?>
  <h2>Login</h2>
  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1" class="bmd-label-floating">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="bmd-label-floating">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>
  <input type="submit" class="btn btn-raised btn-primary float-right mt-2" value="Login" name="submit">
</form>
</div>
