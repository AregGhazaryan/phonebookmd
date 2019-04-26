<div class="jumbotron shadow-1 cornered pt-4">
  <?php display()?>
  <h2>User Registration</h2>
  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
      <label for="fname" class="bmd-label-floating">First Name</label>
      <input type="text" class="form-control" id="fname" name="fname">
    </div>
    <div class="form-group">
      <label for="lname" class="bmd-label-floating">Last Name</label>
      <input type="text" class="form-control" id="lname" name="lname">
    </div>
  <div class="form-group">
    <label for="email" class="bmd-label-floating">Email address</label>
    <input type="email" class="form-control" id="email" name="email">
  </div>
  <div class="form-group">
    <label for="password" class="bmd-label-floating">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <input type="submit" class="btn btn-raised btn-primary float-right mt-2" name="submit" value="Submit">
</form>
</div>
