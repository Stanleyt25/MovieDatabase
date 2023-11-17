<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap stuff to make page look beautiful -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1 style="text-align:center"> Movie Database</h1><br>
    <h3 style="text-align:center"> Connecting Front-End to MySQL DB </h3><br>
</div>
<div class = "container">
    <form id="queryInputForm" method="post" action="">
        <div class="input-group mb-3">
  	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    	Select
  	</button>
  	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    	<a class="dropdown-item" href="#">All</a>
    	<a class="dropdown-item" href="#">Movies</a>
    	<a class="dropdown-item" href="#">TV Series</a>
    	<a class="dropdown-item" href="#">Actors</a>
  	</div>
            <input type="text" class="form-control" placeholder="Enter query" name="queryInput" id="queryInput">
            <button class="btn btn-outline-secondary" type="submit" name="submitted2" id="button-addon2">Query</button>
        </div>
    </form>
</div>
<div class="container">
	<form id="selectAlls" method="post" action="">
	    <button class="btn btn-outline-secondary" type="submit" name="submitted3" id="button-addon3">List All Motion Pictures</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted4" id="button-addon4">List All Actors</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted5" id="button-addon5">List All Series</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted6" id="button-addon6">List All Movies</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted7" id="button-addon7">List All Genres</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted8" id="button-addon8">List All Locations</button>
	</form>
</div>
<div class="container">
    <!-- important php stuff starts now -->
    <?php

        // we will now create a table from PHP side 
        echo "<table class='table table-md table-bordered'>";
        echo "<thead class='thead-dark' style='text-align: center'>";

        // initialize table headers
        // YOU WILL NEED TO CHANGE THIS DEPENDING ON TABLE YOU QUERY OR THE COLUMNS YOU RETURN
        // echo "<tr><th class='col-md-2'>Firstname</th><th class='col-md-2'>Lastname</th></tr></thead>";

        // generic table builder. It will automatically build table data rows irrespective of result
        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current() {
                return "<td style='text-align:center'>" . parent::current(). "</td>";
            }

            function beginChildren() {
                echo "<tr>";
            }

            function endChildren() {
                echo "</tr>" . "\n";
            }
        }
	
        // we want to check if the submit button has been clicked (in our case, it is named Query)
        if(isset($_POST['submitted2']))
        {
            // set query input to whatever input we get
            // ideally, we should do more validation to check for numbers, etc. 
           $queryInput = $_POST["queryInput"];
        }
	else
        {
            // if the button was not clicked, we can simply set the input to empty string 
            // in this case, we will return everything
            $queryInput = "";
        }

        // SQL CONNECTIONS
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "movies";

        try {
            // We will use PDO to connect to MySQL DB. This part need not be 
            // replicated if we are having multiple queries. 
            // initialize connection and set attributes for errors/exceptions
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    // A series of if, elseif statements to answer "Show All" queries!

	    if (isset($_POST['submitted3']))
	    {
	    // we list all the movies!
	         echo "Displaying all the motion pictures.";
		 echo "<tr><th class='col-md-2'>Motion Picture ID</th><th class='col-md-2'>Title</th><th class='col-md-2'>Rating</th><th class='col-md-2'>Production</th><th class='col-md-2'>Budget</th></tr></thead>";
	         $stmt = $conn->prepare("SELECT * FROM motionpicture");
	    }
	    elseif (isset($_POST['submitted4']))
	    {
	    // we list all the actors!
	         echo "Displaying all the actors.";
		 echo "<tr><th class='col-md-2'>Person ID</th><th class='col-md-2'>Name</th><th class='col-md-2'>Nationality</th><th class='col-md-2'>Birthday</th><th class='col-md-2'>Gender</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT * FROM people");
	    }
	    elseif (isset($_POST['submitted5']))
	    {
	    // we list all the series!
	         echo "Displaying all the series.";
		 echo "<tr><th class='col-md-2'>Title</th><th class='col-md-2'>Number of Seasons</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT mp.name, s.season_count FROM motionpicture mp, series s WHERE mp.id = s.mpid");
	    }
	    elseif (isset($_POST['submitted6']))
	    {
	    // we list all the movies!
	         echo "Displaying all the movies.";
		 echo "<tr><th class='col-md-2'>Title</th><th class='col-md-2'>Box Office Collection</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT mp.name, m.boxoffice_collection FROM movie m, motionpicture mp WHERE m.mpid = mp.id");
	    }
	    elseif (isset($_POST['submitted7']))
	    {
	    // we list all the series!
	         echo "Displaying all the genres.";
		 echo "<tr><th class='col-md-2'>Title</th><th class='col-md-2'>Genre Name</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT mp.name, g.genre_name FROM motionpicture mp, genre g WHERE mp.id = g.mpid");
	    }
	    elseif (isset($_POST['submitted8']))
	    {
	    // we list all the locations!
	         echo "Displaying all the locations.";
		 echo "<tr><th class='col-md-2'>Title</th><th class='col-md-2'>Zip Code</th><th class='col-md-2'>City</th><th class='col-md-2'>Country</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT mp.name, l.zip, l.city, l.country FROM motionpicture mp, location l WHERE mp.id = l.mpid");
	    }
	    else
	    {
	         echo "Query recieved: $queryInput... will be implemented soon! ";
		 $stmt = $conn->prepare("");
	    }
            // prepare statement for executions. This part needs to change for every query
            // $stmt = $conn->prepare("SELECT first_name, last_name FROM lab3_guests where age>=$ageLimit");

            // execute statement
            $stmt->execute();

            // set the resulting array to associative. 
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            // for each row that we fetched, use the iterator to build a table row on front-end
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
            }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo "</table>";
        // destroy our connection
        $conn = null;
    
    ?>
