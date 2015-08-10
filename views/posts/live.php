	<div class="row">
		<div class="col-xs-12">
			<h4>Live</h4>
			<p>All posts being shown right now!</p>
		</div>
	</div>

	<?php foreach ($comments as $comment):?>
	<div class="row spacer-sm post">
			<div class="col-xs-8">
				<h5 class="name"><?php echo $comment['message'];?></h5>
				<?php if (hasPermission(100)):?> 
				<div class="category"><br/><a class="confirmLink" href="<?php echo BASE_URL;?>posts/move-inbox/<?php echo $comment['accountid'];?>/<?php echo $comment['id'];?>"><i class="fa fa-minus-square fa-3x"></i></a></div>
				<?php endif;?>
			</div>

			<div class="col-xs-4 pull-right">
				<img class="social_image spacer-sm" src="<?php echo $comment['user_avatar'];?>" title="<?php echo $comment['user_name'];?>" rel="tooltip">
				<p><?php echo $comment['user_name'];?></p>
			</div>
		<div style="clear:both"></div>
	</div>
	<?php endforeach;?>