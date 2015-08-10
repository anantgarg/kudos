	<div class="container spacer"></div>
	<div class="container spacer"></div>
	<div class="container spacer"></div>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="<?php echo BASE_URL;?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL;?>assets/js/image-picker.min.js"></script>
	<script src="<?php echo BASE_URL;?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?php echo BASE_URL;?>assets/js/bootstrap-maxlength.min.js"></script>
	<script src="<?php echo BASE_URL;?>assets/js/jasny-bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL;?>assets/js/mininotification.js"></script>
	<script src="<?php echo BASE_URL;?>assets/js/main.js"></script>
	<script>
	$(document).ready(function() {
		$(".image-picker").imagepicker();
		$('.selectpicker').selectpicker();
		$('[rel=tooltip]').tooltip();
		$('textarea#message').maxlength({
            alwaysShow: true,
			placement: 'top-right'
        });
	})		
	</script>
	<?php if (!empty($_SESSION['notification'])):?>
		<div id="notification" class="notification_<?php echo $_SESSION['notification']['type'];?>">
		  <p><?php echo $_SESSION['notification']['message'];?></p>
		</div>
	<script>
	$(document).ready(function() {
		$('#notification').miniNotification();
	})
	</script>
	<?php endif; unset($_SESSION['notification']);?>
  
	<div class="modal fade" id="confirm">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Are you sure?</h4>
		  </div>
		  <div class="modal-body">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" id="yes">Continue</button>
		  </div>
		</div>
	  </div>
	</div>

  </body>
</html>
