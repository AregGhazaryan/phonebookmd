<div class="jumbotron cornered shadow-1 pb-2 pt-4">
  <a class="btn btn-success bk-btn" href="<?php echo ROOT_PATH;?>/phonebook/<?php echo $_SESSION['user_data']['id']?>/index"><i class="material-icons ml-0">arrow_back</i></a>
  <div class="row">
    <div class="col">
      <div class="img-container w-100">
        <img src="<?php echo ROOT_PATH; ?>/Assets/img/userimgs/<?php echo $data['image']; ?>" class="d-block rounded-circle m-auto shadow-2 profile-img" alt="...">
      </div>
    </div>
    <div class="col">
      <ul class="list-unstyled">
        <li class="pt-4">Fullname : <?php echo $data['fname'] . " " . $data['lname']; ?></li>
        <li class="pt-4">Email : <?php echo $data['email']; ?></li>
        <li class="pt-4">Address : <?php echo $data['address']; ?></li>
        <li class="pt-4">Phone number(s) : <?php echo @$data['c']; ?></li>
      </ul>
    </div>
    <hr class="w-100">
    <div class="w-100">
      <form method="post" class='mb-0' action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type='hidden' value="<?php echo $data['uniqid']; ?>" name='uniqid'>
        <input type='hidden' value="<?php echo $_SESSION['user_data']['id']; ?>" name='id'>
        <button type='submit' name='del' class="float-right btn btn-outline-danger act-btn ml-3">Delete</button>
      </form>
      <a class="btn btn-outline-info float-right" href="<?php echo ROOT_PATH; ?>/phonebook/<?php echo $data['id'];?>/edit">Edit Info</a>
    </div>
  </div>
</div>
