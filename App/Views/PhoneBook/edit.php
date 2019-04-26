<div class="jumbotron p-3 cornered shadow-1">
  <h4 class="text-center">Edit Contact</h4>
  <a class="btn btn-success bk-btn mb-5" href="<?php echo ROOT_PATH;?>/phonebook/<?php echo $_SESSION['user_data']['id']?>/index"><i class="material-icons ml-0">arrow_back</i></a>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="uniqid" value="<?php echo $data['uniqid']?>">
  <img id="blah" class="rounded img-add" src="<?php echo ROOT_PATH?>/assets/img/userimgs/<?php echo $data['image'];?>" alt=" "><br>
  <label class="ml-0 btn-bs-file btn btn-primary">
    Change Image
    <input name="image" type="file" id="imgInp">
  </label>
  <div class="form-group">
    <br>
    <label for="name">First Name</label>
    <input type="text" class="form-control" id="name" name="fname" placeholder="Enter First Name" value="<?php echo $data['fname'];?>">
  </div>
  <div class="form-group">
    <label for="lname">Last Name</label>
    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" value="<?php echo $data['lname'];?>">
  </div>
<button id="btn" class='btn add-btn btn-outline-success p-0' type="button"><i class="material-icons">add</i></button>
  <div class="form-group" id="foq">
    <label for="numbers">Phone Number(s)</label>
    <?php
    @$nums = explode(",",$data['c']);
    foreach($nums as $number){
      echo '<input type="hidden" name="oldnum[]" value="'.$number.'"><input type="text" class="form-control numbers" id="numbers" name="number[]" aria-describedby="emailHelp" placeholder="Enter Phone Number" value="'.$number.'">';
    }
    ?>
  </div>
  <div class="form-group">
    <label for="address">Address</label>
    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?php echo $data['address'];?>">
  </div>
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $data['email'];?>">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>
</div>
<script>
(function() {
  var counter = 0;
  var btn = document.getElementById('btn');
  var form = document.getElementById('foq');
  var addInput = function() {
    counter++;
    var input = document.createElement("input");
    input.id = 'input-' + counter;
    input.type = 'text';
    input.class = 'form-control';
    input.name = 'number[]';
    input.setAttribute('class', 'form-control numbers');
    input.setAttribute('maxlength', '15');
    input.placeholder = 'Number ' + counter;
    form.appendChild(input);
  };
  btn.addEventListener('click', function() {
    addInput();
  }.bind(this));
})();
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
</script>
