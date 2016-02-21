<div class='panel panel-primary'>
	<div class='panel-heading hide-on-print'>
		<span class='glyphicon glyphicon-user'></span><span class='glyphicon glyphicon-user '></span> VISITORS
	</div>
	<div class='table-responsive'>
		<table class="table table-condensed text-uppercase small sortableTable searchableTable">
			<thead>
				<th class='active'>NAME</th>
				<th class='active'>COMPANY</th>
				<th class='active'>PERSON TO VISIT</th>
				<th class='active'>PURPOSE TO VISIT</th>
				<th class='active'>DEPARTMENT</th>
				<th class='active'>GATE</th>
				<th class='active'>DATE</th>
				<th class='active'>TIME IN</th>
				<th class='active'>TIME OUT</th>
				<th class='active'>PASS</th>
				<th class='active'>ISSUED BY</th>
			</thead>

			<?php
				if($tab == 'WALKINS' || $tab == 'ALL'){
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					$output = "There was no search results!";
					
					$mysqlStartDate = date("Y-m-d", strtotime($startDate));
					$mysqlEndDate = date("Y-m-d", strtotime($endDate));
					
					$queryString = "SELECT *, v.id as pk FROM walkinvisitors w left join visitinfo v on w.visitinfoid = v.id
					where v.date between '$mysqlStartDate' and '$mysqlEndDate'
					ORDER BY v.id desc";
					
					$query = mysql_query ($queryString) or die ( mysql_error () );
					
					$count = mysql_num_rows ( $query );
					if ($count != 0) {
						$output = "";
							
						while ( $row = mysql_fetch_array ( $query ) ) {
							$id = $row ['pk'];
							$fname = $row ['firstname'];
							$lname = $row ['lastname'];
							$add = $row ['address'];
							$dep = $row ['department'];
							$gate = $row ['gate'];
							$plateno = $row ['plateno'];
							$pur = $row ['purpose'];
							$per = $row ['persontovisit'];
							$date = $row ['date'];
							$time = $row ['timein'];
							$timeout = $row ['timeout'];
							$passno = $row ['passno'];
							$issuedby = $row ['issuedby'];
					
							if(empty($plateno) == false){
								$gate = $gate . " (" . $plateno . ")";
							}
							
							echo "<tr class='h6'><td>" . $fname . " " . $lname . "</td>
								<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td> <td>" . $gate . "</td>
								<td>" . $date . "</td> <td>" . $time . "</td> <td>" . $timeout . "</td>
								<td>" . $passno . "</td> <td>" . $issuedby . "</td>";
						}
					}
				}
			?>

			<?php
				if($tab == 'APPOINTMENTS' || $tab == 'ALL'){
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					
					$mysqlStartDate = date("Y-m-d", strtotime($startDate));
					$mysqlEndDate = date("Y-m-d", strtotime($endDate));
					
					$queryString = "SELECT *, v.id as pk, v.date as vdate FROM appointments a left join visitinfo v
					on a.visitinfoid = v.id left join users u on a.userid = u.id
					where (a.status = 'APPROVED' or a.status = 'RESCHEDULED')
					and v.timein is not null and (v.date >= '$mysqlStartDate' and v.date <= '$mysqlEndDate') ORDER BY v.id desc";
					
					$query = mysql_query ($queryString) or die ( mysql_error () );
					
					$count = mysql_num_rows ( $query );
					if ($count != 0) {
						$output = "";
							
						while ( $row = mysql_fetch_array ( $query ) ) {
							$id = $row ['pk'];
							$fname = $row ['fname'];
							$lname = $row ['lname'];
							$add = $row ['address'];
							$dep = $row ['department'];
							$gate = $row ['gate'];
							$plateno = $row ['plateno'];
							$pur = $row ['purpose'];
							$per = $row ['persontovisit'];
							$date = $row ['vdate'];
							$time = $row ['timein'];
							$timeout = $row ['timeout'];
							$passno = $row ['passno'];
							$issuedby = $row ['issuedby'];
					
							if(empty($plateno) == false){
								$gate = $gate . " (" . $plateno . ")";
							}
					
							echo "<tr class='h6'><td>" . $fname . " " . $lname . "</td>
								<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td> <td>" . $gate . "</td>
								<td>" . $date . "</td> <td>" . $time . "</td> <td>" . $timeout . "</td>
								<td>" . $passno . "</td> <td>" . $issuedby . "</td>";
						}
					}
				}
			?>
		</table>
	</div>
</div>

<?php print("$output"); ?>
<br />