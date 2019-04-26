<div class='jumbotron cornered shadow-1 set-pad'>
  <?php displayFloat(); ?>
<h3 class="text-center mb-3">Your Contacts</h3>
<a href="<?php echo ROOT_PATH;?>/phonebook/add" class="btn btn-success mb-4 ml-4"><i class="material-icons">add</i><span class="align-middle">Add</span></a>
<table class="table text-center v-align">
  <thead>
    <tr>
      <th scope="col">Image</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Phone Number(s)</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data as $info) : ?>
      <tr>
        <td><div class="img-cont"><img class="cont-img" src="<?= ROOT_PATH;?>/Assets/img/userimgs/<?= $info['image'];?>"></div></td>
        <td class='contained align-middle'><?= $info['fname'];?></td>
        <td class='contained align-middle'><?= $info['lname'];?></td>
        <td class='contained align-middle'><?php $lol = explode(",", $info['c']); $lol=implode("<br>", $lol); echo $lol;?></td>
        <td class="align-middle">
          <div class="btn-container row">
            <a class="col btn btn-info act-btn ml-3" href='<?php echo ROOT_PATH;?>/phonebook/<?php echo $info['id'];?>/view'>Details</a>
            <a class="col btn btn-success act-btn ml-3" href='<?php echo ROOT_PATH;?>/phonebook/<?php echo $info['id'];?>/edit'>Edit</a>
            <form method="post" class="col act-form" action="<?php $_SERVER['PHP_SELF']; ?>">
              <input type='hidden' value="<?php echo $info['uniqid']; ?>" name='uniqid'>
              <input type='hidden' value="<?php echo $_SESSION['user_data']['id']; ?>" name='id'>
              <button type='submit' name='del' class="btn btn-danger act-btn ml-3">Delete</button>
            </form>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
