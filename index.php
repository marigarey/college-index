<!DOCTYPE html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once('pagetitles.php');
    $page_title = CI_INDEX;
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
        <h1>College Index</h1>
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
      require_once('dbconnection.php');
      
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
              or trigger_error('Error connecting to MySQL Database: ' . DB_NAME, E_USER_ERROR);
              
      $query = "SELECT * FROM college_CI WHERE approved = 'T'";
      
      $result = mysqli_query($dbc, $query)
              or trigger_error('Error querying to Database: ' . DB_NAME, E_USER_ERROR);
              
      if (mysqli_num_rows($result) > 0) {
      ?>
      
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">State</th>
            </tr>
          </thead>
          <tbody>
          <?php
          while($row = mysqli_fetch_assoc($result)) {
              echo "<tr><td><a href='collegeProfile.php?id=" . $row['id'] . "'>" . $row['name'] . "</a></td>"
                      . "<td>" . $row['state_location'] . "</td></tr>";
          }
      }
      else {
            ?><h3>No Colleges Found</h3><?php
      }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
  
  <footer class="page-footer">
    <div class="card">
      <div class="card-footer">
        <?php
        if (!isset($_SESSION['user_id'])) {
            ?><h4>Want to become an editor? Sign up <a href="signup.php">here</a>!</h4><?php  
        }
        else {
            ?><h4>Don't see a college on here? <a href="addCollege.php">Add it</a>!</h4><?php
        }
        ?>
      </div>
    </div>
  </footer>
</html>
