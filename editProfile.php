<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once('pagetitles.php');
    $page_title = CI_EDIT_USER;
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
        <h1>Edit Profile</h1>
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
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            
            require_once('dbconnection.php');
        
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or trigger_error('Error connecting to MySQL server for ' . DB_NAME, E_USER_ERROR);
                
            $query = "SELECT id, first_name, last_name FROM user_CI WHERE id = $user_id";
        
            $result = mysqli_query($dbc, $query)
                    or trigger_error('Error querying database', E_USER_ERROR);
                    
            if (isset($_POST['update_profile'], $_POST['first_name'], $_POST['last_name'])) {
            
                $first = $_POST['first_name'];
                $last = $_POST['last_name'];
                
                $query = "UPDATE user_CI
                            SET first_name = '$first',
                                last_name = '$last'
                            WHERE id = '$user_id'";
                            
                mysqli_query($dbc, $query)
                    or trigger_error('Error querying database', E_USER_ERROR);
                    
                $_SESSION['first_name'] = $first;
                $_SESSION['last_name'] = $last;
                
                $nav_link = 'userProfile.php?id=' . $user_id;
                
                header("Location: $nav_link");
                exit;
            }
            else {
            ?>
                <form class="needs-validation" novalidation method="POST"
                      action="<?= $_SERVER['PHP_SELF'] ?>">
                  <div class="form-group row">
                    <label for="first_name"
                            class="col-sm-2 col-form-label-lg">First Name:</label>
                    <div class="col-sm-4">
                      <input type="text"
                              class="form-control"
                              id="first_name"
                              name="first_name"
                              value="<?=  $_SESSION['first_name'] ?>"
                              placeholder="Enter your first name" required>
                      <div class="invalid-feedback">
                        Please provide a valid first name.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="last_name"
                            class="col-sm-2 col-form-label-lg">Last Name:</label>
                    <div class="col-sm-4">
                      <input type="text"
                              class="form-control"
                              id="last_name"
                              name="last_name"
                              value="<?=  $_SESSION['last_name'] ?>"
                              placeholder="Enter your last name" required>
                      <div class="invalid-feedback">
                        Please provide a valid last name.
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-primary" type="submit"
                          name="update_profile">Update Profile
                  </button>
                </form>
            <?php
            }  
        }  
      ?>
        <script>
        (function() {
          'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filler.call(forms, function(form) {
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
        </script>
      </div>
    </div>
  </body>
</html>
