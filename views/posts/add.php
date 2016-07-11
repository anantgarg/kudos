
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
				<input type="file" name="image" id="image" value="Choose Image">
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
					<select name="rating" id="rating" size="1" class="form">

						<option value="">Rating</option>

						<option class="" value="5">5</option>
						<option class="" value="5">4</option>
						<option class="" value="5">3</option>
						<option class="" value="5">2</option>
						<option class="" value="5">1</option>

					</select>
				</div>

				<div class="col-xs-12 spacer-sm">
					<select name="category" id="category" size="1" class="form">

						<option value="">Industry</option>
					    <option>Software Services</option>
    <option>Finance</option>
    <option>Manufacturing</option>
    <option>Advertising</option>
    <option>Architecture</option>
    <option>Automobile</option>
    <option>Aviation</option>
    <option>BPO</option>
    <option>Transportation</option>
    <option>Government</option>
    <option>Education</option>
    <option>Electricals</option>
    <option>Facility Management</option>
    <option>FMCG</option>
    <option>Fashion</option>
    <option>Hospitality</option>
    <option>Insurance</option>
    <option>IT Hardware</option>
    <option>Research</option>
    <option>News</option>
    <option>Entertainment</option>
    <option>E-commerce</option>
    <option>Healthcare</option>
    <option>Social Services</option>
    <option>Office Automation</option>
    <option>Infrastructure</option>
    <option>Medical</option>
    <option>Religious</option>
    <option>Real Estate</option>
    <option>Retail</option>
    <option>Security</option>
    <option>Electronics</option>
    <option>Consulting</option>
    <option>Other</option>
		</select>
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
