<?php 

$xml_file = "tracklist.xml"; 

$xml_title_key = "*TRACKLIST*TRACK*TITLE"; 
$xml_artist_key = "*TRACKLIST*TRACK*ARTIST"; 
$xml_album_key = "*TRACKLIST*TRACK*ALBUM"; 
$xml_year_key = "*TRACKLIST*TRACK*YEAR"; 
$xml_rating_key = "*TRACKLIST*TRACK*RATING"; 
$xml_ylink_key = "*TRACKLIST*TRACK*YLINK"; 

$track_array = array(); 

$counter = 0; 
class xml_track{ 
    var $title, $artist, $album, $year, $rating, $ylink; 
} 

function startTag($parser, $data){ 
    global $current_tag; 
    $current_tag .= "*$data"; 
} 

function endTag($parser, $data){ 
    global $current_tag; 
    $tag_key = strrpos($current_tag, '*'); 
    $current_tag = substr($current_tag, 0, $tag_key); 
} 

function contents($parser, $data){ 
    global $current_tag, $xml_title_key, $xml_artist_key, $xml_album_key;
    global $xml_year_key, $xml_rating_key, $xml_ylink_key,  $counter, $track_array; 
	
    switch($current_tag){ 
        case $xml_title_key: 
            $track_array[$counter] = new xml_track(); 
            $track_array[$counter]->title = $data; 
            break; 
        case $xml_artist_key: 
            $track_array[$counter]->artist = $data; 
            break; 
        case $xml_album_key: 
            $track_array[$counter]->album = $data; 
            break; 
        case $xml_year_key: 
            $track_array[$counter]->year = $data; 
            break; 
        case $xml_rating_key: 
            $track_array[$counter]->rating = $data; 
            break; 
        case $xml_ylink_key: 
            $track_array[$counter]->ylink = $data; 
            $counter++; 
            break; 
    } 
} 

$xml_parser = xml_parser_create(); 

xml_set_element_handler($xml_parser, "startTag", "endTag"); 

xml_set_character_data_handler($xml_parser, "contents"); 

$fp = fopen($xml_file, "r") or die("Could not open file"); 

$data = fread($fp, filesize($xml_file)) or die("Could not read file"); 

if(!(xml_parse($xml_parser, $data, feof($fp)))){ 
    die("Error on line " . xml_get_current_line_number($xml_parser)); 
} 

xml_parser_free($xml_parser); 

fclose($fp); 

?> 