	<form action="<?php echo BASE_URL;?>users/validate" method="post">
	<div class="container spacer centered">
		<div class="row">
			<div><i class="fa fa-thumbs-up fa-5x"></i></div>
			<h2>Kudos</h2>
			<p>The easiest way to manage testimonials</p>
		</div>
	
		<div class="spacer">
		  <input id="email_dummy" name="email_dummy" type="text" placeholder="Email" class="form-control" value="<?php echo $email;?>" disabled>
		</div>
		<div class="spacer-sm">
			<input id="password" name="password" type="password" placeholder="Password" class="form-control">
		</div>

		<div class="spacer">
			<input id="code" type="hidden" name="code" value="<?php echo $code;?>">
			<input id="email" type="hidden" name="email" value="<?php echo $email;?>">
			<button name="type" type="submit" value="invite" class="btn btn-primary">Sign up</button>
		</div>


	</div>
	</form>