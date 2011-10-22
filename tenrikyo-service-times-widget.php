<?php
/**
Plugin Name: Tenrikyo HQ Service Times
Plugin URI: http://servicetimes.tenrikyo-resource.com
Description: Displays the current service times at the Tenrikyo Church Headquarters.
Author: Lewis Nakao - Tenrikyo Resource
Version: 0.1.1
Author URI: http://wiki.tenrikyo-resource.com/User:Lewdev

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

//Add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'trst_load_widgets' );

//Register our widget.
function trst_load_widgets() {
	register_widget( 'trServiceTimes' );
}
class trServiceTimes extends WP_Widget {
	var $lang;
	var $title;

	# Annual Events ([day]-[month])

	var $languages = array(
		"en" => "English"
	,	"ja" => "日本語"
	#,	"pt" => "Portugese"
	#,	"es" => "Espanio" // Spanish
	#,	"kr" => "" // Korean
	);
	var $annualevents = array(
		"1/26" => array("event" => "Spring Grand Service",	"time" => "9:00 AM"),
		"2/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"3/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"4/18" => array("event" => "Oyasama's Birthday",	"time" => "9:00 AM"),
		"4/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"5/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"6/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"7/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"7/27" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"7/28" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"7/29" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"7/30" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"7/31" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"8/1" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"8/2" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"8/3" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"8/4" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"8/5" => array("event" => "Children's Pilgrimage",	"time" => "8:00 AM"),
		"8/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"9/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"10/26" => array("event" => "Autumn Grand Service",	"time" => "9:00 AM"),
		"11/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
		"12/26" => array("event" => "Monthly Service",		"time" => "9:00 AM"),
	);
	
	/**
	 * Service Times
	 * i.e. morning A = morning service time during the first half of the month.
	 */
	var $servicetimes = array(
		1 => array( # January
			"month" => "January",
			"morningA" => "7:00 AM", "eveningA" => "5:00 PM"
		,	"morningB" => "7:00 AM", "eveningB" => "5:15 PM"),
		2 => array( # February
			"month" => "February",
			"morningA" => "7:00 AM", "eveningA" => "5:30 PM"
		,	"morningB" => "6:45 AM", "eveningB" => "5:45 PM"),
		3 => array( # March
			"month" => "March",
			"morningA" => "6:00 AM", "eveningA" => "6:00 PM"
		,	"morningB" => "6:45 AM", "eveningB" => "6:30 PM"),
		4 => array( # April
			"month" => "April",
			"morningA" => "6:00 AM", "eveningA" => "6:30 PM"
		,	"morningB" => "6:00 AM", "eveningB" => "6:45 PM"),
		5 => array( # May
			"month" => "May",
			"morningA" => "5:30 AM", "eveningA" => "7:00 PM"
		,	"morningB" => "5:15 AM", "eveningB" => "7:15 PM"),
		6 => array( # June
			"month" => "June",
			"morningA" => "5:00 AM", "eveningA" => "7:30 PM"
		,	"morningB" => "5:00 AM", "eveningB" => "7:30 PM"),
		7 => array( # July
			"month" => "July",
			"morningA" => "5:00 AM", "eveningA" => "7:30 PM"
		,	"morningB" => "5:15 AM", "eveningB" => "7:30 PM"),
		8 => array( # August
			"month" => "August",
			"morningA" => "5:30 AM", "eveningA" => "7:15 PM"
		,	"morningB" => "5:30 AM", "eveningB" => "7:00 PM"),
		9 => array( # September
			"month" => "September",
			"morningA" => "5:45 AM", "eveningA" => "6:45 PM"
		,	"morningB" => "6:00 AM", "eveningB" => "6:30 PM"),
		10 => array( # October
			"month" => "October",
			"morningA" => "6:00 AM", "eveningA" => "6:00 PM"
		,	"morningB" => "6:15 AM", "eveningB" => "5:45 PM"),
		11 => array( # November
			"month" => "November",
			"morningA" => "6:30 AM", "eveningA" => "5:30 PM"
		,	"morningB" => "6:45 AM", "eveningB" => "5:15 PM"),
		12 => array(
			"month" => "December",
			"morningA" => "7:00 AM", "eveningA" => "5:00 PM"
		,	"morningB" => "7:00 AM", "eveningB" => "5:00 PM")
	); // end $servicetimes = array()
	
	// Translations are based off of the English terms
	// note: If there is no translation, then it will just display as it is, so 
	//   the English translations are not needed.
	var $trans = array(
		"ja" => array(
			"Tenrikyo HQ Service Times" => "天理教本部おつとめ時間",
			"%year%th Year" => "立教%year%年",
			", first half of " => "前半",
			", second half of " => "後半",
			"Morning Service" => "朝おつとめ",
			"Evening Service" => "夕おつとめ",
			"Tomorrow" => "明日",
			"Today" => "今日",
			"January" => "1月",
			"February" => "2月",
			"March" => "3月",
			"April" => "4月",
			"May" => "5月",
			"June" => "6月",
			"July" => "7月",
			"August" => "8月",
			"September" => "9月",
			"October" => "10月",
			"November" => "11月",
			"December" => "12月",
			"Morning" => "朝",
			"Evening" => "夕",
			"Month" => "月",
			"Spring Grand Service" => "春季大祭",
			"Autumn Grand Service" => "秋季大祭",
			"Monthly Service" => "月次祭",
			"Oyasama's Birthday" => "教祖の誕生祭",
			"Children's Pilgrimage" => "こどもおぢばがえり",
		)
	); // end $trans = array()

	function __construct() {
		$widget_ops = array('classname' => 'trServiceTimes', 'description' => __( 'Displays the current service times at the Tenrikyo Church Headquarters and other important Tenrikyo events.' ) );
		parent::__construct('trServiceTimes', __('Tenrikyo HQ Service Times'), $widget_ops);
		$this->alt_option_name = 'trServiceTimes';
		//#parent::WP_Widget('trServiceTimes', $name = 'TR Service Times');

		$this->title = "Tenrikyo HQ Service Times";
		$this->lang = 'en';
	}

	function trans($phrase) {
		if( !$this->trans[$this->lang][$phrase] && $this->lang == 'en'):
			$str = $phrase;
		else:
			$str = $this->trans[$this->lang][$phrase];
		endif;
		$str = str_replace("%year%",(int)gmdate("Y", time()) - 1837, $str);
		return $str;
	} // end function trans()

	function getAnnualEvent($when, $monthday) {
		$str = "";
		if($this->annualevents[$monthday]["event"]) 
			$str = "<p><strong>".$this->trans($when).":</strong> "
				.$this->trans($this->annualevents[$monthday]["event"])."</p>";
		return $str;
	}

	// outputs the options form on admin
	function form($instance) {
		$defaults = array(
				'title'	=> __('Tenrikyo HQ Service Times', 'trServiceTimes')
			,	'lang'	=> __('English', 'en'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p> <!-- Widget Title: Text Input -->
			<label for="<?=$this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?=$this->get_field_id('title'); ?>" 
				name="<?=$this->get_field_name('title'); ?>" 
				value="<?=$instance['title']; ?>" 
				style="width:100%;" /><br/>
				<?=($this->lang == 'en')?"Sugestion: Tenrikyo HQ Service Times":""?>
				<?=($this->lang == 'jp')?"提案：天理教本部おつとめ時間":""?>
		</p>
		<p>	<!-- Language: Dropdown box -->
			<label for="<?=$this->get_field_id( 'lang' ); ?>"><?php _e('Language:', 'hybrid'); ?></label>
			<select name="<?=$this->get_field_name( 'lang' ); ?>">
				<option value="<?=$this->lang ?>"><?=$instance['lang']; ?></option>
				<option value="en">English</option>
				<option value="ja">日本語</option>
			</select>
		</p>
	<?php
	}

	// Processes widget options to be saved. Update the widget settings.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['lang'] = strip_tags( $new_instance['lang'] );
		$this->title = strip_tags( $new_instance['title'] );
		$this->lang = strip_tags( $new_instance['lang'] );
		#$instance['lang_name'] = strip_tags( $new_instance['lang_name'] );

		return $instance;
	}

	// outputs the content of the widget
	function widget($args, $instance) {
		extract( $args);
		date_default_timezone_set("Asia/Tokyo");

		// get options
		$options = get_option( 'widget_TenrikyoServiceTimes' );
		if ( empty( $options['title']) && $this->title=="") {
			$this->title = $this->trans("Tenrikyo HQ Service Times");
		} else {
			$this->title = $options['title'];
		}
		#get current month and day
		$month = (int)gmdate("m", time());
		$day = (int)gmdate("d", time());
		#$month = 10; $day = 26; #test

		$this->title = $instance['title'];
		$this->lang = $instance['lang'];

		# determine which half of the month
		# "A" = first half; "B" = second half
		$half = (($day <= 15)?"A":"B");

		# Get service times
		$morning = $this->servicetimes[$month]["morning".$half];
		$evening = $this->servicetimes[$month]["evening".$half];
		?>
<script type="text/javascript">
function tstShowChart() {
	//stchart
	document.getElementById("stchart").style.display = "block";
	document.getElementById("tstShow").style.display = "none";
	document.getElementById("tstHide").style.display = "block";
}
function tstHideChart() {
	//stchart
	document.getElementById("stchart").style.display = "none";
	document.getElementById("tstShow").style.display = "block";
	document.getElementById("tstHide").style.display = "none";
}
</script>

<style type="text/css">
#servicetimes { width:100%; border-bottom:1px gray solid; border-right:1px gray solid; }
#servicetimes td, #servicetimes th {
	padding:0px;margin:0px;
	border-top:1px gray solid;
	border-left:1px gray solid;
	text-align:center;
}
#stchart, #servicetimes td, #servicetimes th {
	font-family:Verdana;
	valign:middle;
	color:black;
	font-size:7.5pt;
}
#servicetimes tr.alt {
	background-color:#CCCCCC;
}
#servicetimes tr.thismonth {
	background-color:#ffff99;
}
.hidden { display:none; }
</style>

		<?=$before_widget?>
		<?php if( $this->title) echo $before_title . $this->title . $after_title; ?>
	
		<p><?=$this->trans("%year%th Year")
			.$this->trans(", ".(($half=='A')?"first":"second")." half of ")
			.$this->trans(gmdate("F", time()))?><br/>
		<strong><?=$this->trans("Morning Service")?>:</strong> <?=$morning?><br/>
		<strong><?=$this->trans("Evening Service")?>:</strong> <?=$evening?>
		</p>
		<?#=$this->getAnnualEvent("Today", "1/26")?>
		<?#=$this->getAnnualEvent("Tomorrow", "10/26")?>
	
		<?=$this->getAnnualEvent("Today","$trst_month-$trst_day")?>
		<?=$this->getAnnualEvent("Tomorrow",$trst_month."-".$trst_day+1)?>

		<p align="right">
		<a href="javascript:tstShowChart()" id="tstShow">Show time chart.</a>
		<a href="javascript:tstHideChart()" id="tstHide" class="hidden">Hide time chart.</a></p>

		<?=$this->_displayServiceTimes()?>
		<?=$after_widget; ?>

		<?php
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function _displayServiceTimes() {
		$st = $this->servicetimes;
		$thismonth = (int)gmdate("m", time());
		$str = '<div class="hidden" id="stchart">
'.$this->trans("Each month is divided in half:<br/> 1st to 15th &amp; 16th to end of month.").'
<table id="servicetimes" cellspacing="0" cellpadding="0">
<tbody>
<tr>
	<th>'.$this->trans("Month").'</th>
	<th>'.$this->trans("Morning").'</th>
	<th>'.$this->trans("Evening").'</th>
</tr>';
		for($i = 1;$i<=12;$i++) {
			$month = $st[$i]["month"];
			$morningA = $st[$i]["morningA"];
			$eveningA = $st[$i]["eveningA"];
			$morningB = $st[$i]["morningB"];
			$eveningB = $st[$i]["eveningB"];
			if($i == $thismonth)
				$str .="<tr class=\"thismonth\">\n";
			else
				$str .="<tr>\n";
			$str .='<td rowspan="2">'.$this->trans($month)."</td>\n";
				$str .='<td '.(($morningA==$morningB)?'rowspan="2"':'').'>'.$morningA."</td>\n";
				$str .='<td '.(($eveningA==$eveningB)?'rowspan="2"':'').'>'.$eveningA."</td>\n";
			$str .="</tr>\n";
			$str .="<tr class=\"alt\">\n";
				if($morningA!=$morningB) $str .="<td>".$morningB."</td>\n";
				if($eveningA!=$eveningB) $str .="<td>".$eveningB."</td>\n";
			$str .="</tr>\n";
		}
		$str .= '
</tbody>
</table>
<p align="right">See the <a href="http://www.tenrikyo.or.jp/eng/?page_id=77" target="_blank">official chart</a>.</p>
</div>
';
		return $str;
	}
} // end class trServiceTimes