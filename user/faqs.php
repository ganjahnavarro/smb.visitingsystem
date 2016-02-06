<div class="modal fade" id="faqsModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<div class="col-md-12">
					<h1>
						<span class="glyphicon glyphicon-question-sign"></span> FREQUENTLY ASKED QUESTIONS
					</h1>
				</div>
				<div class="col-md-12">
					<h5>
						This a short list of our most frequently asked questions. For more
						information about San Miguel Corporation, Please visit our Site
						<a href="http://www.sanmiguel.com.ph/" target="top">sanmiguel.com.ph</a>
					</h5>
					<br />

	                <?php
						$mysqli = new mysqli ($dbhost, $dbuser, $dbpass, $database);

						$resultSet = $mysqli->query ( "SELECT * FROM faqs where type is null or type = 'DEFAULT'" );

						if ($resultSet->num_rows != 0) {
							while ( $rows = $resultSet->fetch_assoc () ) {
								$question = $rows ['question'];
								$answer = $rows ['answer'];
								$date = $rows ['date'];

								echo "<div><h5 class=''><strong>$question</strong></h5></div>
									<div><blockquote class='bg-default'>
										<h5>$answer</h5>
										</blockquote>
									</div>";
							}
						} else {
							echo "No results.";
						}
	             ?>
	  			</div>

				<div class="clearfix"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>
