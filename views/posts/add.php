
		<div class="row">
			<div class="col-xs-12">
				<h2>Add a new post</h2>
			</div>
		</div>

	<form action="<?php echo BASE_URL;?>posts/add-now/<?php echo $accountid;?>" method="post"  enctype="multipart/form-data">
		<div class="row">
		
			<?php if ($acc['type'] == 'form'):?>

			<div class="col-xs-12">
				<input id="name" name="name" type="text" placeholder="Name" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="description" name="description" type="text" placeholder="Description (e.g. domain)" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<input id="avatar" name="avatar" type="text" placeholder="Email address" class="form-control">
			</div>

			<div class="col-xs-12 spacer-sm">
				<textarea name="comment" id="comment" rows=5 class="form-control" placeholder="Comment" style="max-width: 600px"></textarea>
			</div>

			<?php elseif ($acc['type'] == 'appstore'):?>
				<div class="col-xs-12">
					<input id="url" name="url" type="text" placeholder="App URL" class="form-control">
				</div>

			<?php elseif ($acc['type'] == 'showcase'):?>
				
				<div class="col-xs-12">
					<input id="name" name="name" type="text" placeholder="Name" class="form-control">
				</div>

				<div class="col-xs-12 spacer-sm">
					<input id="description" name="description" type="text" placeholder="Description (e.g. domain)" class="form-control">
				</div>
				
				<div class="col-xs-12 spacer-sm">
					<input type="file" name="image" id="image" value="Choose Image">
				</div>

				<div class="col-xs-12 spacer-sm">
					<textarea name="comment" id="comment" rows=5 class="form-control" placeholder="Comment" style="max-width: 600px"></textarea>
				</div>

			<?php endif;?>

			<div class="col-xs-12 spacer-sm">
				<button name="type" type="submit" value="login" class="btn btn-primary">Add</button>
			</div>

			
		</div>
 	</form>