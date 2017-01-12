<?php


function pr ($var, $return = 0)
{
	if ($return) {
		$str .= '<pre>' . print_r($var, true) . '</pre>';

		return $str;
	} else {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
}

function sp_get_title ()
{
	global $template;
	global $WebSetting;
	if ($template->title == "") {
		echo $WebSetting["title"];
	} else {
		echo $template->title;
	}
}

function sp_get_meta_key ()
{
	global $WebSetting;
	global $template;
	if ($template->metakey == "") {
		echo "<meta name=\"Keywords\" content=\"" . $WebSetting["metakey"] . "\" />";
	} else {
		echo "<meta name=\"Keywords\" content=\"" . $template->metakey . "\" />";
	}
}

function sp_get_meta_description ()
{
	global $WebSetting;
	global $template;
	if ($template->metades == "") {
		echo "<meta name=\"Description\" content=\"" . $WebSetting["metadescription"] . "\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />";
	} else {
		echo "<meta name=\"Description\" content=\"" . $template->metades . "\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />";
	}

}

//fungsi templating dari scalarPHP supaya themes wiederverwendbar
function sp_get_content ()
{
	global $template;
	foreach ($template->content as $c) {
		echo $c;
	}
}

function sp_get_bodyload ()
{
	global $template;
	echo $template->onload;
}

function sp_get_bodyfirst ()
{
	global $template;
	foreach ($template->bodyphpfilesfirst as $j1) {
		@include "$j1";
	}
	foreach ($template->bodyfirst as $bf) {
		echo $bf;
	}
}

function sp_get_bodylast ()
{
	global $template;
	foreach ($template->bodylast as $be) {
		echo $be;
	}
	foreach ($template->bodyphpfileslast as $j2) {
		@include "$j2";
	}
}

function toRow ($obj)
{
	$row = array ();

	foreach ($obj as $key => $value) {
		$row[$key] = $value;
	}

	return $row;
}

function defineJump ()
{
	if ($_SESSION["roles"][0] == "admin") {
		global $c__Adminonly;
		$_SESSION["tabselected"] = $c__Adminonly->name;
		header("Location:" . _BPATH . $c__Adminonly->mainurl);
		exit();
	} elseif ($_SESSION["roles"][0] == "supervisor") {

		global $c__Supervisorhome;
		$_SESSION["tabselected"] = $c__Supervisorhome->name;
		header("Location:" . _BPATH . $c__Supervisorhome->mainurl);
		exit();
	} else {
		if ($_SESSION["roles"][0] == "murid") {
			global $c__Mobile;
			if ($_SESSION['isMobile']) {
				header("Location:" . _BPATH . $c__Mobile->mainurl);
				exit();
			}
		}

		$rol = ucfirst($_SESSION["roles"][0]);
		//echo $rol;
		eval ("global \$c__{$rol};");
		eval ("\$drol = \$c__{$rol};");
		// pr($drol); exit();

		$_SESSION["tabselected"] = $drol->name;
		header("Location:" . _BPATH . $drol->mainurl);
		exit();
	}
}

function ago ($timestamp)
{
	// echo "t = ".time();
	//  echo " ts ".$timestamp;
	$difference = time() - $timestamp;
	// echo " diff ".$difference;
	if ($difference < 0) {
		return "0 second ago";
	}
	if ($difference > 100000000) {
		return "long time ago";
	}
	$periods = array ("second",
		"minute",
		"hour",
		"day",
		"week",
		"month",
		"years",
		"decade");
	$lengths = array ("60",
		"60",
		"24",
		"7",
		"4.35",
		"12",
		"10");
	for ($j = 0; $difference >= $lengths[$j]; $j++) {
		$difference /= $lengths[$j];
	}
	$difference = round($difference);
	if ($difference != 1) {
		$periods[$j] .= "s";
	}
	$text = "$difference $periods[$j] ago";

	return $text;
}

//tambahan roy elapse time, mirip ago 23 nov 2015
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getNamaPendek ($name)
{
	$exp = explode(" ", $name);

	return $exp[0];
}

function indonesian_date ($mysqldate)
{
	$time = strtotime($mysqldate);

	return date("d/m/Y H:i ", $time);
}

function leap_mysqldate ()
{
	return date("Y-m-d H:i:s");
}

function leap_mysqldate_isi ($isi)
{
	$time = strtotime($isi);

	return date("Y-m-d H:i:s", $time);
}

function setMaxChar ($text)
{
	$maxChar = 150;

	if (strlen($text) > $maxChar) {
		return substr($text, 0, $maxChar - 1) . '...';
	}

	return $text;
}

///format IDR
function idr($money){
    return number_format( $money, 0 , '' , '.' ) . ',-';
}

function validate_alphanumeric_underscore($str)
{
    return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$str);
}


function idrK($money){

    if($money>999 && $money<=999999){
        $money = $money/1000;
        return $money."K";
    }
    if($money>999999){
        $money = $money/1000000;
        return $money."Mio";
    }
}


/**
 * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
 *
 * @param string $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param string $ending Ending to be appended to the trimmed string.
 * @param boolean $exact If false, $text will not be cut mid-word
 * @param boolean $considerHtml If true, HTML tags would be handled correctly
 *
 * @return string Trimmed string.
 */
function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                    // if tag is a closing tag
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);
//pr($interval);
    return $interval->format($differenceFormat);

}

function getFirstDayOfLastMonth($curMonth,$curYear,$format = "Y-m-d"){
//    $curMonth = 12;
//    $curYear = 2016;

    if ($curMonth == 1)
        $firstDayNextMonth = mktime(0, 0, 0, 1, 1, $curYear-1);
    else
        $firstDayNextMonth = mktime(0, 0, 0, $curMonth-1, 1);

    return date($format,$firstDayNextMonth);
}

function getFirstDayOfNextMonth($curMonth,$curYear,$format = "Y-m-d"){
//    $curMonth = 12;
//    $curYear = 2016;

    if ($curMonth == 12)
        $firstDayNextMonth = mktime(0, 0, 0, 1, 1, $curYear+1);
    else
        $firstDayNextMonth = mktime(0, 0, 0, $curMonth+1, 1);

    return date($format,$firstDayNextMonth);
}

function getFirstDayOfNext4Month($curMonth,$curYear,$format = "Y-m-d"){
//    $curMonth = 12;
//    $curYear = 2016;

    if ($curMonth > 8) {
        $mod = ($curMonth+4)%12;
        $firstDayNextMonth = mktime(0, 0, 0, $mod, 1, $curYear + 1);
    }else
        $firstDayNextMonth = mktime(0, 0, 0, $curMonth+4, 1,$curYear);

    return date($format,$firstDayNextMonth);
}