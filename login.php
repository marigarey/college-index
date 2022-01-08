<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once('pagetitles.php');
    $page_title = CI_LOG_IN;
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
        <h1>Login to College Index!</h1>
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
        if (empty($_SESSION['user_id']) && isset($_POST['login_submission'])) {
            
            $user_name = $_POST['user_name'];
            $password = $_POST['password'];
            
            if (!empty($user_name) && !empty($password)) {
                
                require_once('dbconnection.php');
                require_once('queryutils.php');
                
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        or trigger_error('Error connection to MySQL server for'
                            . DB_NAME, E_USER_ERROR);
                
                $query = "SELECT id, user_name, password_hash, access_privileges
                         FROM user_CI WHERE user_name = ?";
                         
                $results = parameterizedQuery($dbc, $query, 's', $user_name)
                        or trigger_error(mysqli_error($dbc), E_USER_ERROR);
                         
                if (mysqli_num_rows($results) == 1) {
                    
                    $row = mysqli_fetch_array($results);
                    
                    if (password_verify($password, $row['password_hash'])) {
            
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        $_SESSION['access'] = $row['access_privileges'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        
                        header('Location: index.php');
                    }
                    else {
                        echo "<h4><p class='text-danger'>An incorrect user name or password was entered.</p></h4><hr/>";
                    }
                }
                elseif (mysqli_num_rows($results) == 0) {
                    echo "<h4><p class='text-danger'>An account does not exist for this username:"
                        . "<span class='font-weight-bold'> ($user_name) </span>."
                        . "Please use a different user name.</p></h4><hr/>";
                }
                else {
                    echo "<h4><p class='text-danger'>You should not be here</p></h4><hr/>";
                }
            }
            else {
                echo "<h4><p class='text-danger'>You must enter both a user name and password.</p></h4><hr/>";
            }
        }
        if (empty($_SESSION['user_id'])):
            ?>
            <form class="needs-validation" novalidate method="POST"
                  action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="form-group row">
                    <label for="user_name" class="col-sm-2 col-form-label-lg">User Name</label>
                    <div class="col-sm-4">
                        <input type="text"
                               class="form-control"
                               id="user_name"
                               name="user_name"
                               placeholder="Entered a user name" required>
                        <div class="invalid-feedback">
                            Please provide a valid user name.
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label-lg">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control"
                               id="password"
                               name="password"
                               placeholder="Enter a password" required>
                        <div class="invalid-feedback">Please provide a valid password.</div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="login_submission">Login In</button>
            </form>
        
        <p>If you are a new user, click <a href="signup.php">here</a> to create one!</p>
        <?php
        elseif (isset($_SESSION['user_name'])):
            require_once('pagetitles.php');
            $page_title = E_INDEX_LOGIN;
            echo "<h4><p class='text-success'>You are logged in as:
                <strong>{$_SESSION['user_name']}</strong>.</p></h4>";
            header("Location: index.php");
        endif;
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
