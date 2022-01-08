<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once('pagetitles.php');
    $page_title = CI_ADD_COLLEGE;
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
        <h1>Add College Profile</h1>
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
        
            $display_add_college_form = true;
            
            if (isset($_POST['add_college_profile'], $_POST['name'], $_POST['city_location'], $_POST['state_location'], 
                      $_POST['average_act'], $_POST['average_tuition'], $_POST['pros'], $_POST['cons'])) {
            
                $display_add_college_form = false;
                
                require_once('college.php');
                require_once('dbconnection.php');
                
                $college = new college($_POST['name'], $_POST['city_location'], $_POST['state_location'],
                        $_POST['average_act'], $_POST['average_tuition'], $_POST['pros'], $_POST['cons']);
                        
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                   or trigger_error('Error connecting to MySQL server for ' .
                                    DB_NAME, E_USER_ERROR);
            
                $search_term = isset($_POST['search']) ? $_POST['search'] : '';
            
                $sql = 'SELECT * FROM college_CI WHERE id LIKE ?';

                                
                if ($stmt = mysqli_prepare($dbc, $sql)) {
            
                    $search_term = '%' .$search_term . '%';
            
                    mysqli_stmt_bind_param($stmt, 's', $search_term);
                
                    mysqli_stmt_execute($stmt);
            
                    $result = mysqli_stmt_get_result($stmt);
                
                    $name = $college->getName();
                    $city = $college->getCity();
                    $state = $college->getState();
                    $act = $college->getAct();
                    $tuition = $college->getTuition();
                    $pros = $college->getPros();
                    $cons = $college->getCons();
                    $user_id = $_SESSION['user_id'];
            
                    $query = "INSERT INTO college_CI (name, city_location, state_location," 
                        . " average_act, average_tuition, pros, cons, user_id)"
                        . "VALUES ('$name', '$city', '$state', '$act', '$tuition', '$pros',"
                        . " '$cons', '$user_id')";
                                
                    $result = mysqli_query($dbc, $query)
                        or trigger_error(mysqli_error($dbc), E_USER_ERROR);
                }
                
                ?>
                <h1>Following College Details were added for: <?= $college->getName() ?></h1>
                
                <table class="table table-striped">
                  <hr/>
                  <tbody>
                    <tr>
                      <th scope="row">Location:</th>
                      <td><?= $college->getCity() . ", " . $college->getState() ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Average ACT:</th>
                      <td><?= $college->getAct() ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Average Tuition:</th>
                      <td><?= "$" . $college->getTuition() ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Pros:</th>
                      <td><?= $college->getPros() ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Cons:</th>
                      <td><?= $college->getCons() ?></td>
                    </tr>
                  </tbody>
                </table> 
                <p>Would you like to <a href='<?= $_SERVER['PHP_SELF'] ?>'> add another college</a>?</p>
                <?php
            }
            if ($display_add_college_form) { ?>
            
                <form class="needs-validation" novalidation method="POST"
                      action="<?= $_SERVER['PHP_SELF'] ?>">
                  <div class="form-group row">
                    <label for="name"
                            class="col-sm-2 col-form-label-lg">Name:</label>
                    <div class="col-sm-4">
                      <input type="text"
                              class="form-control"
                              id="name"
                              name="name"
                              placeholder="Enter the college's name" required>
                      <div class="invalid-feedback">
                        Please provide a valid name.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="city_location"
                            class="col-sm-2 col-form-label-lg">City:</label>
                    <div class="col-sm-4">
                      <input type="text"
                              class="form-control"
                              id="city_location"
                              name="city_location"
                              placeholder="Enter the college's City" required>
                      <div class="invalid-feedback">
                        Please provide a valid city.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="state_location"
                            class="col-sm-2 col-form-label-lg">State:</label>
                    <div class="col-sm-4">
                      <input type="text"
                              class="form-control"
                              id="state_location"
                              name="state_location"
                              placeholder="Enter the college's State" required>
                      <div class="invalid-feedback">
                        Please provide a valid city.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="average_act"
                            class="col-sm-2 col-form-label-lg">Average ACT (1-36):</label>
                    <div class="col-sm-4">
                      <input type="number"
                              class="form-control"
                              id="average_act"
                              name="average_act"
                              placeholder="Enter the college's average ACT" required>
                      <div class="invalid-feedback">
                        Please provide a valid ACT.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="average_tuition"
                            class="col-sm-2 col-form-label-lg">Average Tuition:</label>
                    <div class="col-sm-4">
                      <input type="number"
                              class="form-control"
                              id="average_tuition"
                              name="average_tuition"
                              placeholder="Enter the college's average tuition" required>
                      <div class="invalid-feedback">
                        Please provide a valid number.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="pros"
                            class="col-sm-2 col-form-label-lg">Pros:</label>
                    <div class="col-sm-4">
                      <textarea class="form-control"
                              id="pros"
                              name="pros" required>Enter the pros of going to this college
                      </textarea>
                      <div class="invalid-feedback">
                        Please provide a valid text.
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="cons"
                            class="col-sm-2 col-form-label-lg">Cons:</label>
                    <div class="col-sm-4">
                      <textarea class="form-control"
                              id="cons"
                              name="cons" required>Enter the cons of going to this college
                      </textarea>
                      <div class="invalid-feedback">
                        Please provide a valid text.
                      </div>
                    </div>
                  </div>
                  
                  <button class="btn btn-primary" type="submit"
                          name="add_college_profile">Add College
                  </button>
                </form> 
            
      <?php } ?>
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
      <?php
        }
      ?>
      
      </div>
    </div>
  </body>
</html>
