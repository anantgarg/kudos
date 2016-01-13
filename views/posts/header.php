<div class="container">
	<div class="row">
		<div class="col-sm-3">
			<div class="list-group">
			  	<?php foreach ($accounts as $account):?>

				<a class="list-group-item <?php if (!empty($account['current'])):?>active<?php endif;?>" href="<?php echo BASE_URL;?>posts/live/<?php echo $account['id'];?>"><span class="fa fa-<?php echo $integrations[$account['type']]['icon'];?> fa-2x" style="padding-right: 10px"></span><?php echo $account['name'];?> (<?php echo ucwords($account['type']);?>)</a>

				<?php endforeach;?>
			</div>

	 

		</div>
		<div class="col-sm-9">
				<div class="row">
					<div class="col-xs-12">
						<ul class="nav nav-tabs" role="tablist">
						  <li <?php if ($action == 'live'):?>class="active"<?php endif;?>><a href="<?php echo BASE_URL;?>posts/live/<?php echo $current;?>">Live</a></li>
						  <?php if (hasPermission(100)):?>
						  <li <?php if ($action == 'inbox'):?>class="active"<?php endif;?>><a href="<?php echo BASE_URL;?>posts/inbox/<?php echo $current;?>">Inbox</a></li>
						  <?php endif;?>
						  <?php if($currenttype == 'form' || $currenttype == 'appstore' || $currenttype == 'showcase'):?>
						  <li <?php if ($action == 'add'):?>class="active"<?php endif;?>><a href="<?php echo BASE_URL;?>posts/add/<?php echo $current;?>">Add</a></li>
						  <?php endif;?>
						</ul>
					
					</div>
				</div>
