<?php
$title = "Smaller Schools, Community-sized Districts";
require_once 'head.php';

$yesterday = strtotime('yesterday');
$ss_blog = 'http://smallerschoolsresearch.blogspot.com/feeds/posts/default?alt=rss';
$ssr_blog = 'http://smallerschools.blogspot.com/feeds/posts/default?alt=rss';

$filename = 'logs/ss_cache.xml';
if (!file_exists($filename) || filemtime($filename) < $yesterday) {
	$xml = simplexml_load_file($ss_blog);
	$xml->asXML($filename);
} else {
	$xml = simplexml_load_file($filename);
}

//debug($xml);
$i = 0;
$schools = array();
$districts = array();
foreach ($xml->channel->item as $post) {
	//debug($post);
	foreach ($post->category as $cat) {
		if ($cat == 'smaller schools') {
			$schools[] = $post;
		}
		if ($cat == 'smaller districts') {
			$districts[] = $post;
		}
	}
}

$filename = 'logs/ssr_cache.xml';
if (!file_exists($filename) || filemtime($filename) < $yesterday) {
	$xml = simplexml_load_file($ssr_blog);
	$xml->asXML($filename);
} else {
	$xml = simplexml_load_file($filename);
}
//debug($xml);

?>

<div id="left_side">
	<div class="box" id="blog_feed">
		<h3 class="box_header">
			<a href="http://smallerschools.blogspot.com">Smaller Schools Blog</a>
		</h3>
<?
$i = 0;
$categories = array();
$related_sites = array();
foreach ($xml->channel->item as $post) {
	if ($post->category == 'related sites') {
		$related_sites[] = $post;
	} else {
		//debug($post);
		$title = $post->title;
		$cats = array();
		if (is_array($post->category)) {
			$cats = $post->category;
		} else {
			$cats[0] = ''.$post->category;
		}
		foreach ($cats as $cat) {
			if (isset($categories[$cat])) {
				$categories[$cat]++;
			} else {
				$categories[$cat] = 1;
			}
		}
		$content = strip_tags($post->description);
		$published = $post->pubDate;
		$href = $post->link;
		echo '<div class="blog_head"><a href="'.$href.'">'.$title.'</a></div>';
		echo '<div class="post_date">'.convertDate($published).'</div>';
		echo '<div class="blog_feed">'.substr($content, 0, strpos($content, ' ', 200)).'... <a href="'.$href.'">(View)</a></div>';
		echo '<div class="spacer">&nbsp;</div>';
		$i++;
		if ($i >= 5) break; // only 5 posts
	}
}
?>
	</div>

	<div class="box" id="smaller_schools">
		<h3 class="box_header">
			<a href="/smaller_schools.php">Smaller Schools Research</a>
		</h3>
<?
	foreach ($schools as $post) {
		print_section ($post);
	}
?>
	</div>

	<div class="box" id="smaller_districts">
		<h3 class="box_header">
			<a href="/smaller_districts.php">Community-sized Districts Research</a>
		</h3>
<?
	foreach ($districts as $post) {
		print_section ($post);
	}
?>
	</div>
</div>

<div id="right_side">
	<?=disp_add_this ()?>

	<div id="related_sites">
<?
	foreach ($related_sites as $post) {
		//debug($post);
		echo '<div class="blog_head">Related Websites</div>';
		echo $post->description;
	}
?>
	</div>
</div>


<? 
require_once 'foot.php';
?>
