<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="en">
	<title>CakePHP CakeFest 2011 - CakeFestTweets.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Get live, up to date tweets from the CakePHP CakeFest 2011 conference in Manchester. Follow the tweets from the CakePHP developers that are at the conference." />
	<meta name="keywords" content="CakePHP, CakeFest, CakeFestTweets, 2011, CakePHP conference, CakePHP developers" />
	<meta name="title" content="Get live, up to date tweets from the CakePHP CakeFest 2011 conference in Manchester. Follow the tweets from the CakePHP developers that are at the conference." />
	<meta property="og:title" content="CakeFestTweets" />
	<meta property="og:description" content="Get live, up to date tweets from the CakePHP CakeFest 2011 conference in Manchester. Follow the tweets from the CakePHP developers that are at the conference." />
	<?php echo $this->Html->css('styles'); ?>
	<?php echo $this->Html->css('default'); ?>
	<?php //echo $this->Html->css('hot'); ?>
	<?php echo $this->Html->css('cold'); ?>
	<?php //echo $this->Html->css('blue'); ?>
	<?php echo $this->Html->css('superfish/superfish.css'); ?>
	
	<?php echo $this->Html->script('jquery'); ?>
	<?php echo $this->Html->script('jquery-ui'); ?>
	<?php echo $this->Html->script('jquery.form'); ?>

	<?php echo $scripts_for_layout; ?>

	<!--[if lt IE 7]>
	<script src="js/ie6pngfix/DD_belatedPNG_0.0.8a-min.js"></script>
	<script>
			DD_belatedPNG.fix('.logo, #slideshow_wrap, #index_articles img');
	</script>
	<![endif]-->
</head> 
<body>
	<div id="header">
		<h1 class="siteheader"><?php echo $this->Html->link('CakeFest Tweets', '/'); ?></h1>
		<?php echo $this->element('navigation'); ?>
	</div>
	
	<div id="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
	</div> <!--End Content-->

	<div id="footer_wrap">
		<div id="footer_meta">
			<ul>
				<li><?php echo $this->Html->link('Tweets from the conference', '/'); ?></li>
				<li class="seporator">
				&nbsp;
				</li>
				<li><?php echo $this->Html->link('CakExperts', 'http://cakexperts.com', array('target' => '_blank')); ?></li>
				<li class="seporator">
				&nbsp;
				</li>
				<li><?php echo $this->Html->link('Loadsys', 'http://loadsys.com', array('target' => '_blank')); ?></li>
				<li class="seporator">
				&nbsp;
				</li>
				<?php if (AuthComponent::user()): ?>
					<li><?php echo $this->Html->link('User List', array('controller' => 'users', 'action' => 'index')); ?></li>
				<?php endif; ?>
			</ul>
			<div id="copyright">
				&copy; <?php echo date("Y"); ?> CakeFestTweets.com
			</div>
			<p><a href="http://www.cakephp.org" target="_blank">CakePHP</a> is a registered trademark of the <a href="http://cakefoundation.org" target="_blank">Cake Software Foundation</a>.  CakeFestTweets.com is not affiliated with CakePHP or the Cake Software Foundation in any way.</p>
		</div>
	</div>
	
	<script type="text/javascript">
		function resize_content() {
			var headerHeight = $("#header").outerHeight(true);
			var footerHeight = $("#footer_wrap").outerHeight(true);
			var contentHeight = $(window).height() - headerHeight - footerHeight - 40;
			if(contentHeight < 380) {
				contentHeight = 380;
			}
			$("#content").attr('style', 'min-height: '+contentHeight+'px');
		}
		resize_content();
		$(window).resize(function() {
			resize_content();
		});
		$(document).ready(function() {
			setTimeout(function() {
				if($("#flashMessage")) {
					$("#flashMessage").fadeOut(1000);
				}
			}, 5000);
		});
	</script>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-371281-8']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>

<?php echo $this->element('sql_dump'); ?> 

</body> 
</html>