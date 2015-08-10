	<div class="row">
		<div class="col-xs-12">
			<h4>Inbox</h4>
			<p>Select posts you would like to feature!</p>
		</div>
	</div>

	<?php foreach ($comments as $comment):?>
	<div class="row spacer-sm post">
			<div class="col-xs-8">
				<h5 class="name">			
					<span class="actual"><?php echo $comment['message'];?></span>				
				
					<span class="edit">
					<textarea class="message"><?php echo $comment['message'];?></textarea>
					<a name="type" class="btn btn-primary btn-xs editcommentconfirm" href="<?php echo BASE_URL;?>posts/edit/<?php echo $comment['accountid'];?>/<?php echo $comment['id'];?>">Edit</a>
					</span>
				</h5>
				
				<?php if (hasPermission(100)):?> 
				<div class="category"><br/><a class="confirmLink" href="<?php echo BASE_URL;?>posts/make-live/<?php echo $comment['accountid'];?>/<?php echo $comment['id'];?>"><i class="fa fa-plus-square fa-3x"></i></a> <a class="editcomment" href="javascript:void(0);"><i class="fa fa-pencil-square fa-3x"></i></a> <a class="confirmLink" href="<?php echo BASE_URL;?>posts/make-hide/<?php echo $comment['accountid'];?>/<?php echo $comment['id'];?>"><i class="fa fa-minus-square fa-3x"></i></a></div>
				<?php endif;?>
			</div>
			<div class="col-xs-4 pull-right">
				<img class="social_image spacer-sm" src="<?php echo $comment['user_avatar'];?>" title="<?php echo $comment['user_name'];?>" rel="tooltip">
				<p><?php echo $comment['user_name'];?></p>
			</div>
		<div style="clear:both"></div>
	</div>
	<?php endforeach;?>