<div class="jumbotron p-3 pt-4 cornered shadow-1">
<h4 class="text-center mt-5">Add A New Contact</h4>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <label class="btn-bs-file btn btn-outline-primary m-0 mb-3">
    Contact Image
    <input name="image" type="file" id="imgInp">
  </label>
  <br>
  <img id="blah" src="#" alt=" ">
  <div class="form-group">
    <label for="name" class="bmd-label-floating">First Name</label>
    <input type="text" class="form-control" maxlength="50" id="name" name="fname">
  </div>
  <div class="form-group">
    <label for="lname" class="bmd-label-floating">Last Name</label>
    <input type="text" class="form-control" id="lname" maxlength="50" name="lname">
  </div>
  <button id="btn" class='btn add-btn btn-outline-success p-0' type="button"><i class="material-icons">add</i></button>
  <div class="form-group" id="foq">
    <label for="numbers" class="bmd-label-floating">Phone Number(s)</label>
    <input type="text" class="form-control" id="numbers" maxlength="15" name="number[]">
  </div>
  <div class="form-group">
    <label for="address" class="bmd-label-floating">Address</label>
    <input type="text" class="form-control" id="address" maxlength="92" name="address">
  </div>
  <div class="form-group">
    <label for="email" class="bmd-label-floating">Email address</label>
    <input type="email" class="form-control" id="email" maxlength="62" name="email" aria-describedby="emailHelp">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Add</button>
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
      $('#blah').attr('class', 'rounded img-add');
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#imgInp").change(function() {
  readURL(this);
});
</script>
