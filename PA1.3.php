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
    <h1 style="text-align:center"> Movie Database </h1><br>
    <h3 style="text-align:center"> Connecting Front-End to MySQL DB </h3><br>
</div>
<div class = "container">
    <form id="queryInputForm" method="post" action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter query" name="queryInput" id="queryInput">
	</div>
	<div class="input-group mb-3">
	    <button class="btn btn-outline-secondary" type="submit" name="submitted2" id="button-addon2">Q1: Display All Tables</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted3" id="button-addon3">Q2: Search By Motion Picture Name</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted4" id="button-addon4">Q3: Search By Email</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted5" id="button-addon5">Q4: Search By Country</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted6" id="button-addon6">Q5: Search By Zipcodes</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted7" id="button-addon7">Q6: Search By Number of Awards</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted8" id="button-addon8">Q7: Display Youngest and Oldest Award-Winning Actors</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted9" id="button-addon9">Q9: Search By Rating</button>
        <button class="btn btn-outline-secondary" type="submit" name="submitted16" id="button-addon16">Q10: Display Top 2 Thriller films shot exclusively in Boston</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted10" id="button-addon10">Q12: Display All Actors in Both Marvel and Warner Bros</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted11" id="button-addon11">Q13: Display All Movies With Higher Rating Than Comedy Average</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted12" id="button-addon12">Q14: Display Top 5 Movies With Most People</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted13" id="button-addon13">Q15: Display Actors Sharing The Same Birthday</button>
        </div>
    </form>
</div>

<div class = "container">
    <form id="queryInputForm2" method="post" action="">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter query #1" name="queryInput1" id="queryInput1">
            <input type="text" class="form-control" placeholder="Enter query #2" name="queryInput2" id="queryInput2">
	</div>
	<div class="input-group mb-3">
	    <button class="btn btn-outline-secondary" type="submit" name="submitted14" id="button-addon14">Q8: Search By Box Office Collection and Budget</button>
	    <button class="btn btn-outline-secondary" type="submit" name="submitted15" id="button-addon15">Q11: Search By Number of Likes and Age</button>
        </div>
    </form>
</div>

