<?php
session_start();

$titlecase_replace = array('_');
$underscores_replace = array(' ');
$is_mobile = checkmobile();

function checkmobile() {
	if(isset($_SERVER["HTTP_X_WAP_PROFILE"])) return true;
	if(preg_match("/wap\.|\.wap/i",$_SERVER["HTTP_ACCEPT"])) return true;
	if(isset($_SERVER["HTTP_USER_AGENT"])){
		// Quick Array to kill out matches in the user agent
		// that might cause false positives
		$badmatches = array("Creative\ AutoUpdate","OfficeLiveConnector","MSIE","MSIE\ 7\.0","MSIE\ 8\.0");
		foreach($badmatches as $badstring){
			if(preg_match("/".$badstring."/i",$_SERVER["HTTP_USER_AGENT"])) return false;
		}
	
		// Now we'll go for positive matches
		if(preg_match("/Creative\ AutoUpdate/i",$_SERVER["HTTP_USER_AGENT"])) return false;
		$uamatches = array("midp", "j2me", "avantg", "docomo", "novarra", "palmos", "palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/", "blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", "phone", "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", "mot\-", "mitsu", "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", "philips", "mmm", "xx", "panasonic", "sharp", "wap", "sch", "rover", "pocket", "benq", "java", "pt", "pg", "vox", "amoi", "bird", "compal", "kg", "voda", "sany", "kdd", "dbt", "sendo", "sgh", "gradi", "jb", "\d\d\di", "moto");
		foreach($uamatches as $uastring){
			if(preg_match("/".$uastring."/i",$_SERVER["HTTP_USER_AGENT"])) return true;
		}
	}
	return false;
}

function underscores($text) {
	global $titlecase_replace, $underscores_replace;
	return strtolower(str_replace($underscores_replace, $titlecase_replace, $text));
}

function titlecase($text) {
	global $titlecase_replace, $underscores_replace;
	return ucwords(str_replace($titlecase_replace, $underscores_replace, $text));
}

function convertDate($date) {
	$text = strtotime($date);
	$date = date('d F Y', $text);
	return $date;
}

function send_mail($to, $subj, $mesg, $from){
	$eol = "\r\n";
	$header  = "From: " .$from." <".$from.">".$eol;
	$header .= "Reply-to: <".$from.">". $eol;
	$header .= "Return-Path: <".$from.">". $eol;
	$header .= "MIME-Version: 1.0".$eol;
	$header .= "X-Mailer: PHP v".phpversion().$eol;
	$header .= "X-Priority: 3".$eol;
	$header .= "X-MSMail-Priority: High".$eol;
 	$header .= "Content-Type: text/html; charset=iso-8859-1;\n\n".$eol;
	echo $header;
	$success = mail ($to, $subj, $mesg, $header);
	die($success);
	
	return $success;
}

function debug($data) {
	echo '<pre>';
	debug_backtrace();
	print_r($data);
	echo '</pre>';
}

function print_section ($post) {
//	debug($post->description);
	$title = $post->title;
	$search = array('&nbsp;', '\n', '<br />', 'View as a PDF', '<');
	$replace = array(' ', ' ', ' ', ' ', ' <');
	$content = strip_tags(str_replace($search, $replace, $post->description));
	$href = $post->link;
	echo '<div class="blog_head"><a href="'.$href.'">'.$title.'</a></div>';
	echo '<div class="blog_feed">'.substr($content, 0, strpos($content, ' ', 200)).'... <a href="'.$href.'">(View)</a></div>';
	//echo '<div class="spacer">&nbsp;</div>';
}