</div>

        <div class="container">
            <h1 style="text-align:center"> Tests on Likes</h1><br>
            <h3 style="text-align:center"> WIP Like Function </h3><br>
        </div>

        <div class = "container">
            <form id="useremailForm" method="post" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter user email, returns '1' if registered, '0' otherwise" name="inputemail" id="inputemail2">
                    <button class="btn btn-outline-secondary" type="submit" name="registered" id="button-addon2">Query</button>
                </div>
            </form>
        </div>

        <div class="container">
            <?php
                if(isset($_POST['registered']))
                {
                    $reguse = $_POST["inputemail"]; 
                    
                    // check this link later
                    // https://stackoverflow.com/questions/20640488/adding-checkboxes-to-table-populated-with-mysql
                    // may contain info on wiring up check box value with liking function

                    class TableRows2 extends RecursiveIteratorIterator {
                        function __construct($it) {
                            parent::__construct($it, self::LEAVES_ONLY);
                        }

                        function current() {
                            // return "<td style='width: 30px; border: 1px solid black;'>" . parent::current(). "</td>";
                            return "<td style='text-align:center'>" . parent::current(). "</td>";
                        }

                        function beginChildren() {
                            echo "<tr>";
                        }

                        // this is where this class tablerows 2 differs from the given code, it adds a extra check box on the right most column
                        function endChildren() {
                            echo "<td>". "<input type='checkbox' name='checkbox[]' value='' id='checkbox'>". "</td>" . "</tr>" . "\n";
                        }

                        
                    }
                    //remember to change this part based on the local database name
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "movies";

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // SQL
                        //$stmt = $conn->prepare("SELECT first_name, last_name FROM lab3_guests where age>=$ageLimit");
                        //statement that inserts a like on movie mpid 110 with user's imput email
                        //$stmt0 = $conn->prepare("INSERT INTO Likes VALUES ('110', '$reguse')");
                        //$stmt0->execute();

                        //a query that checks is the input email address a valid registered user
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM User WHERE email LIKE '$reguse' ");
                        $stmt->execute();

                        // set the resulting array to associative
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        // prints the result of the query, 1 if it is a valid user email, 0 if it is not a registered user
                        $temp = $stmt->fetchAll();
                            echo implode(" ", $temp[0]); //implode converts the array to a string
                        //should be able to use this string and verify if the user is a registered user for the like function

                        // ####################### SECTION BREAKER ##########################

                        $stmt2 = $conn->prepare("SELECT id, name FROM MotionPicture");
                        $stmt2->execute();
                        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
                        
                        echo "<table class='table table-md table-bordered'>";
                        echo "<thead class='thead-dark' style='text-align: center'>";
                
                        echo "<tr><th class='col-md-2'>Motion Picture ID</th><th class='col-md-2'>Name</th><th class='col-md-2'>Like?</th></tr></thead>";
                        
                        foreach(new TableRows2(new RecursiveArrayIterator($stmt2->fetchAll())) as $k=>$v) {
                            echo $v;
                        }

                    }
                    catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    $conn = null;
                    echo "</table>";
                    echo " ";
                }
                else
                {
                    
                }
            ?>

        </div>
	
	<div class = "container">
            <form id="likeSubmit" method="post" action="">
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary" type="submit" name="likeSubmit" id="button-addon2">Submit Likes</button>
                </div>
            </form>
        </div>

</body>
</html>