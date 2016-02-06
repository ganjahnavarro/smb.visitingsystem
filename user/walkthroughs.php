<div class="modal fade" id="walkthroughsModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<h2>WALKTHROUGHS</h2>
				<br/>

				<?php
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					$output = '';

					$query = mysql_query ("SELECT *, w.department as dept, w.floor as flr from appointments a
						left join visitinfo v on a.visitinfoid = v.id
						left join walkthroughs w on v.floor = w.floor and v.department = w.department
						where w.active = true and (a.status = 'APPROVED' or a.status = 'RESCHEDULED')
						and a.userid = '$userId' ORDER BY w.id DESC LIMIT 1");

					$count = mysql_num_rows ( $query );
					if ($count == 0) {
						$output = "There was no search results!";
					} else {
						while ( $row = mysql_fetch_array ( $query ) ) {
							$id = $row ['id'];
							$active = $row ['active'];
							$name = $row ['name'];
							$description = $row ['description'];
							$link = $row ['link'];
							$floor = $row ['flr'];
							$department = $row ['dept'];

							echo "<div class='well'>
									<p>" . $name . "</p>
									<iframe width='100%' height='350' src='" . $link . "' frameborder='0' allowfullscreen></iframe>
									<p class='help-block'>Description: " . $description . "</p>
									<p class='help-block'>Department: " . $department . "</p>
									<p class='help-block'>Floor: " . $floor . "</p>
								</div>";
						}
					}
					echo $output;
				?>
				<div class="clearfix"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>
