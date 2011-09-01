<div class="index">
	<?php //echo $this->element('twitpic'); ?>
	<div class="clearfix">
		<div class="left width-60">
			<div style="padding-bottom:10px;" class="provided-by">
				<?php echo $this->Html->link(
					$this->Html->image('loadsys_logo.png'),
					'http://loadsys.com',
					array('escape' => false, 'class' => 'right'),
					false
				); ?>
				<p>This project, built in CakePHP 2.0,<br />is brought to you by:</p>
			</div>
		</div>
		<?php /*<div class="socialShare left width-40">
			<div class="facebookShare">
				<a name="fb_share" type="box_count" href="http://www.facebook.com/sharer.php">Share</a>
				<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
			</div>
			<div class="twitterRetweet">
				<script type="text/javascript">
					tweetmeme_source = 'loadsys';
				</script>
				<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
			</div>
			<div style="clear:both"></div>
		</div> */ ?>
	</div>
	<div class="tweets elements">
	</div>
	<div class="users elements">
	</div>
	<div style="clear: both"></div>
	<div class="socialShare">
		<p>
			<?php /*echo $this->Html->link(
				$this->Html->image(
					'cake.png',
					array(
						'alt' => 'CakePHP 1.3',
						'height' => 60,
						'width' => 60
					)
				),
				'http://cakephp.org',
				array(
					'escape' => false,
					'target' => '_blank'
				),
				false
			);*/ ?>
			<?php /*echo $this->Html->link(
				$this->Html->image(
					'jquery.png',
					array(
						'alt' => 'jQuery 1.4',
						'height' => 50,
						'width' => 200
					)
				),
				'http://jquery.com/',
				array(
					'escape' => false,
					'target' => '_blank'
				),
				false
			);*/ ?>
			<?php /*echo $this->Html->link(
				$this->Html->image(
					'mongoDB.png',
					array(
						'alt' => 'MongoDB',
						'height' => 50,
						'width' => 164
					)
				),
				'http://www.mongodb.org/',
				array(
					'escape' => false,
					'target' => '_blank'
				),
				false
			);*/ ?>
		</p>
	</div>
</div>

<script src="<?php echo Router::url('/js/application.js'); ?>"></script>
