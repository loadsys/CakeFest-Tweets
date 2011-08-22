<div id="twitImages">
<?php
	$cacheKey = md5('http://api.twitpic.com/2/tags/show.xml?tag=cakefest');
	if ( !$cachedXml = Cache::read($cacheKey, 'feed_short') ) {
		$xml = simplexml_load_file('http://api.twitpic.com/2/tags/show.xml?tag=cakefest', 'SimpleXMLElement', LIBXML_NOCDATA);
		Cache::write($cacheKey, $xml->asXML(), 'feed_short');
	} else {
		$xml = simplexml_load_string($cachedXml, 'SimpleXMLElement', LIBXML_NOCDATA);
	}
	$i=0;
	if ( $xml ) {
		foreach($xml->images as $myFeed) {
			$picId = $myFeed->image->short_id;
			$msg = $myFeed->image->message;		
			echo '<div class="twitImg">';
			echo '<a href="http://twitpic.com/' . $picId . '" title="' . $msg . '" target="_blank"><img src="http://twitpic.com/show/mini/' . $picId . '" /></a>';
			echo '</div>';
			$i++;
			if($i == 6) {
				break;
			}	
		}
	}
?>
<div style="clear:both;"></div>
<span style="font-size: .9em; font-style: italic;">TwitPic Feed (Tag your photo w/ #cakefest)</span>
</div>