function disp_add_this () {
	echo '
	<div class="addthis_toolbox addthis_default_style" style="float:right;font-family:">
	    <a class="addthis_button_facebook sans" title="Share on Facebook"></a>
	    <a class="addthis_button_twitter sans" title="Tweet"></a>    
	    <a class="addthis_button_googlebuzz sans" title="Buzz on Google"></a>
	    <a class="addthis_button_email sans" title="Email to a Friend"></a>
        <a class="addthis_button_favorites sans" title="Bookmark"></a>
        <a class="addthis_button_blogger sans" title="Blogger"></a>
        <a class="addthis_button_google sans" title="Google"></a>
	    <a class="addthis_button_facebook_like sans" title="Like This"></a>
		<br>
        <a class="addthis_button_digg sans" title="Digg This"></a>
        <a class="addthis_button_delicious sans" title="Delicious"></a>
        <a class="addthis_button_stumbleupon sans" title="Stumble Upon"></a>
		<a href="http://addthis.com/bookmark.php?v=250" title="Share/Bookmark" class="addthis_button_expanded sans">Share</a>
	</div>
	<iframe src="http://www.facebook.com/plugins/likebox.php?id=132842423426264&amp;width=250&amp;connections=0&amp;stream=false&amp;header=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:65px;" allowTransparency="true"></iframe>
';
}