<div class="container">
	<form id="buttons" method="post" action="">
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

	    if (isset($_POST['submitted2']))
	    {
	    // Query 1: Display all tables
	         echo "Displaying all tables in the database.";
		 echo "<tr><th class='col-md-2'>Table Name</th></tr></thead>";
	         $stmt = $conn->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$dbname'");
	    }

	    elseif (isset($_POST['submitted3']))
	    {
	    // Query 2: We search by motion picture name!
		 $query = $_POST["queryInput"];
	         echo "Displaying all motion pictures matching the name '$query'.";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Rating</th><th class='col-md-2'>Production</th><th class='col-md-2'>Budget</th></tr></thead>";
	         $stmt = $conn->prepare("SELECT name, rating, production, budget FROM motionpicture mp WHERE mp.name='$query'");
	    }
	    elseif (isset($_POST['submitted4']))
	    {
	    // Query 3: We search by user email!
		 $query = $_POST["queryInput"];
	         echo "Displaying all movies liked by $query.";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Rating</th><th class='col-md-2'>Production</th><th class='col-md-2'>Budget</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT mp.name, mp.rating, mp.production, mp.budget FROM motionpicture mp, likes l WHERE mp.id = l.mpid AND mp.id IN (SELECT
					DISTINCT mpid FROM movie) AND l.uemail = '$query'");
	    }
	    elseif (isset($_POST['submitted5']))
	    {
	    // Query 4: We search by country!
		 $query = $_POST["queryInput"];
	         echo "Displaying all motion pictures filmed in $query.";
		 echo "<tr><th class='col-md-2'>Name</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT mp.name FROM motionpicture mp, location l WHERE mp.id = l.mpid AND l.country = '$query'");
	    }
	    elseif (isset($_POST['submitted6']))
	    {
	    // Query 5: We search for directors having shot TV series at a specified zipcode!
		 $query = $_POST["queryInput"];
	         echo "Displaying all directors having filmed a series at zipcode $query.";
		 echo "<tr><th class='col-md-2'>Director</th><th class='col-md-2'>TV Series</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT p.pname, mp.name FROM motionpicture mp, people p, location l, role r, series s WHERE l.mpid = mp.id AND mp.id = r.mpid AND r.pid = p.id AND r.role_name = 'Director' AND mp.id IN (SELECT mpid FROM series) AND l.zip = $query");
	    }
	    elseif (isset($_POST['submitted7']))
	    {
	    // Query 6: we list all the people who have received more than k rewards for one motion picture in one year!
		 $query = $_POST["queryInput"];
	         echo "Displaying all the people who won more than $query awards for one motion picture in one year.";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Title</th><th class='col-md-2'>Award Year</th><th class='col-md-2'>Award Count</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT p.pname, mp.name, a.award_year, count(*) FROM motionpicture mp, people p, award a WHERE mp.id = a.mpid AND a.pid = p.id GROUP BY a.mpid, a.pid, a.award_year having count(*) > $query");
	    }
	    elseif (isset($_POST['submitted8']))
	    {
	    // Query 7: we list the youngest and oldest actors to win at least one award
	         echo "Displaying the youngest and oldest actors to win at least one award.";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Age</th></tr></thead>";
		 $stmt = $conn->prepare("(SELECT DISTINCT p.pname, (a.award_year - EXTRACT(YEAR from p.dob)) AS age FROM people p, award a, role r WHERE
         				  p.id = a.pid AND a.pid = r.pid AND r.role_name = 'Actor' ORDER BY age LIMIT 1) UNION (SELECT DISTINCT p.pname,
					  (a.award_year - EXTRACT(YEAR from p.dob)) AS age FROM people p, award a, role r WHERE
         				  p.id = a.pid AND a.pid = r.pid AND r.role_name = 'Actor' ORDER BY age DESC LIMIT 1)");
	    }

	    elseif (isset($_POST['submitted9']))
	    {
	    // Query 9: We find people who've played multiple roles in a motion picture with rating greater than the input rating!
		 $query = $_POST["queryInput"];
	         echo "Displaying all the people who have played multiple roles in a motion picture with a rating greater than $query.";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Title</th><th class='col-md-2'>Number of Roles</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT p.pname, mp.name, COUNT(*) FROM people p, motionpicture mp, role r WHERE p.id = r.pid AND mp.id = r.mpid AND mp.rating > $query GROUP BY p.id, mp.id HAVING COUNT(*) > 1");
	    }

        elseif (isset($_POST['submitted16']))
	    {
	    // Query 10: We find the top 2 rated thriller films that were shot exclusively in Boston!
        
		 
	         echo "Displaying the top 2 rated thriller films shot exclusively in Boston.";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Rating</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT name, rating FROM location l, motionpicture mp Where l.city like 
                                    'Boston' AND l.mpid NOT IN (SELECT DISTINCT mpid FROM location WHERE city NOT LIKE 'Boston') 
                                    AND l.mpid IN (SELECT DISTINCT mpid FROM genre Where genre_name like 'Thriller') 
                                    AND l.mpid IN (SELECT DISTINCT mpid FROM movie)
                                    AND l.mpid = mp.id ORDER BY mp.rating DESC LIMIT 2");
	    }

	    elseif (isset($_POST['submitted10']))
	    {
	    // Query 12: We find people who've played multiple roles in both Marvel and Warner Bros productions!
		 $query = $_POST["queryInput"];
	         echo "Displaying all the people who've played multiple roles in both Marvel and Warner Bros productions!";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Title</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT p.pname, mp.name FROM people p, motionpicture mp, role r WHERE (mp.production = 'Marvel' OR mp.production = 'Warner Bros') AND mp.id = r.mpid AND p.id = r.pid AND p.id IN
					(SELECT p.id FROM people p, motionpicture mp, role r WHERE p.id = r.pid AND mp.id = r.mpid AND r.role_name = 'Actor' AND mp.production = 'Marvel'
					INTERSECT
					(SELECT p.id FROM people p, motionpicture mp, role r WHERE p.id = r.pid AND mp.id = r.mpid AND r.role_name = 'Actor' AND mp.production = 'Warner Bros'))");
	    
	    }
	    elseif (isset($_POST['submitted11']))
	    {
	    // Query 13: We find motion pictures with a higher rating than the average rating for comedy motion pictures!
		 $query = $_POST["queryInput"];
	         echo "Displaying all motion pictures with a higher rating than the average comedy rating!";
		 echo "<tr><th class='col-md-2'>Name</th><th class='col-md-2'>Title</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT mp.name, mp.rating FROM motionpicture mp, genre g WHERE mp.id = g.mpid AND mp.rating > (SELECT AVG(mp.rating) FROM motionpicture mp, genre g
		 			WHERE mp.id = g.mpid AND g.genre_name = 'Comedy') ORDER BY mp.rating DESC;");
	    
	    }
	    elseif (isset($_POST['submitted12']))
	    {
	    // Query 14: We top five movies with most people and display the number of people and roles for that movie!
	         echo "Displaying the top 5 motion pictures with the most people!";
		 echo "<tr><th class='col-md-2'>Title</th><th class='col-md-2'>Number of People</th><th class='col-md-2'>Number of Roles</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT A.name, A.numPeople, B.numRoles FROM (SELECT mp.id, mp.name, COUNT(*) AS numPeople FROM motionpicture mp, role r WHERE mp.id = r.mpid GROUP BY r.mpid ORDER BY COUNT(r.mpid) DESC LIMIT 5) AS A
					INNER JOIN (SELECT mp2.id, COUNT(*) AS numRoles FROM motionpicture mp2, (SELECT mp1.id, COUNT(*) FROM motionpicture mp1, role r1 WHERE mp1.id = r1.mpid GROUP BY r1.mpid, r1.role_name) b WHERE mp2.id = b.id GROUP BY mp2.id) AS B ON A.id = B.id");
	    
	    }
	    elseif (isset($_POST['submitted13']))
	    {
	    // Query 15: We display the actors sharing a birthday.
	         echo "Displaying the actors sharing a birthday!";
		 echo "<tr><th class='col-md-2'>Actor #1</th><th class='col-md-2'>Actor #2</th><th class='col-md-2'>Birthday</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT DISTINCT A.first_name, B.second_name, A.dob FROM
					(SELECT p1.pname AS first_name, p1.id, p1.dob FROM people p1, role r1 WHERE p1.id IN (SELECT r.pid FROM role r WHERE r.role_name = 'Actor')) AS A INNER JOIN
					(SELECT p2.pname AS second_name, p2.id, p2.dob FROM people p2, role r2 WHERE p2.id IN (SELECT r.pid FROM role r WHERE r.role_name = 'Actor')) AS B ON
					A.id < B.id AND A.dob = B.dob");
	    
	    }
	    elseif (isset($_POST['submitted14']))
	    {
	    // Query 8: We display producers based on box office collection and budget
		 $query1 = $_POST["queryInput1"];
		 $query2 = $_POST["queryInput2"];
	         echo "Displaying the American producers who have had a box office collection of more than or equal to $query1 with a budget less than or equal to $query2!";
		 echo "<tr><th class='col-md-2'>Producer</th><th class='col-md-2'>Title</th><th class='col-md-2'>Box Office Collection</th><th class='col-md-2'>Budget</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT p.pname, mp.name, m.boxoffice_collection, mp.budget FROM people p, motionpicture mp, movie m, role r WHERE p.id = r.pid AND mp.id = r.mpid AND mp.id = m.mpid 
					AND m.boxoffice_collection >= $query1 AND mp.budget <= $query2 AND p.nationality = 'USA' AND r.role_name = 'Producer'");
	    
	    }


	    elseif (isset($_POST['submitted15']))
	    {
	    // Query 11: We display motion pictures based on the number of likes from users of a certain age
		 $query1 = $_POST["queryInput1"];
		 $query2 = $_POST["queryInput2"];
	         echo "Displaying the movies with more than $query1 likes by users of age less than $query2!";
		 echo "<tr><th class='col-md-2'>Title</th><th class='col-md-2'>Number of Likes</th></tr></thead>";
		 $stmt = $conn->prepare("SELECT mp.name, COUNT(*) FROM motionpicture mp, likes l, user u WHERE mp.id = l.mpid AND l.uemail = u.email 
					AND mp.id IN (SELECT m.mpid FROM movie m) AND u.age < $query2 GROUP BY mp.id HAVING COUNT(*) > $query1");
	    
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
    <h1 style="text-align:center"> Like Function </h1><br>
    <h3 style="text-align:center"> Click "Submit Like!" for registered users</h3><br>
    <h3 style="text-align:center"> Click "Register & Submit Like!" to register as new user and like</h3><br>
</div>

<div class="container">
<form method = "post"> 
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name = "inputemail" id="InputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <span class="error">* Required</span>
    <small id="emailHelp" class="form-text text-muted"></small>
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name = "uname" id="Uname1" placeholder="Enter user name ONLY for registration">
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Age</label>
    <input type="number" class="form-control" name = "uage" id="Uage" placeholder="Enter age ONLY for registration">
    
  </div>

  <div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="nan" checked>
  <label class="form-check-label" for="exampleRadios1">
  Default: None
  </label>
</div>
  <div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" >
  <label class="form-check-label" for="exampleRadios1">
  Shang-Chi: Legend of the Ten Rings
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="2" >
  <label class="form-check-label" for="exampleRadios2">
  Free Guy
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="3" >
  <label class="form-check-label" for="exampleRadios3">
  WandaVision
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="4" >
  <label class="form-check-label" for="exampleRadios4">
  Squid Game
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5" value="101" >
  <label class="form-check-label" for="exampleRadios5">
  Breaking Bad
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios6" value="102" >
  <label class="form-check-label" for="exampleRadios6">
  Band of Brothers
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios7" value="103" >
  <label class="form-check-label" for="exampleRadios7">
  Game of Thrones
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios8" value="104" >
  <label class="form-check-label" for="exampleRadios8">
  Rick and Morty
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios9" value="105" >
  <label class="form-check-label" for="exampleRadios9">
  Sherlock
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios10" value="106" >
  <label class="form-check-label" for="exampleRadios10">
  Fullmetal Alchemist: Brotherhood
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios11" value="107" >
  <label class="form-check-label" for="exampleRadios1">
  Ted Lasso
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios12" value="108" >
  <label class="form-check-label" for="exampleRadios2">
  Fleabag
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios13" value="109" >
  <label class="form-check-label" for="exampleRadios3">
  The Simpsons
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios14" value="110" >
  <label class="form-check-label" for="exampleRadios4">
  Sacred Games
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios15" value="111" >
  <label class="form-check-label" for="exampleRadios5">
  Agents of Shield
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios16" value="201" >
  <label class="form-check-label" for="exampleRadios6">
  Iron Man
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios17" value="202" >
  <label class="form-check-label" for="exampleRadios7">
  Daredevil
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios18" value="203" >
  <label class="form-check-label" for="exampleRadios8">
  Doctor Strange
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios19" value="204" >
  <label class="form-check-label" for="exampleRadios9">
  Batman vs Superman
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios20" value="205" >
  <label class="form-check-label" for="exampleRadios10">
  Batman: The dark knight
  </label>
</div>  <div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios21" value="206" >
  <label class="form-check-label" for="exampleRadios1">
  Pretty Woman
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios22" value="207" >
  <label class="form-check-label" for="exampleRadios2">
  The Notebook 
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios23" value="208" >
  <label class="form-check-label" for="exampleRadios3">
  The Matrix
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios24" value="209" >
  <label class="form-check-label" for="exampleRadios4">
  John Wick
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios25" value="210" >
  <label class="form-check-label" for="exampleRadios5">
  London has Fallen
  </label>
</div>


  <button type="submit" class="btn btn-primary" name = "likesubmit">Submit Like!</button>
  <button type="submit" class="btn btn-primary" name = "regsubmit">Register & Submit Like!</button>
</form>
</div>

<div class="container">
  <?php
    if (isset($_POST['likesubmit']))
    {
    
         //echo "Displaying all tables in the database.";
         //echo $_POST['exampleRadios'];
         //echo var_dump($_POST['exampleRadios']);
      
      
      
      // check email
      $emailErr = "";
      if (empty($_POST["inputemail"])) {
      $emailErr = "ERROR: Email is required";
      echo $emailErr;
      }
      $reguse = $_POST["inputemail"]; 

      //remember to change this part based on the local database name
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "movies";

      try{
        if (strcmp($_POST['exampleRadios'], 'nan') != 0){
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("SELECT COUNT(*) FROM User WHERE email LIKE '$reguse' ");
          $stmt->execute();

          // set the resulting array to associative
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          // prints the result of the query, 1 if it is a valid user email, 0 if it is not a registered user
          $temp = $stmt->fetchAll();
          //echo implode(" ", $temp[0]); //implode converts the array to a string
          //echo var_dump($temp[0]);
          if (strcmp(implode(" ", $temp[0]), '1') == 0){
            //registered user
            //statement that inserts a like on movie mpid 110 with user's imput email
            $mpid = $_POST['exampleRadios'];
            $stmt0 = $conn->prepare("INSERT INTO Likes VALUES ('$mpid', '$reguse')");
            $stmt0->execute();
            echo "User $reguse successfully liked motion picture $mpid";
          }else{
            echo "ERROR: Unregistered User!";
          }
        }
        

      }
      catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;

    }elseif(isset($_POST['regsubmit'])){
      
      $emailErr = $nameErr = $ageErr= "";
      if (empty($_POST["inputemail"])) {
      $emailErr = "ERROR: Email is required";
      echo $emailErr;
      }
      if (empty($_POST["uname"])) {
        $emailErr = "ERROR: Name is required for registration";
        echo $emailErr;
      }
      if (empty($_POST["uage"])) {
        $emailErr = "ERROR: Age is required for registration";
        echo $emailErr;
      }
      $uemail = $_POST["inputemail"]; 
      $uname = $_POST["uname"]; 
      $uage = $_POST["uage"]; 

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "movies";

      try{
        if (strcmp($_POST['exampleRadios'], 'nan') != 0){
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("SELECT COUNT(*) FROM User WHERE email LIKE '$uemail' ");
          $stmt->execute();

          // set the resulting array to associative
          $stmt->setFetchMode(PDO::FETCH_ASSOC);
          // prints the result of the query, 1 if it is a valid user email, 0 if it is not a registered user
          $temp = $stmt->fetchAll();
          //echo implode(" ", $temp[0]); //implode converts the array to a string
          //echo var_dump($temp[0]);
          if (strcmp(implode(" ", $temp[0]), '1') == 0){
            //registered user
            //statement that inserts a like on movie mpid 110 with user's imput email
            
            echo "User $reguse is already a registered user. Please use the correct submit button";
          }elseif(strcmp(implode(" ", $temp[0]), '1') != 0){
            //echo "ERROR: Unregistered User!";
            $stmt0 = $conn->prepare("INSERT INTO user VALUES ('$uemail', '$uname', '$uage')");
            $stmt0->execute();
          }
          $mpid = $_POST['exampleRadios'];
          $stmt1 = $conn->prepare("INSERT INTO Likes VALUES ('$mpid', '$uemail')");
          $stmt1->execute();
            echo "User $uemail successfully liked motion picture $mpid";
        }
      }
      catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
    }
  ?>
</div>
        

</body>
</html>