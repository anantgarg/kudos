	<form action="<?php echo BASE_URL;?>users/validate" method="post">
	<div class="container spacer centered">
		<div class="row">
			<div><i class="fa fa-thumbs-up fa-5x"></i></div>
			<h2>Kudos</h2>
			<p>The easiest way to manage testimonials</p>
		</div>

		<div class="spacer-sm">
		  <input id="email" name="email" type="text" placeholder="Email" class="form-control">
		</div>
		<div class="spacer-sm">
			<input id="password" name="password" type="password" placeholder="Password" class="form-control">
		</div>

		<div class="spacer">
			<button name="type" type="submit" value="register" class="btn btn-border">Sign up</button>
		</div>
		<div class="spacer-sm">
			<a href="<?php echo BASE_URL;?>users/login">Already have an account?</a>
		</div>


	</div>
	</form>