function randomQuote () {
	$quotes[] = 'The best way to prevent a political faction or any small group of people from capturing control of the nation\'s educational system is to <i>keep it decentralized into small local units</i>, each with its own board of education and superintendent. <br><br>- by Ezra T. Benson';
	$quotes[] = 'Men ... should do their actual living and working in communities ... small enough to permit of genuine self-government and the assumption of personal responsibilities, federated into larger units in such a way that the temptation to abuse great power should not arise.<br><br>- Mahatma Mohandas K. Gandhi';
	$quotes[] = 'The way to have good and safe government is not trust it all to one, but to divide it among the many, distributing to everyone exactly the functions in which he is competent.<br><br>- Thomas Jefferson';
	$quotes[] = '<i>"...achievement drops as enrollment levels rise." </i><br><br> - From \'A District of a Certain Size, An Exploration of the Debate on School District Size\' by Florence R. Webb University of California, Berkeley';
	$quotes[] = '<i>"<b>Why does smaller seem to work better?</b>  ...people seem to learn, to change, and to grow in situations in which they feel they they have some control, some personal influence, some efficacy.  Those situations in which parents, teachers, and students are bonded together in the pursuit of learning are likely to be the most productive." </i><br><br> - From \'Size, The Ultimate Educational Issue?\' by Barney M. Berlin, Robert C. Cienkus, Loyola University of Chicago';
	$quotes[] = '<i><b>"...large schools are concentrated in large districts."</b> </i><br><br> Coleman and Laroque (1986)';
	$quotes[] = '<i><b>"Students in states with smaller districts and smaller schools have higher SAT and ACT scores."</b> </i><br><br>-From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\' by Robert W. Jewell, University of Chicago';
	$quotes[] = '<i>"School district size has a consistent negative relation to student performance and is highly significant in three out of four tests." </i><br><br>- W. Nishkanen &amp; M. Levy, University of California, Berkeley';
	$quotes[] = '<i>"The demise of small districts was coincidental with the demise of small schools.  The two phenonmena together have led to a serious disconnect between young people and adults, between youth culture and adult culture." </i><br><br>- Deborah Meier';
	$quotes[] = '<i>"As school systems across the country struggle with questions of testing, quality and accountability, they need to look at school district size as a variable." </i><br><br>- Mike Antonucci';
	$quotes[] = 'Local and independent school systems ... are more responsive to the needs and wishes of the parents and the community. The door to the school superintendent\'s office is usually open to any parent who wishes to make his views known. <br><br>- Ezra T. Benson';
	$quotes[] = '<i>"Webb &amp; Ohm (1984) found smaller districts more efficient than larger ones in both dollars per student and numbers of administrators per student...." </i><br><br>- From \'A District of a Certain Size, An Exploration of the Debate on School District Size\' by Florence R. Webb University of California, Berkeley';
	$quotes[] = '<i>"But it appears that smaller districts on average may be more effective and efficient: Their students appear to score higher on standardized tests (other things being equal) and they may be more satisfying to parents and citizens." </i><br><br>- From \'District Size and Student Learning\', by Herbert J. Walberg - University of Illinois at Chicago';
	$quotes[] = '<i>"Similarly, Strang (1987) documented the rising power of state bureaucracy and the decline of local autonomy even as districts grew larger. He saw the transformation of U.S. education from informal community control into large-scale bureaucratic organization stemming in part from the expansionary role of the states." </i><br><br>-From \'District Size and Student Learning\', by Herbert J. Walberg - University of Illinois at Chicago';
	$quotes[] = '<i>"Smaller districts (and privately financed schools) can ill afford such specialization but may actually have advantages in maintaining a cohesive general curriculum; adapting to local preferences and conditions; and strengthening ties among school, home, and community. Such districts may do fewer things better and avoid spurious categorization of students and needless administrative complexity." </i><br><br>- From \'District Size and Student Learning\', by Herbert J. Walberg - University of Illinois at Chicago';
	$quotes[] = '<i>"...a significant number of families may choose to send their children to private schools because they wish to avoid educational associations for their children with large public school districts and/or large public schools." </i><br><br>- From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\' by Robert W. Jewell, University of Chicago';
	$quotes[] = '<i>"Students in states with smaller districts and smaller schools have higher SAT and ACT scores." </i><br><br>- From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\' by Robert W. Jewell, University of Chicago';
	$quotes[] = '<i>"Minority public schools in the United States are concentrated in states that have large school districts and school districts that have large schools." (Could this be one reason why minorities are struggling to improve?) </i><br><br>- From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\' by Robert W. Jewell, University of Chicago';
	$quotes[] = '<i>"Per-pupil expenditure averages ... have no significant statistical relationship ...(to) average school district sizes, proportions of students in large districts, or average school sizes." (Large district size does not appear to be less expensive.)  </i><br><br>- From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\' by Robert W. Jewell, University of Chicago';
	$quotes[] = '<i>"...private school enrollment ... has strong positive relationships with district size and school size -- the larger the districts and schools, the higher the proportion of non-Catholic private school enrollments among the states."  </i><br><br>- From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\' by Robert W. Jewell, University of Chicago';
	$quotes[] = '<i>"Generally, there is agreement that unit costs are higher in the smallest and largest schools. Various studies characterize per-pupil costs as having a U-shaped average cost curve, where costs are high in both the smallest and largest schools."  </i><br><br>- From \'School Size, The Continuing Controversy\' by Kent McGuire, Education Commission of the States';
	$quotes[] = '<i>"The number of school districts was then reduced from approximately 128,000 in 1930 to 36,000 in 1960. There are fewer than 16,000 today."  </i><br><br>- From \'School Size, The Continuing Controversy\' by Kent McGuire, Education Commission of the States';
	$quotes[] = '<i>"Real spending on K-12 education in the U.S. increased more than fourfold -- after inflation (National Center for Educational Statistics, 1973, in Guthrie, 1979) -- during the period when district consolidations were increasing district size one hundred and fifty fold." </i><br><br>- From \'A District of a Certain Size, An Exploration of the Debate on School District Size\' by Florence R. Webb University of California, Berkeley';
	$quotes[] = '<i>"But it appears that smaller districts on average may be more effective and efficient: Their students appear to score higher on standardized tests (other things being equal) and they may be more satisfying to parents and citizens." </i><br><br>- Fron \'District Size and Student Learning\', by Herbert J. Walberg, University of Illinois at Chicago.';
	$quotes[] = '<i>"Generally, it appears that the smaller the district, the higher the achievement when the socioeconomic status and per student expenditures are taken into account. Why? Superintendent and central staff awareness of citizen and parent preferences, the absence of bureaucratic layers and administrative complexity, teacher involvement in decision making, and close home/school relations." </i><br><br>- From \'School and School District Size Relationships: Costs, Results, Minorities, and Private School Enrollments\', by Robert W. Jewell, University of Chicago.';

	$quote_num = date('d') % sizeof($quotes);
	echo '<div class="blog_head">Quote of the Day</div>';
	echo '<div class="post_date">#'.$quote_num.'</div>';
	echo $quotes[$quote_num];
}

?>