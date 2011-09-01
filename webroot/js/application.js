var since_id = null;
$(document).ready(function() {
	loadTweets();
	loadUsers();
	setInterval(function() {
		loadTweets();
	}, 60000);
	setInterval(function() {
		loadUsers();
	}, 60000);
});

function loadTweets() {
	var url = "/tweets/tweets";
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
	var url = "/tweets/users";
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