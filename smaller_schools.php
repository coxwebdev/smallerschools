<?php
$title = "Research on Smaller Schools";
require_once 'head.php';

$xml = simplexml_load_file('http://smallerschoolsresearch.blogspot.com/feeds/posts/default?alt=rss');
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
	}
}

?>

<div id="left_side">
	<div class="box" id="smaller_schools">
		<h3 class="box_header">
			Smaller Schools Research
		</h3>
<?
	foreach ($schools as $post) {
		print_section ($post);
	}
?>
	</div>
</div>

<div id="right_side">
	<?=disp_add_this ()?>

	<div id="related_sites">
		<?=randomQuote()?>
	</div>
</div>


<? 
require_once 'foot.php';
?>
