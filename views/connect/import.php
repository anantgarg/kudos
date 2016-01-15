	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2>Import data to a channel</h2>
				<p>Add your data as a PHP array</p>
			</div>
		</div>
	</div>

	<form action="<?php echo BASE_URL;?>connect/import-data/<?php echo $accountId;?>" method="post">
	<div class="container">

		<div class="row">
			
			<div class="col-xs-12">
				<textarea id="data" name="data" type="text" placeholder="" class="form-control"></textarea>
			</div>

			<div class="col-xs-12 spacer-sm">
				<button name="type" type="submit" value="login" class="btn btn-primary">Import</button>
			</div>

			
		</div>
	</div>
	</form>