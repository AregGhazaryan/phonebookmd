<div class="jumbotron shadow-1 cornered pt-4 pb-3">
  <?php display() ?>
  <div class="row">
    <div class="col">
      <form enctype="multipart/form-data" method="post">
        <div class="img-container">
          <img id="blah" src="<?php echo ROOT_PATH; ?>/Assets/img/avis/<?php echo $data['img']; ?>" class="rounded-circle float-left shadow-2 img-fluid" alt="...">
          <label class="btn-bs-file btn btn-primary">
            Change Profile Picture
            <input name="image" id="imgInp" type="file" accept="image/x-png,image/gif,image/jpeg">
          </label>
        </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="fname" class="bmd-label-floating">First Name</label>
        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $data['f_name']?>">
      </div>
      <div class="form-group">
        <label for="lname" class="bmd-label-floating">Last Name</label>
        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $data['l_name']?>">
      </div>
      <div class="form-group">
        <label for="email" class="bmd-label-floating">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email']?>">
      </div>
      <div class="form-group">
        <label for="password" class="bmd-label-floating">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
    </div>
    <hr class="w-100 mt-5">
    <div class="w-100">
      <a class="btn btn-outline-danger ml-4 float-right" href="<?php echo ROOT_PATH . '/users/' . $_SESSION['user_data']['id'] . '/profile'?>">Cancel</a>
      <input type="submit" class="btn btn-outline-success float-right" value="Save" name="submit">
    </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
$("#imgInp").change(function() {
  readURL(this);
});
});
</script>
