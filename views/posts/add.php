	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2>Add a new post</h2>
			</div>
		</div>
	</div>

	<form action="<?php echo BASE_URL;?>posts/add-now/<?php echo $accountid;?>" method="post">
	<div class="container">

		<div class="row">
			
			<div class="col-xs-12">
				<input id="name" name="name" type="text" placeholder="Name" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="description" name="description" type="text" placeholder="Description (e.g. domain)" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="avatar" name="avatar" type="text" placeholder="Avatar (or email)" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<textarea name="comment" id="comment" rows=5 class="form-control" placeholder="Comment" style="max-width: 600px"></textarea>
			</div>

			<div class="col-xs-12 spacer-sm">
				<button name="type" type="submit" value="login" class="btn btn-primary">Add</button>
			</div>

			
		</div>
	</div>
	</form>