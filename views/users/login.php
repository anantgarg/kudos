	<form action="<?php echo BASE_URL;?>users/validate" method="post">
	<div class="container spacer centered">
		<div class="row">
			<div><i class="fa fa-thumbs-up fa-5x"></i></div>
			<h2>Kudos</h2>
			<p>The easiest way to manage testimonials</p>
		</div>

		<div class="spacer">
		  <input id="email" name="email" type="text" placeholder="Email" class="form-control">
		</div>
		<div class="spacer-sm">
			<input id="password" name="password" type="password" placeholder="Password" class="form-control">
		</div>

		<div class="spacer">
			<button name="type" type="submit" value="login" class="btn btn-primary">Sign in</button>
		</div>
		<div class="spacer-sm">
			<?php if (empty($accountexists)):?>
			<a href="<?php echo BASE_URL;?>users/register">No account as yet? Register</a>
			<?php endif;?>
		</div>


	</div>
	</form>