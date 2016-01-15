	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h4>Connect a Network</h4>
				<p>Share to many different places with Kudos and we make sure your posts look great everywhere. Click the 'Connect' buttons below to begin connecting your account to Kudos:</p>
			</div>
		</div>

		<div class="row spacer">
			<div class="col-xs-2">
				<div class="row centered">
					<a href="<?php echo BASE_URL;?>connect/twitter">
					<div>
						<span class="fa fa-<?php echo $integrations['twitter']['icon'];?> fa-5x">
					</div>
					<div>
						<p>twitter</p>
					</div>
					<div>
						<span class="btn btn-default btn-info">Connect</span>
					</div>
				

					</a>
				</div>
			</div>

			<div class="col-xs-2">
				<div class="row centered">
					<a href="<?php echo BASE_URL;?>connect/facebook">
					<div>
						<span class="fa fa-<?php echo $integrations['facebook']['icon'];?> fa-5x">
					</div>
					<div>
						<p>facebook</p>
					</div>
					<div>
						<span class="btn btn-default btn-info">Connect</span>
					</div>


					</a>
				</div>
			</div>

			
			<div class="col-xs-2">
				<div class="row centered">
					<a href="<?php echo BASE_URL;?>connect/zendesk">
					<div style="height:70px">
						<span class="fa fa-<?php echo $integrations['zendesk']['icon'];?> fa-5x">
					</div>
					<div>
						<p>zendesk</p>
					</div>
					<div>
						<span class="btn btn-default btn-info">Connect</span>
					</div>


					</a>
				</div>
			</div>
			
			<div class="col-xs-2">
				<div class="row centered">
					<a href="<?php echo BASE_URL;?>connect/appstore">
					<div style="height:70px">
						<span class="fa fa-<?php echo $integrations['appstore']['icon'];?> fa-5x">
					</div>
					<div>
						<p>app store</p>
					</div>
					<div>
						<span class="btn btn-default btn-info">Connect</span>
					</div>


					</a>
				</div>
			</div>
						
			<div class="col-xs-2">
				<div class="row centered">
					<a href="<?php echo BASE_URL;?>connect/form">
					<div style="height:70px">
						<span class="fa fa-<?php echo $integrations['form']['icon'];?> fa-5x">
					</div>
					<div>
						<p>form</p>
					</div>
					<div>
						<span class="btn btn-default btn-info">Connect</span>
					</div>


					</a>
				</div>
			</div>

			<div class="col-xs-2">
				<div class="row centered">
					<a href="<?php echo BASE_URL;?>connect/showcase">
					<div style="height:70px">
						<span class="fa fa-<?php echo $integrations['showcase']['icon'];?> fa-5x">
					</div>
					<div>
						<p>showcase</p>
					</div>
					<div>
						<span class="btn btn-default btn-info">Connect</span>
					</div>


					</a>
				</div>
			</div>



		</div>

	<?php if (!empty($accounts)):?>

		<div class="row spacer">
			<div class="col-xs-12">
				<h4>Connected Networks</h4>
				<p>Re-connect or delete your existing networks</p>
			</div>
		</div>

		<div class="row spacer">
			<?php foreach ($accounts as $account):?>
					
			<div class="col-xs-6 page">
				<div class="row">
					<div class="col-xs-2 centered">
						<span class="fa fa-<?php echo $integrations[$account['type']]['icon'];?> fa-3x">
					</div>
					<div class="col-xs-10">
						<h5 class="name"><?php echo $account['name'];?> (<?php echo ucwords($account['type']);?>)</h5>
						<span class="category"><!--<a class="confirmLink2" href="<?php echo BASE_URL;?>connect/<?php echo $account['type'];?>">Reconnect</a> | -->
						<?php if ($account['type'] == 'form'):?>
						<a class="confirmLink2" href="<?php echo BASE_URL;?>connect/import/<?php echo $account['id'];?>">Import</a> | 
						<?php endif;?>
						<a class="confirmLink" href="<?php echo BASE_URL;?>connect/remove/<?php echo $account['id'];?>">Delete</a>
						</span>
					</div>
				</div>
			</div>

			<?php endforeach;?>
		</div>
	<?php endif;?>

	</div>