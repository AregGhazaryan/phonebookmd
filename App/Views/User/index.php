<div class="jumbotron shadow-1 cornered pt-4 pb-3">
  <div class="row">
    <div class="col">
      <div class="img-container w-100">
        <img src="<?php echo ROOT_PATH; ?>/Assets/img/avis/<?php echo $data['img']; ?>" class="rounded-circle float-left shadow-2 profile-img" alt="...">
      </div>
    </div>
    <div class="col">
      <ul class="list-unstyled">
        <li class="pt-4">Fullname : <?php echo $data['f_name'] . " " . $data['l_name']; ?></li>
        <li class="pt-4">Email : <?php echo $data['email']; ?></li>
      </ul>
    </div>
    <hr class="w-100">
    <div class="w-100">
      <a href="<?php echo ROOT_PATH; ?>/users/<?php echo $_SESSION['user_data']['id'];?>/edit"><button type="button" class="btn btn-outline-info float-right">Edit Info</button></a>
    </div>
  </div>
</div>
