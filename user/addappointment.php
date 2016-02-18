<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="index.php" method="POST">
				<div class="modal-body">
					<div class="col-md-12">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					
						<h2>ADD APPOINTMENT</h2>
						<br/>
					</div>
					
					<div>
						<div class="form-group">
							<div class="col-md-4 text-left">
								<h5>
									<strong>Date and Time</strong>
								</h5>
							</div>
							<div class="col-md-8 pad-bottom">
								<input id="datetime" class="form-control" name="datetime" required />
							</div>
						</div>
					
						<div class="form-group">
							<div class="col-md-4 text-left">
								<h5>
									<strong>Department</strong>
								</h5>
							</div>
							<div class="col-md-8 pad-bottom">
								<select class="form-control" name="department" required>
									<option></option>
									<option value="PACKAGING DEPARTMENT">PACKAGING DEPARTMENT</option>
									<option value="ENGINEERING DEPARTMENT">ENGINEERING DEPARTMENT</option>
									<option value="ADMIN DEPARTMENT">ADMIN DEPARTMENT</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-4 text-left">
								<h5>
									<strong>Purpose</strong>
								</h5>
							</div>
							<div class="col-md-8 pad-bottom">
								<select id="purpose" class="form-control" name='purpose' required>
									<option></option>
									<option value="EMPLOYEE / OJT">EMPLOYEE / OJT</option>
									<option value="TRAINING / SEMINAR">TRAINING / SEMINAR</option>
									<option value="COLLECTION">COLLECTION</option>
									<option value="COUNTER">COUNTER</option>
									<option value="DELIVERY">DELIVERY</option>
									<option value="FOR FOLLOW UP">FOR FOLLOW UP</option>
									<option value="INQUIRY">INQUIRY</option>
									<option value="INTERVIEW / EXAM">INTERVIEW / EXAM</option>
									<option value="MASS">MASS</option>
									<option value="MEETING">MEETING</option>
									<option value="PAYMENT">PAYMENT</option>
									<option value="OTHERS">OTHERS</option>
								</select>
							</div>
						</div>
						
						<div id="otherpurpose" class="form-group" style="display: none;">
							<div class="col-md-4 text-left">
								<h5>
									<strong>Please Specify</strong>
								</h5>
							</div>
							<div class="col-md-8 pad-bottom">
								<input id="otherpurposeinput" type="text" class="form-control" name='otherpurpose'>
							</div>
						</div>
							
						<div class="form-group">
							<div class="col-md-4 text-left">
								<h5>
									<strong>Person To Visit</strong>
								</h5>
							</div>
							<div class="col-md-8 pad-bottom">
								<input class="form-control" name='person' required>
							</div>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
					<button type="submit" name="submit" class="btn btn-primary">SUBMIT</button>
				</div>
			</form>
		</div>
	</div>
</div>