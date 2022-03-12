<?php
$insert = false;
if (isset($_POST['name'])) {

    // Set connection variables
    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server, $username, $password);
    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    //echo "Success connecting to the db";

    // Collect post variables
    $name = $_POST['name'];
    $email = $_POST['email'];
   
    $sql = "INSERT INTO `project`.`new_idea` (`name`,`E-mail`,`Time`) VALUES ('$name','$email',current_timestamp());";

    if ($con->query($sql) == true) {
        echo "Successfully inserted";
       
        
        // Flag for successful insertion

    } else {
        echo "ERROR: $sql <br> $con->error";
    }


    // Close the database connection
    $con->close();

}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
  <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;900&display=swap"
      rel="stylesheet"
    />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--stopwatch stuff-->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- P5.js  -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/p5.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.dom.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.9.0/addons/p5.sound.min.js"></script>
  <title>Path Finder</title>


</head>

<body style="font-family: 'Raleway', sans-serif;">
  <!-- <button id="somebutton" type="button" class="btn btn-success" onclick="start()">Start</button> -->
  <div class="container-fluid w-100 m-0 p-0" style="height: 100vh;">
    <nav class="navbar navbar-expand-lg navbar-light">
      
        <a class="navbar-brand" >
          <h3><strong>Path Finder</strong></h3>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto nav-fill w-100 align-items-center">
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Algorithms
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#" onclick="dropdown(event)">A* Search</a>
                <a class="dropdown-item" href="#" onclick="dropdown(event)">Dijkstra</a>
                <a class="dropdown-item" href="#" onclick="dropdown(event)">Breadth First Search</a>
                <a class="dropdown-item" href="#" onclick="dropdown(event)">Depth First Search</a>
                <a class="dropdown-item" href="#" onclick="dropdown(event)">Greedy Best First Search</a>
              </div>
            </li>
            <li class="nav-item">
              <button class="btn btn-dark my-2 my-sm-0" id="startButton" type="submit">Start</button>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#" onclick="throwObstacles()">Throw Obstacles<span
                  class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#" onclick="resetCanvas()">Clear<span class="sr-only">(current)</span></a>
            </li>
            <div class="row justify-content-end text-center">
              <div class="col-12"><p class="p-0 m-0" style="font-size: 14px;">by <span style="font-size: 18px; color: black; font-weight: bolder; letter-spacing: 5px; text-shadow: 3px 2px 5px rgba(0, 0, 0, 0.767);"><a style="color: black; text-decoration: none;" >&lt;NVA&gt;</a></span></p></div>              
            </div>
          </ul>
        </div>
     
    </nav>

    <div class="container-fluid pt-4 pb-0">
      <div class="row text-center" style="font-size: 23px;">
        <div class="col-sm-6 col-md">
          <div>
            <span class="circle"
              style="height:20px; width:20px; background-color:rgb(87,50,168); border-radius: 80% ; display: inline-block;"></span>
            Source
          </div>
        </div>
        <div class="col-sm-6 col-md">
          <div>
            <span class="circle"
              style="height:20px; width:20px; background-color:rgb(140,68,20); border-radius: 80%; display: inline-block;"></span>
            Destination
          </div>
        </div>
        <div class="col-sm-6 col-md">
          <div>
            <span class="square"
              style="height:20px; width:20px; background-color:rgb(44, 40, 40);border-radius: 80%;  display: inline-block;"></span>
            Obstacles
          </div>
        </div>
        <div class="col-sm-6 col-md">
          <div>
            <span class="square"
              style="height:20px; width:20px; background-color:rgb(45, 196, 129);border-radius: 80%;  display: inline-block;"></span>
            Unxplored Nodes
          </div>
        </div>
        <div class="col-sm-6 col-md">
          <div>
            <span class="square"
              style="height:20px; width:20px; background-color:rgb(255, 205, 205);border-radius: 80%;  display: inline-block;"></span>
            Explored Nodes
          </div>
        </div>
        <div class="col-sm-6 col-md">
          <div>
            <span class="round"
              style="height:20px; width:20px; background-color:rgb(255, 0, 200);border-radius: 80%;  display: inline-block;"></span>
            Path
          </div>
        </div>
      </div>
      <div class="row align-items-center" style="min-height: 60px;">
        <div class="col text-center">
          <span id="message" style="font-style: italic;"></span>
        </div>
      </div>
    </div>
      <!-- inputing data..... -->
      <form action="index.php" method="post">
      <div class="row">
        <span>
          <input class="slide-up" id="name" type="text" placeholder="Enter your name " required/><label for="Name">Name </label>
        </span>
        <span>
          <input class="slide-up" id="E-mail" type="text" placeholder="Enter your mail" required/><label for="E-mail">E-mail</label>
        </span>
        <button class="login100-form-btn">
          Submit
      </button>
      </div>
      </form>
    <!--stopwatch stuff-->
    <div class="clock">
    <span id="seconds">00</span>:<span id="tens">00</span>
  </div>


    <div id="sketch01" style="position: relative;"> </div>
  </div>
<div class="login">
  <div class="module">
    
  </div>
</div>

  <!-- Optional JavaScript -->
  <script type="text/javascript" src="sketch.js"></script>
  <!---script src="script.js"></script-->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>