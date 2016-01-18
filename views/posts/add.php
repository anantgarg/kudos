
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
					<select name="industry" id="industry" size="1" class="form">

						<option value="">Industry</option>
				
						<option class="" value="Aerospace and Defense">Aerospace and Defense</option>
					
						<option class="" value="Automotive">Automotive</option>
					
						<option class="" value="Banking">Banking</option>
					
						<option class="" value="Building Materials">Building Materials</option>
					
						<option class="" value="Cargo Transport &amp; Logistics">Cargo Transport &amp; Logistics</option>
					
						<option class="" value="Chemicals">Chemicals</option>
					
						<option class="" value="Consumer Products">Consumer Products</option>
					
						<option class="" value="Defense and Security">Defense and Security</option>
					
						<option class="" value="Engineering, Construction and Operations">Engineering, Construction &amp; Operations</option>
					
						<option class="" value="Fabricated Metal Products">Fabricated Metal Products</option>
					
						<option class="" value="Forest Products, Furniture &amp; Textile">Forest Products, Furniture &amp; Textile</option>
					
						<option class="" value="Healthcare">Healthcare</option>
					
						<option class="" value="High Tech">High Tech</option>
					
						<option class="" value="Higher Education and Research">Higher Education and Research</option>
					
						<option class="" value="Industrial Machinery and Components">Industrial Machinery and Components</option>
					
						<option class="" value="Insurance">Insurance</option>
					
						<option class="" value="Life Sciences">Life Sciences</option>
					
						<option class="" value="Media">Media</option>
					
						<option class="" value="Mining">Mining</option>
					
						<option class="" value="Oil and Gas">Oil and Gas</option>
					
						<option class="" value="Passenger Travel &amp; Leisure">Passenger Travel &amp; Leisure</option>
					
						<option class="" value="Postal">Postal</option>
					
						<option class="" value="Primary Metals">Primary Metals</option>
					
						<option class="" value="Professional Services">Professional Services</option>
					
						<option class="" value=" Public Sector">Public Sector</option>
					
						<option class="" value="Retail">Retail</option>
					
						<option class="" value="Sports &amp; Entertainment">Sports &amp; Entertainment</option>
					
						<option class="" value="Telecommunications">Telecommunications</option>
					
						<option class="" value="Utilities">Utilities</option>
					
						<option class="" value="Wholesale Distribution">Wholesale Distribution</option>
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
