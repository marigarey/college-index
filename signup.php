<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once('pagetitles.php');
    $page_title = CI_SIGN_UP;
?>
<html>
  <head>
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" 
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" 
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" 
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" 
            crossorigin="anonymous"></script>
    <title><?= $page_title ?></title>
  </head>
  
  <header>
    <div class="card">
      <div class="jumbotron">
        <h1>Sign Up to become an Editor!</h1>
        <nav class="navbar navbar-expand-lg">
          <a class="navbar-brand" href="index.php">Home</a>
          <button class="navbar-toggler" 
                  type="button"
                  data-toggle="collapse"
                  data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent"
                  aria-expanded="false"
                  aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse"
               id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            
        <?php
          if (!isset($_SESSION['user_id'])) {
        ?>
              <li class="nav-item active">
                <a class="nav-link" href="signup.php">Sign Up <span class="sr-only">(current)</span></a>
              </li>
              <li>
                <a class="nav-link" href="login.php">Login</a>
              </li>
        <?php
          }
          elseif (isset($_SESSION['user_id'])) {
        ?>
              <li>
                <a class="nav-link" href="userProfile.php">Profile</a>
              </li>
              <li>
                <a class="nav-link" href="addCollege.php">Add College</a>
              </li>
              <li>
                <a class="nav-link" href="logout.php">Logout - (<?= $_SESSION['user_name'] ?>)</a>
              </li>
        <?php
          }
        ?>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </header>
  
  <body>
    <div class="card">
      <div class="card-body">
      
      <?php
        if (isset($_POST['sign_up'])) {
            $user_name = $_POST['user_name'];
            $password = $_POST['password']; 
            
            if (!empty($user_name) && !empty($password)) {
                require_once('dbconnection.php');
                require_once('queryutils.php');
                  
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        or trigger_error(
                            'Error connecting to MySQL server for'
                            . DB_NAME, E_USER_ERROR);
                  
                // check if user already exists
                $query = "SELECT * FROM user_CI WHERE user_name = ?";
                  
                $results = parameterizedQuery($dbc, $query, 's', $user_name)
                        or trigger_error(mysqli_error($dbc), E_USER_ERROR);
                        
                if (mysqli_num_rows($results) == 0) {
                    $salted_hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO user_CI (user_name, password_hash)
                            VALUES ('$user_name', '$salted_hashed_password')";
                              
                    $result = mysqli_query($dbc, $query)
                      or trigger_error('Error querying database', E_USER_ERROR);
                          
                    echo "<h4><p class='text-success'>Thank you for signing up <strong>$user_name</strong>!<br> "
                          . "Your new profile has been successfully created!<br></p></h4> ";
                ?><h4 class='text-success'>You may now click <a href="login.php">here</a> to login!</h4><?php
                }
                else {
                    ?><h4><p class='text-danger'>An account already exists for this username. <a href="signup.php">Please user a different user name</a>.</p></h4><hr/>
                    <?php
                }
            }
        }
        else {
      ?>
      <form class="needs-validation" novalidate method="POST"
            action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group row">
          <label for="user_name"
                  class="col-sm-2 col-form-label-lg">User Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control"
                    id="user_name" name="user_name"
                    placeholder="Enter a user name" required>
            <div class="invalid-feedback">
              Please provide a valid user name.
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="password"
                  class="col-sm-2 col-form-label-lg">Password</label>
          <div class="col-sm-4">
            <input type="password" class="form-control"
                    id="password" name="password"
                    placeholder="Enter a password" required>
            <div class="form-group form-check">
              <input type="checkbox"
                      class="form-check-input"
                      id="show_password_check"
                      onclick="togglePassword()">
              <label class="form-check-label"
                      for="show_password_check">Show Password</label>
            </div>
            <div class="invalid-feedback">
              Please Provide a valid password.
            </div>
          </div>
        </div>
        <button class="btn btn-primary" type="submit"
                name="sign_up">Sign Up
        </button>
      </form>
      <?php
        }  
      ?>
      <script>
        (function() {
        'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false); 
                });
            }, false);
        })();
        // Toggles between showing and hiding the entered password
        function togglePassword() {
            var password_entry = document.getElementById("password");
            if (password_entry.type === "password") {
                password_entry.type = "text";
            } else {
                password_entry.type = "password";
            }
        } 
      </script>
      </div>
    </div>
  </body>
</html>
