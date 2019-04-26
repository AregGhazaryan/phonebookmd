<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="/Assets/img/favicon.png" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/Assets/master.css">
  <!-- Material Design for Bootstrap fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <!-- Material Design Icons  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Material Design for Bootstrap CSS -->
  <link rel="stylesheet" href="/Assets/docs.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <title>Install</title>
</head>
<body>
  <div class="container">
    <?php if(fileExists()) : ?>
      <div class="jumbotron p-4 mt-5 shadow-1">
        <?php display()?>
        <?php if(firstRun()) : ?>
          <h1 class="text-center"> Welcome To App Reintallation </h1>
          <hr class="my-4">
          <div class="alert alert-danger" role="alert">
            Important, please note if selected database is not empty it will drop all the tables in it and will create new ones!
          </div>
        <?php else:?>
          <h1 class="text-center"> Welcome To First Run Configuration </h1>
        <?php endif;?>
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class='mb-0'>
          <div class="form-group">
            <label for="dbhost" class="bmd-label-floating">Database Host</label>
            <input type="text" class="form-control" id="dbhost" name="dbhost">
            <small class="form-text text-muted">Ex. localhost or 192.168.0.1</small>
          </div>
          <div class="form-group">
            <label for="dbname" class="bmd-label-floating">Database Name</label>
            <input type="text" class="form-control" id="dbname" name="dbname">
          </div>
          <div class="form-group">
            <label for="dbuname" class="bmd-label-floating">Database Username</label>
            <input type="text" class="form-control" id="dbuname" name="dbuname">
          </div>
          <div class="form-group">
            <label for="dbpass" class="bmd-label-floating">Database Password</label>
            <input type="password" class="form-control" id="dbname" name="dbpass">
          </div>
          <?php if(firstRun()) : ?>
            <input type="hidden" id="reinstall" name="reinstall" value="2">
          <?php else:?>
            <input type="hidden" id="reinstall" name="reinstall" value="1">
          <?php endif;?>
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
      </div>
    <?php endif;?>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
  <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
</body>
