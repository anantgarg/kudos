	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2>Connect with Zendesk</h2>
				<p>Enter your API details so that we can connect.</p>
			</div>
		</div>
	</div>

	<form action="<?php echo BASE_URL;?>connect/add/zendesk" method="post">
	<div class="container">

		<div class="row">
			
			<div class="col-xs-12">
				<input id="name" name="name" type="text" placeholder="Name" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="username" name="username" type="text" placeholder="Username" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="apikey" name="apikey" type="text" placeholder="API Key" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="url" name="url" type="text" placeholder="Zendesk URL" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<button name="type" type="submit" value="login" class="btn btn-primary">Connect</button>
			</div>

			
		</div>
	</div>
	</form>