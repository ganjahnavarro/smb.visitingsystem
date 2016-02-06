<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role != "GUARD") {
		header ( 'Location: /index.php?err=2' );
	}
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'faqs' ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/guard/navbar.php' ); ?>
	
<div class="container">
  <div class="row text-left">
    <div class="col-md-12"><h1><span class="glyphicon glyphicon-question-sign"></span> FREQUENTLY ASKED QUESTIONS</h1></div>
    
                
               <div class="col-md-12"> <h5> This a short list of our most frequently asked questions. For more information about San Miguel Corporation, Please visit our Site <a href="http://www.sanmiguel.com.ph/" target="top">sanmiguel.com.ph</a></h5>
                <br />
                
                <?php 
           	$mysqli = new mysqli ($dbhost, $dbuser, $dbpass, $database);
            $resultSet = $mysqli->query("SELECT * FROM faqs where type is null or type = 'GUARD'");

            if ($resultSet->num_rows != 0){
                while ($rows = $resultSet->fetch_assoc())
                {
                    $question =$rows['question'];
                    $answer =$rows['answer'];
                    $date =$rows['date'];
                    
                    echo "<div>
                            <h5 class=''><strong>$question</strong></h5>
                            </div>
                            <div>
                            <blockquote class='bg-default'>
                            <h5>$answer</h5>
                            </blockquote>
                            </div>";                    
                }

            }
            else 
            {
                echo "No results.";
            }

             ?>
  </div>
  </div>
</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	</body>
</html>