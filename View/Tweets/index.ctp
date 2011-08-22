<div class="index">
	<?php //echo $this->element('twitpic'); ?>
	<div class="clearfix">
		<div class="left width-40">
			<?php echo $this->Html->link(
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
			); ?>
		</div>
		<div class="socialShare left width-60">
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
		</div>
	</div>
	<div class="tweets elements">
	</div>
	<div class="users elements">
	</div>
	<div style="clear: both"></div>
	<div class="socialShare">
		<p>Brought to you by</p>
		<?php echo $this->Html->link(
			$this->Html->image('loadsys_logo.png'),
			'http://loadsys.com',
			array('escape' => false),
			false
		); ?>
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
<script type="text/javascript">
var since_id = null;
$(document).ready(function() {
	loadTweets();
	loadUsers();
	setInterval(function() {
		loadTweets();
	}, 45000);
	setInterval(function() {
		loadUsers();
	}, 60000);
});

function loadTweets() {
	var url = "<?php echo Router::url('/tweets/tweets', true); ?>";
	if (since_id) {
		url = url + '/' + since_id;
	}
	$.ajax({
		"url": url,
		"dataType": "json",
		"success": function(data) {
			var count = data.tweets.length;
			var tweetDivStart = '<div class="tweet">';
			var tweetDivEnd = '</div>';
			var username = '';
			var userimage = '';
			var text = '';
			var client = '';
			var date = '';
			var tweetCell = '';
			var from = '';
			for (var i in data.tweets) {
				username = '<div class="tweetUserName"><a href="http://www.twitter.com/'+data.tweets[i].Tweet.username+'" target="_blank">'+data.tweets[i].Tweet.username+'</a></div>';
				userimage = '<div class="tweetImage"><img src="'+data.tweets[i].Tweet.user_image+'" /></div>';
				text = '<div class="tweetText '+data.tweets[i].Tweet.tweet_id+'">'+data.tweets[i].Tweet.content+'</div>';
				from = unescape(data.tweets[i].Tweet.from);
				client = '<div class="tweetFooter"><div class="tweetClient">'+unescape(data.tweets[i].Tweet.from)+'</div>';
				date = '<div class="tweetDate">'+data.tweets[i].Tweet.created+'</div></div>';
				tweetCell = tweetDivStart+userimage+username+textReplacement(text)+client+date+tweetDivEnd;
				$(".tweets").prepend(tweetCell);
			}
			since_id = data.since_id;
		}
	});
	var i = 0;
	$(".tweet").each(function() {
		i++;
		if (i >= 50) {
			$(this).remove();
		}
	});
}
function loadUsers() {
	var url = "<?php echo Router::url('/tweets/users', true); ?>";
	$.ajax({
		"url": url,
		"dataType": "json",
		"success": function(data) {
			var userDivStart = '<div class="user">';
			var userDivEnd = '</div>';
			var username = '';
			var userimage = '';
			var tweetCount = '';
			var userCell = '';
			$(".users").html('');
			for (var i in data) {
				username = '<div class="userUserName"><a href="http://www.twitter.com/'+data[i].User.username+'" target="_blank">'+data[i].User.username+'</a></div>';
				userimage = '<div class="userImage"><img src="'+data[i].User.user_image+'" /></div>';
				tweetCount = '<div class="userTweetCount">'+data[i].User.tweet_count+'</div>';
				userCell = userDivStart+userimage+username+tweetCount+userDivEnd;
				$(".users").append(userCell);
			}
		}
	});
}
function textReplacement(text) {
	text = replaceURLWithHTMLLinks(text);
	text = replaceUserTagWithURL(text);
	text = replaceHashTags(text);
	return text;
}
function replaceURLWithHTMLLinks(text) {
	var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
	return text.replace(exp,"<a href='$1' target='_blank' style='text-decoration: underline;'>$1</a>"); 
}
function replaceUserTagWithURL(text) {
	var exp = /\@([A-Z0-9a-z\-_]+)/ig;
	return text.replace(exp,"<a href='http://www.twitter.com/$1' target='_blank' style='text-decoration: underline;'>@$1</a>");
}
function replaceHashTags(text) {
	var exp = /\#([A-Z0-9a-z\-_]+)/ig;
	return text.replace(exp,"<a href='http://www.twitter.com/#search?q=$1' target='_blank' style='text-decoration: underline;'>#$1</a>");
}
</script>
