<?php
/*************************************************
				VERSION 03.09
*************************************************/


// This work by Walden Design is licensed under the Creative Commons Attribution-Share Alike 3.0 
// Unported License. To view a copy of this license please visit:
// http://creativecommons.org/licenses/by-sa/3.0/

// IntraSITE Search  by Walden http://www.waldendesign.com

// Coding and Concept by Aaron Gough http://www.aarongough.com

// This program is distributed in the hope that it will be useful, 
// but WITHOUT ANY WARRANTY; without even the implied warranty of 
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

// If you make any changes / optimizations to this script that you think should be added to the main 
// script please email: aaron@waldendesign.com

// Please note that we are unable to provide technical support for this script if we have provided 
// it for free. Custom work and support can be arranged on a per-hour basis

// This search engine is designed to be easily deployed as a stand-alone search tool for a single 
// domain that requires little setup beyond simply uploading this file and providing a relevant
// form on your website.

// If you call this script you need to provide at least a 'searchterm' parameter. If you call the
// script with no further parameters it will return an XHTML page containing the search results.
// If you call the script with the 'searchterm' parameter and also 'ajax=true' then the script will 
// return an XML document containing the results. This document can quite easily be parsed by the
// Javascript XMLHttpRequest object or any other XML parser...


// ****************************************************************************************************
// ****************************************************************************************************
// Preference Variables:

// CACHE TIME: How often should the site be re-crawled? Set this in seconds.
// If you want to disable the cache system please set this value to 0.
// TIMES: 43200 = 12 hours, 86400 = 24 hours, 604800 = 1 week
// EXAMPLE: $cache_time = 86400;  
$cache_time = 604800;

// DOMAIN NAME: This needs to be the domain name of the site
// EXAMPLE: $this_site = "example.com";
$this_site = "pranav_patil.getasite.co.cc";	

// SEARCH ROOT: Set this to the main index file of your site.	
// EXAMPLE: $search_start = "index.html";						
$search_start = "$DOCUMENT_ROOT/index.php";

// MENU REMOVAL: If your menu structure, header or footer contain a lot of common search keywords
// and you find that it interferes with the process of returning valid search results then you can use 
// this to remove it. Simply set the $remove_ids to the HTML Id of the element(s) that contains your menu  
// structure and the script will ignore that element on each indexed page. If there are multiple 
// elements that you want ignored then you need to enter them all with a space between each id.
// EXAMPLE: $remove_ids = "menu_container left_menu_container header-menu";
$remove_ids = "";

// CSS: Set this to the relative path for the CSS to style any HTML output from this script		
// EXAMPLE: $css_path = "/styles.css";					
$css_path = "";

// EXCLUSIONS: Please list here any directories that should be excluded from the search. 
// Multiple entries should be seperated with spaces. Any dynamic parts of your site should be 
// included in this list otherwise this script may become extremely slow.
// EXAMPLE: $exclusions = "/store /phplist";
$exclusions = "";		


// ****************************************************************************************************
// ****************************************************************************************************
// Init Code:

// Because time spent in system calls, such as file_get_contents(), is not counted toward execution time, 
// if we leave the time limit at the php default the script may continue running for a very long time. 
// If everything is working correctly the script should be able to execute with only 120 seconds or
// less of actual execution time, even on the slowest of servers. Average execution time for a medium sized
// website on a decent server will be less than 8 seconds.
//set_time_limit(120);

// Make sure the PHP internal character encoding is set to ISO-8859-1
mb_internal_encoding( "ISO-8859-1" );

// Set the HTTP output encoding to ISO-8859-1
mb_http_output( "ISO-8859-1" );

// Set the default replacement character for illegal
// characters in conversions to none
ini_set('mbstring.substitute_character', "none");

// Explode the exclusions string into an array
if( strlen($exclusions) > 0 )
	{
	$exclusions = explode(" ", $exclusions );
	}
else
	{
	$exclusions = array();	
	}
	
// explode the remove_ids string into an array
if( strlen($remove_ids) > 0 )
	{
	$remove_ids = explode(" ", $remove_ids );
	}
	
// make sure the $this_site is all in lowercase
$this_site = strtolower( $this_site );

// grab the search term from either POST or GET variables
if( isset($_REQUEST["searchterm"]) && ( $search_term = $_REQUEST["searchterm"] ))
	{
	// un-escape the special characters in the search term
	$search_term = stripslashes( $search_term );
	
	// unless the debug variable is set we need to suppress all errors
	// this is done to ensure the the XML output is valid
	if( $_REQUEST["debug"] == "" ) error_reporting(E_ERROR);
	
	// attempt to retrieve crawl data from the data-cache
	$pages = open_data_cache("intrasite_datacache.txt", $cache_time );
	
	// if the data cache is too old to use, doesn't exist or we are in debug mode 
	// then we need to crawl the site and attempt to save the data in the data-cache
	if( ($pages === false) || ($_REQUEST["debug"] === "true") )
		{
		// crawl the site and store the data in an array
		$pages = crawl_site( $search_start );
		
		// generate text-only, human readable versions of the pages
		$pages = create_text_pages( $pages, $remove_ids );
		
		// save the data to the data-cache
		create_data_cache("intrasite_datacache.txt", $pages );
		}
	
	// compute the relevance of each page we retrieved
	$pages = compute_relevance( $pages, $search_term );
	
	// extract the most relevant text description from each page
	$pages = extract_descriptions( $pages, $search_term );
	
	// highlight any keywords found in the page titles
	$pages = highlight_title_keywords( $pages, $search_term );
	
	// sort the pages by their relevancy scores from highest to lowest
	usort( $pages, "compare_pages" );
	
	// convert the URLs we retrieved to be absolute so the user can browse to the page
	$pages = generate_absolute_urls( $pages, $this_site );
	
	// check to see if the client has requested an XML response
	if( $_REQUEST["ajax"] === "true" )
		{
		// ouput the search results to the client in XML
		echo generate_xml( $pages );
		}
	// else we send the client the search results in HTML
	else
		{
		// output the search results in HTML
		echo generate_html( $pages );
		}
	}


// ****************************************************************************************************
// ****************************************************************************************************
// This function simply opens a local file and returns it's contents as a string for further processing
function get_file_as_string ( $filename )
	{
	// import the global variable $exclusions
	global $exclusions;
		
	// check to make sure we have actually been passed a parameter
	if( $filename == "" ) return "";
		
	// check to make sure that the URL requested is not in an excluded Directory
	if( count($exclusions) > 0 )
		{
		for( $x = 0, $length = count($exclusions); $x < $length; $x++ )
			{
			if( strpos($filename, $exclusions[$x]) != false)
				{
				return "";
				} 
			}
		}
	
	// now grab the file, if we actually receive a string we return it otherwise we return an empty string
	$file = @file_get_contents( $filename );
	if( $file ) 
		{
		// detect the character encoding of the incoming file
		$encoding = mb_detect_encoding( $file, "auto" );
		
		// convert the string to ISO-8859-1
		$file = mb_convert_encoding( $file, "ISO-8859-1", $encoding);
			
		return $file;
		}
	else 
		{
		return "";
		}
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// This function processes a string and returns an array containing all of 
// the URLs it can find by looking for HREF attributes in the source text
// please note that this function is designed only to return URLs that 
// point to documents that should contain (X)HTML ( eg: .html .php .shtml etc... )
function extract_urls ( $text, $pathPrefix)
	{
	// import the global variable $this_site 
	global $this_site;
	
	// check to make sure we have actually been passed some text
	if( !is_string($text) || strlen( $text) === 0 ) return "";
	
	// split the text into 2 arrays bounded by any HREF attributes that are in the string
	$urls = explode("href=\"", $text);
	$urls2 = explode("HREF=\"", $text);
	
	// get rid of the first element of the arrays as it is not needed	
	array_splice( $urls, 0, 1 );
	array_splice( $urls2, 0, 1 );
	
	// merge the 2 arrays
	$urls = array_merge($urls, $urls2);
	
	// define which file extensions we want to accept
	$htmlExtensions = "(\.html|\.htm|\.shtml|\.php|\.asp)$";
	
	// create a blank array to store URLs we deem to be useful
	$tempUrls = array();
	
	// now we go through each array element and remove everything after the first quote ( which marks the end of the relevant HREF attribute )
	for( $x = 0, $length = count( $urls ); $x < $length; $x++)
		{
		// remove everything after the first quote found in the string. This
		// will mark the end of the href attribute
		$urls[$x] = substr($urls[$x], 0 , strpos($urls[$x], "\"" ));
		
		// now check to see if the link points to an anchor, if it does then we need to remove the anchor
		if( strpos($urls[$x], "#" ) )
			{
			$urls[$x] = substr($urls[$x], 0 , strpos($urls[$x], "#" ));
			}
			
		// if we were supplied with a path prefix we need to prepend it to the URL now unless the url is absolute
		if( $pathPrefix )
			{
			if( substr( $urls[$x], 0, 7 ) != "http://" )
				{
				$urls[$x] = $pathPrefix . $urls[$x];
				}
			}
			
		// if the url contains any GET or POST parameters then we need to remove them for now to inspect the URL file extension more easily
		if( strpos($urls[$x], "?" ) )
			{
			$temp = strtolower(substr($urls[$x],0 ,  strpos($urls[$x], "?" )));
			}
		else $temp = strtolower( $urls[$x] );
		
		// now check to make sure that the link points inside the current site
		if( (substr( $temp, 0, 7 ) == "http://") && $this_site && !(strpos( $temp, $this_site )) )
			{
			continue;
			}
			
		// if $this_site is blank then we ignore any absolute URLs just to be on the safe side
		if( (($this_site == "") && substr( $temp, 0, 7 ) == "http://"))
			{
			continue;
			}
			
		// now we test the URL against our list of permissable file extensions
		if( ereg( $htmlExtensions, $temp ) == 0 )
			{
			continue;
			}
		
		// now that we have determined the URL is suitable for harvesting we need to process the URL to be usable:
		// get rid of any backstep operators (..) and reconcile the URL to make up for it's absence
		while( strpos($urls[$x], "..") ) 
			{
			$backstep = strpos($urls[$x], "..");
			$reversed = strrev($urls[$x]);
			$slash = strpos( $reversed, '/',( strlen($urls[$x]) - $backstep) + 3);
			if( $slash === false )
				{
				$slash = 0;
				}
			else
				{
				$slash = strlen( $urls[$x] ) - $slash;
				}
			$urls[$x] = substr_replace( $urls[$x],"", $slash, ($backstep - $slash) + 3 );
			}
			
		// if the url starts with "../" we need to get rid of that
		if( substr($urls[$x], 0, 3) == "../" )
			{
			$urls[$x] = substr( $urls[$x], 3);
			}
		
		// copy the current URL to the $tempUrls array
		$tempUrls[] = $urls[$x];
		}
		
	// make sure that all the URLs are unique
	$tempUrls = array_unique( $tempUrls );
	
	// reset the array indices so that this code will pass the automated testing
	$tempUrls = array_merge( array(), $tempUrls);
	
	// return all the extracted URLs	
	return $tempUrls;
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// This function basically 'crawls' the website.
// the only argument you need to provide to it is a webpage on which to start.
// it returns a 2D array with the following structure:
// Array Element => ( 'url', 'title', 'page_text', 'is_harvested')
function crawl_site( $start_file )	
	{
	// import the global remove_ids variable
	global $crawl_chart, $all_links_found, $retrieval_failed;
	
	// create a blank array to store all the pages we find
	$pages = array();
	
	// add the starting point ( as defined by $start_file ) to the array
	$pages[] = array( 'url' => $start_file, 'page_text' => "", 'is_harvested' => false);
	
	// start a loop to step through the site and harvest links and their corresponding page text, this loop 
	// will be broken from the inside once we are unable to find any new pages
	while( true )
		{
		// to start with we assume that we will find no new links, until proven otherwise
		$new_url = false;
		
		// create a temporary array to store the links found in this iteration
		$harvested_links = array();
		
		// start a loop to search through the $pages array for any links that have not yet been harvested
		for($x = 0, $length = count($pages); $x < $length; $x++)
			{
			// if we find an unharvested link we need to process it
			if( $pages[$x]['is_harvested'] === false )
				{
				// download the relevant URL
				$pages[$x]['page_text'] = get_file_as_string( $pages[$x]['url']);
				
				// now we need to extract the document title so that we can use it when presenting the final info to the user
				preg_match("<title[^\\n]*/title>", $pages[$x]['page_text'], $matches);
				if( isset( $matches[0]))
					{
	      			$pages[$x]['title'] = htmlspecialchars( addslashes( strip_tags( substr($matches[0],6))));
	      			}
      			// if we can't find the title tag then we use the URL as a backup
      			else
      				{
      				$pages[$x]['title'] = $pages[$x]['url'];
      				}
				
				// calculate the path prefix so we can hand it to the extract_urls function
				$path_prefix = strrpos($pages[$x]['url'], "/");
				$path_prefix = substr($pages[$x]['url'], 0, $path_prefix + 1);
				if( (strlen($path_prefix) == 1) && ($path_prefix != "/"))
					{
					$path_prefix = "";
					}
				
				// now extract a list of URLs from the text of the current page
				$temp_urls = extract_urls( $pages[$x]['page_text'], $path_prefix );

				// merge the list with any other URLs we might have found already
				if( is_array($temp_urls) )
					{
					$harvested_links = array_merge( $harvested_links, $temp_urls );
					}
				
				// mark the current URL as harvested
				$pages[$x]['is_harvested'] = true;
				
				// DEBUG: If debug is set to true then we are going to output part of a HTML diagram
				// that will allow the user to see how IntraSITE is crawling their website
				if( isset($_REQUEST['debug']) && ($_REQUEST['debug'] === 'true') )
					{
					// Output the start of the container for the page we just crawled
					$crawl_chart .= "<div class=\"crawl_chart_element\">\n";
					
					// Output the name of the file
					$crawl_chart .= "	<div class=\"crawl_chart_title\"><a href=\"" . $pages[$x]['url'] . "\">" . $pages[$x]['url'] . "</a></div>\n";
					
					// Output the list of links that were extracted from this page
					$crawl_chart .= "	<ul class=\"crawl_chart_links\">\n";
					for( $crawl_links = 0; $crawl_links < count( $temp_urls); $crawl_links++ )
						{
						$crawl_chart .= "		<li class=\"crawl_chart_extracted\"><a href=\"" . $temp_urls[$crawl_links] . "\">" . $temp_urls[$crawl_links] . "</a></li>\n";
						}
					$crawl_chart .= "	</ul>\n\n";
					
					// Output the end of the container for the page we just crawled
					$crawl_chart .= "</div>\n";
					}
				}
			}
		
		// now we need to go through and test each of our newly harvested links against the existing list
		// to see if we already have them, if not we add the link to the list
		for( $x = 0, $length = count($harvested_links); $x < $length; $x++)
			{
			// select a link then iterate through the list of links already harvested
			// if it's not found then is_new remains true
			$is_new = true;
			for( $x2 = 0, $length2 = count( $pages ); $x2 < $length2; $x2++)
				{
				if( $harvested_links[$x] == $pages[$x2]['url'] )
					{
					$is_new = false;
					}
				}
				
			// if the link hasn't been matched against one already in the list then we need to add it
			if( $is_new )
				{
				$pages[] = array( 'url' => $harvested_links[$x], 'page_text' => "" , 'is_harvested' => false );
				$new_url = true;
				
				// DEBUG: If debug is set to true then we add this newly found URL to 
				// the list of all URLs found
				if( isset($_REQUEST['debug']) && ($_REQUEST['debug'] === 'true') )
					{
					$all_links_found[] = $harvested_links[$x];
					}
				}
			}
		
		// if we weren't able to harvest any new URLs then we need to go through and get rid of any that we
		// couldn't obtain the page text for and exit this while loop	
		if( $new_url == false )
			{
			// get rid of any pages that we have no page data for
			for( $x = 0; $x < count($pages); $x++)
				{
				if( $pages[$x]['page_text'] == "" )
					{
					array_splice($pages, $x, 1);
					$x--;
					
					// DEBUG: If debug is set to true then we add the URL to a list
					// of pages that coulsn't be retrieved
					if( isset($_REQUEST['debug']) && ($_REQUEST['debug'] === 'true') )
						{
						$retrieval_failed[] = $pages[$x]['url'];
						}
					}
				}
			
			// break out of the crawl loop
			break;
			}
		}
	
	// return the array containing all the pages we have fetched
	return $pages;
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// This function computes the relevancy of a given search term as compared to a list of pages
// the function accepts arrays as outputted by the crawl_site() function
// the relevancy is represented as an integer, the higher the better.
// this function also sorts the array before returning it so that the most relevant page is first
function compute_relevance ( $pages, $search_term )
	{	
	// convert the search phrase into an array 
	$search_words = explode_searchterm( $search_term );
	
	// iterate through each row in the array and compute the relevancy score for each page
	for( $x = 0, $length = count( $pages); $x < $length ; $x++ )
		{
		// store the text-only version of the page in a local variable
		$temp_text = strtolower($pages[$x]['page_text']);
		
		// initialize all the variables needed for the loop
		$keyword_score = 0;
		$keyword_hits = 0;		
		$total_score = 0;
		$minus_hits = 0;
		
		// compute the relevance score and add it to the array
		for( $x2 = 0, $length2 = count($search_words); $x2 < $length2 ; $x2++)
			{
			//check to see if this keyword has the minus operator preceeding it
			if( substr( $search_words[$x2], 0, 1) == "-" )
				{			
				// check to see if the minus keyword exists in the text
				$tmp = ( count( explode( strtolower( substr($search_words[$x2], 1)) , $temp_text)) - 1 );
				if( $tmp > 0 ) $minus_hits++;
				}
			// otherwise if the keyword is not preceeded with a minus sign then 
			// we treat it normally
			else
				{
				// work out the score for this keyword
				$keyword_score = ( count( explode( strtolower($search_words[$x2]), $temp_text)) - 1 );
				}
			
			// if this keyword exists in the page text then we increment the number of keyword hits
			if( $keyword_score > 0 ) $keyword_hits++;
			
			// accumulate the total score for all the keywords
			$total_score += $keyword_score;
			}
		// check to make sure that all of the keywords were found in the page by making sure that
		// $keyword_hits is equal to the number of keywords in the searach term
		if( ($keyword_hits == count( $search_words)) && $minus_hits === 0 )	
			{
			// if all the keywords exist in the page then we add the total score
			// to the array as the score for the page
			$pages[$x][2] += $total_score;
			}
		else
			{
			// if not all of the keywords were found in the page then we assign the
			// page a relevancy of 0
			$pages[$x][2] = 0;
			}
		}
	
	// remove any pages that have a relevance of 0
	for( $x = 0; $x < count( $pages); $x++ )
		{
		if( $pages[$x][2] == 0 )
			{
			array_splice($pages, $x, 1);
			$x--;
			}
		}
		
	// and return the resulting array
	return $pages;
	}
	
		
// ****************************************************************************************************
// ****************************************************************************************************
// this is a comparison function that is used by compute_relevance() in order to sort the array of 
// pages by their relevancy score
function compare_pages( $a, $b)
	{
	// check to see if the relevance of the two pages is the same
	// if it is then return 0 so that usort knows they should
	// be considered equal
	if( $a[2] == $b[2] )
		{
		return 0;
		}
	// if the relevance of the two pages are not the same then 
	// return -1 if $a is more relevant than $b and vice-versa
	else
		{
		return ($a[2] > $b[2]) ? -1 : 1;
		}
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function is designed to remove blocks of code or a specific HTML tag from a string. By default it
// only removes the code block if it finds both a start and an end tag but it can be set to be aggressive.
// when this option is enabled an open-ended tag will cause the rest of the string to be removed.
// This function should only be used to remove code blocks / tags that do not support nesting
// ie: comment tags, php code blocks, asp code blocks, script tags, etc...
function strip_code_block( $text, $start_tag, $end_tag, $aggressive = false )
	{	
	// check to make sure all essential parameters have been supplied
	if( ( strlen($text) == 0) || ( strlen($start_tag) == 0) || ( strlen($end_tag) == 0) )
		{
		return $text;
		}
	
	// convert the start and end tags to all lowercase
	$start_tag = strtolower( $start_tag );
	$end_tag = strtolower( $end_tag );
	
	// create a copy of the $text string that is all in lowercase
	$temp_text = strtolower( $text );
	
	// look to see if the $start_tag is present in the text
	while( !(strpos( $temp_text, $start_tag ) === false))
		{
		// set $first to the first occurence of the start tag in the text
		$first = strpos( $temp_text, $start_tag );
		
		// set $last to the first occurence of the end tag after the start tag
		$last = strpos( $temp_text, $end_tag, $first);
		
		// if the $aggressive parameter was set to true then if we can't find an end
		// tag for the code block then we remove everything after the start of the 
		// code block
		if( $aggressive === true && $last === false )
			{
			$last = strlen( $text );
			}
			
		// now if we have both have both a start and end position for the code block
		// then we go ahead and remove it from the string
		if( !($first === false ) && !($last === false) )
			{
			// we need to remove the selected code block from both the temp_text and the 
			// text strings to facilitate the rest of the process
			$temp_text = substr_replace( $temp_text, "", $first, ($last - $first) + strlen($end_tag) );
			$text = substr_replace( $text, "", $first, ($last - $first) + strlen($end_tag) );
			}
		}
	
	// now that we have processed the text we return it to the caller
	return $text;
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// This function is designed to remove a HTML element specified by a given ID and all of it's contents.
// This is useful for removing elements on a page that are intefering with returning meaningful search 
// results like menu structures and news boxes.
function remove_element_by_id ( $html, $id )
	{	
	// check to make sure that we have been supplied with both a HTML document and an identifier
	if( strlen( $html) == 0 || strlen( $id) == 0) return $html;
	
	// if we have been supplied with both a HTML document and an identifier
	// then we need to find the start of the element specified by $id
	$id_start = strpos( $html, "=\"$id\"" );
	
	// now find the start of the tag that contains the ID
	$html_rev = strrev( $html);
	$tag_start = ( strlen( $html) - strpos( $html_rev, "<", strlen( $html_rev) - $id_start));
	
	// now extract the name of the tag
	$tag_name_space = strpos( $html, " ", $tag_start);
	$tag_name = substr( $html, $tag_start, $tag_name_space - $tag_start );
	
	// check to see if the tag is self-closing
	$end_of_tag = strpos( $html, ">", $id_start);
	if( substr( $html, $end_of_tag - 1, 1) == "/" )
		{
		// if the tag is self-closing then we simply remove from the opening "<"
		// to the closing "/>"
		$html = substr_replace( $html, "", $tag_start -1, ( $end_of_tag - $tag_start ) + 2);
		}
	// else if the tag is not self-closing then we need to create a loop that looks for a closing tag matching
	// the tag name of the element we are looking to remove, then check if there are any opening tags with
	// the same name in between our opening tag and the current closing tag. If there are then it looks for another
	// subsequent closing tag and checks again if there are an opening tags after the previously found ones.
	// once this process yields the correct closing tag then the whole element and it's contents are removed
	else
		{
		// initialize the variables necessary for the loop
		$new_opening = true;
		$end_tag = $id_start;
		$opening = $id_start;
		
		while( $new_opening )
			{
			// bump the end_tag & opening positions forward by one so the
			// loop doesn't continually find the same tags
			$end_tag++;
			$opening++;
			
			// look for the end tag
			$end_tag = strpos( $html, "/$tag_name>", $end_tag);
			
			// look for the nearest opening tag ( if there is one )
			$opening = strpos( $html, "<$tag_name", $opening);
			
			// if the nearest opening tag that we found was not in between our start and
			// end tag then we can break the loop as we have our entire element
			if( ( $opening > $end_tag ) || $opening === false )
				{
				$new_opening = false;
				}
			}
			
		// remove the element from the HTML
		$html = substr_replace( $html, "", $tag_start - 1, ( $end_tag - $tag_start ) + ( strlen( $tag_name) + 3));
		}
	
	// return the processed HTML
	return $html;
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function outputs the crawl data to the client in a self-defining XML format
function generate_xml ( $pages )
	{
	// output the header content MIME type so the client knows what kind of data to expect
	header("content-type: text/xml; charset='ISO-8859-1'");
	
	// this is the header that will be output before any XML output
	$xml_header = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
	<!DOCTYPE search_results [
	<!ELEMENT search_results (result+, generation_time*)>
  	<!ELEMENT result (url,title,description)>
  	<!ELEMENT url      			(#PCDATA)>
  	<!ELEMENT title   			(#PCDATA)>
  	<!ELEMENT description 		(#PCDATA)>
  	<!ELEMENT generation_time	(#PCDATA)>
	]>
	<search_results>
	";
	
	// this is the footer that will be appended to any XML output
	$xml_footer = "</search_results>\n";
	
	// create a blank string in which to store our generated XML
	$xml = "";
	
	// now output the XML header
	$xml .= $xml_header;
	
	// output an XML record for each search result
	for( $x = 0, $length = count($pages); $x < $length; $x++)
		{	
		$xml .= "<result>\n";
		$xml .= "<url>". htmlspecialchars( html_entity_decode( $pages[$x]['url'] ) ) . "</url>\n";
		$xml .= "<title>" . htmlspecialchars( html_entity_decode( $pages[$x]['title'] ) ) . "</title>\n";
		$xml .= "<description>" . htmlspecialchars( html_entity_decode( $pages[$x]['page_text'] ) ) . "</description>\n";
		$xml .= "</result>\n";
		}
		
	// and finally output the XML footer
	$xml .= $xml_footer;
	
	// return the completed XML
	return $xml;
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function outputs the crawl data to the client in XHTML format
function generate_html ( $pages )
	{
	// Declare the global variables that store the debug info
	global $crawl_chart, $all_links_found, $retrieval_failed;
	
	// output the header content MIME type so the client knows what kind of data to expect
	header("content-type: text/html; charset='ISO-8859-1'");
	
	// this is the XHTML header that will be output before any HTML content
	$xhtml_header = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
	<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
	<head>
	
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />
	
	<style type=\"text/css\">
		.crawl_chart_element{
		background: #efefef;
		float: left;
		display: inline;
		margin: 10px;
		padding: 10px;
		border: 2px solid #aaaaaa;
		font-size: 10px;
		font-family: Arial, sans-serif;
		}
		.crawl_chart_links{
		margin-left: 0;
		padding-left: 10px;
		}
	</style>
	
		<title>Search results for: $search_term</title>";
	if( $css_path ) $xhtml_header .= "<link href=\"$css_path\" rel=\"stylesheet\" type=\"text/css\" />";
	$xhtml_header .= "
	</head>
	<body>\n";
	
	// this is the html footer that will be appended to any HTML output
	$xhtml_footer = "
	</body>
	</html>\n";
	
	// create a blank string in which to store our generated HTML
	$html = "";
	
	// output the XHTML header
	$html .= $xhtml_header;
	
	// Output the debug information (crawl chart, URL list, etc... )
	if( isset($_REQUEST['debug']) && ($_REQUEST['debug'] === 'true') )
		{
		// Output the Crawl chart
		echo "<div style=\"clear:both; margin: 5px 0 5px 0; padding: 0px 5px 0px 25px; background: #efefef;\" /><h3>Crawl chart:</h3></div>\n";
		echo $crawl_chart;
		
		// Ouptput a list of all the links discovered in all pages sitewide
		echo "<div style=\"clear:both; margin: 5px 0 5px 0; padding: 0px 5px 0px 25px; background: #efefef;\" /><h3>Links found sitewide (excluding starting URL):</h3></div>\n";
		echo "<ul>\n";
		for( $x = 0, $length = count( $all_links_found); $x < $length; $x++ )
			{
			echo "	<li><a href=\"" . $all_links_found[$x] . "\">" . $all_links_found[$x] . "</a></li>\n";
			}
		echo "</ul>\n";
		
		// Ouptput a list of all the links that were unable to be retrieved (if any exist)
		if( count($retrieval_failed) > 0 )
			{
			echo "<div style=\"clear:both; margin: 5px 0 5px 0; padding: 0px 5px 0px 25px; background: #efefef;\" /><h3>Pages that were unable to be retrieved:</h3></div>\n";
			echo "<ul>\n";
			for( $x = 0, $length = count( $retrieval_failed); $x < $length; $x++ )
				{
				echo "	<li><a href=\"" . $retrieval_failed[$x] . "\">" . $retrieval_failed[$x] . "</a></li>\n";
				}
			echo "</ul>\n";
			}
		
		// Output the heading for the search results
		echo "<div style=\"clear:both; margin: 5px 0 5px 0; padding: 0px 5px 0px 25px; background: #efefef;\" /><h3>Search results for keyphrase - " . htmlentities($_REQUEST['searchterm'] ) . "</h3></div>\n";
		}
	
	// output the search results
	for( $x = 0, $length = count($pages); $x < $length; $x++)
		{
		// output the container for an individual search result
		$html .= "	<div class=\"search_result\">\n";
		
		// output the title of the page as a link to the page in question
		$html .= "		<a class=\"result_title\" href=\"" . $pages[$x]['url'] . "\">" . $pages[$x]['title'] . "</a>\n";
		
		// output a short description
		$html .= "		<div class=\"result_description\">\n";
		$html .= $pages[$x]['page_text'] . "\n";
		$html .= "		</div>\n";
		
		// output the closing tags for the result container
		$html .= "	</div>\n";
		}
	
	// output the XHTML footer
	$html .= $xhtml_footer;
	
	// return the generated HTML
	return $html;	
	}


// ****************************************************************************************************
// ****************************************************************************************************
// this function generates an absolute URL for each page so that the client can browse to the page
function generate_absolute_urls ( $pages, $this_site)
	{
	// setup a loop to step through all the pages in the array
	for( $x = 0, $length = count($pages); $x < $length; $x++)
		{
		// check to make sure that the URL is not already absolute
		if( substr( $pages[$x]['url'], 0 , 7 ) != "http://" )
			{
			// check to see if the link already starts with a forward slash
			if( substr( $pages[$x]['url'], 0, 1) === "/")
				{
				// generate the absolute URL by combining the path with the site domain name
				$pages[$x]['url'] = "http://$this_site" . $pages[$x]['url'];
				}
			else
				{
				// generate the absolute URL by combining the path with the site domain name
				$pages[$x]['url'] = "http://$this_site/" . $pages[$x]['url'];
				}			
			}
		}
		
	// return the array to the calling code
	return $pages;
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function saves the current crawl data to the data cache and marks it with the current UNIX timestamp
function create_data_cache ( $filename,  $data )
	{
	// create the data cache file
	$data_cache_file = fopen($filename, 'w');
	
	// generate the string that contains all the data that needs to go into the cache file
	$data_cache = time() . "[datacache_start]" . serialize( $data );
	
	// write the data cache to the cache file
	fwrite( $data_cache_file, $data_cache );	
	
	// change the permissions of the data cache file so that the public cannot view it
	// otherwise we run the risk of exposing our server-side code to the masses! uh-oh!
	// Please note: this is only an extra precaution and we do not rely on this to secure
	// the server-side code. Other parts of the script have been modified to remove the server
	// side code before it is ever written to the cache.
	chmod( $filename, 0600);
		
	// close the data cache file
	fclose( $data_cache_file );
	
	// if the cache was able to be created then we return true
	if( file_exists( $filename ))
		{
		return true;
		}
	// if there was an error creating the cache then we return boolean false
	else
		{
		return false;
		}
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function looks for the data-cache file. If the file is older then the specified cache-time
// or doesn't exist then it returns boolean false
function open_data_cache ( $filename, $cache_time )
	{
	// check to see if the data-cache file actually exists
	if( file_exists( $filename ))
		{
		// open the data cache file
		$data_cache_file = fopen( $filename, "r");
		
		// read all of the data from the data cache
		$data_cache = fread( $data_cache_file, filesize($filename));
		
		// close the data cache file
		fclose( $data_cache_file );
		
		// extract the data cache timestamp
		$data_timestamp = strpos( $data_cache, "[datacache_start]");
		$data_timestamp = substr( $data_cache, 0, $data_timestamp );
		
		// convert the textual timestamp into an integer for comparison with the current timestamp
		$data_timestamp = intval( $data_timestamp );
		
		// check to see if the data cache is older than cache_time specifies
		if( (time() - $data_timestamp) > $cache_time )
			{
			// because the data-cache is too old to use we need to return false
			// to the calling code
			return false;
			}
		// if the data cache is recent enough that we can use it then we need to load it into RAM as an array
		else
			{
			// find the start of the data within the cache file
			$data_start = ( strpos( $data_cache, "[datacache_start]") + strlen("[datacache_start]"));
			
			// separate the data from the timestamp and data separator
			$data_cache = substr( $data_cache, $data_start );
			
			// unserialize the data into the $data variable
			$data = unserialize( $data_cache );
			
			// return the array to the calling code
			return $data;
			}
		}
	// if the data cache file does not already exist then we need return boolean false
	else
		{
		return false;
		}
	}
	
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function iterates through the pages array and create a text only, human readable version of the HTML
function create_text_pages( $pages, $remove_ids )
	{
	// iterate through each row in the array and compute the relevancy score for each page
	for( $x = 0, $length = count( $pages); $x < $length ; $x++ )
		{
		// Strip all PHP code blocks from the page
		$pages[$x]['page_text'] = strip_code_block( $pages[$x]['page_text'], "<?", "?>", true );
		
		// strip all ASP code blocks from the page
		$pages[$x]['page_text'] = strip_code_block( $pages[$x]['page_text'], "<%", "%>", true );
		
		// strip all comments out of the HTML, this removes any inline javascript or CSS
		$pages[$x]['page_text'] = strip_code_block( $pages[$x]['page_text'], "<!--", "-->" );
		
		// strip out all <script> tags
		$pages[$x]['page_text'] = strip_code_block( $pages[$x]['page_text'], "<script", "</script>" );
		
		// now we need to remove any elements that have an ID that matches the ones provided
		if( count( $remove_ids) > 0 )
			{
			for( $id_no = 0; $id_no < count( $remove_ids); $id_no++ )
				{
				$pages[$x]['page_text'] = remove_element_by_id( $pages[$x]['page_text'], $remove_ids[$id_no]);
				}
			}
		
		// strip out all the content before the body tag
		$start = strpos($pages[$x]['page_text'] ,"<body>");
		if( $start )
			{
			$temp_text = substr($pages[$x]['page_text'], $start);
			}
		else
			{
			$temp_text = $pages[$x]['page_text'];
			}
			
		// strip out all the HTML tags
		$temp_text = strip_tags( $temp_text );
		
		// now strip out any excess whitespace ( more than 1 space in a row, everything else is left untouched )
		$temp_text = preg_replace('/\s\s+/', ' ', $temp_text);
		
		// decode HTML entities
		$temp_text = html_entity_decode( $temp_text );
		
		// add our new human-readble version of the document string to the array as it will be useful later
		$pages[$x]['page_text'] = $temp_text;
		}
	
	// return the array with the new text-only pages included
	return $pages;
	}
	

// ****************************************************************************************************
// ****************************************************************************************************
// this function extracts the most relevant description text possible from the array of pages
// it looks for the first instance of the first keyword in the page text and then extracts the 400 character 
// description from the start of the sentence that contains that first word.
function extract_descriptions( $pages, $search_term )
	{
	// convert the search phrase into an array
	$search_words = explode_searchterm( $search_term );
	$search_word = strtolower( $search_words[0] );
	
	// iterate through each row in the array and extract the description from it's text
	for( $x = 0, $length = count( $pages); $x < $length ; $x++ )
		{
		// store the text-only version of the page in a local variable
		$temp_text = $pages[$x]['page_text'];
					
		// now we need to trim the page text to 400 characters that surround the first instance of the first search word
		$first = strpos( strtolower( $temp_text), $search_word);
		$sentence = ( strlen( $temp_text) - ( strpos( strrev($temp_text), ".", strlen( $temp_text) - $first)));
		
		// check to see if the sentence finding routine above actually found the end of a previous sentence
		// if it didn't then we just extract 400 characters from the first instance of the keyword
		if( $sentence > $first )
			{
			$sentence = $first;
			}
			
		// get the description of the page by extracting a section of it based on the routine
		// above for finding the first sentence that surrounds the first instance of the keyword(s)
		$pages[$x]['page_text'] = htmlspecialchars( trim( substr( $temp_text, $sentence, 400 )));
		
		// chop the string so that it ends on whitespace
		$pages[$x]['page_text'] = substr( $pages[$x]['page_text'], 0, strrpos( $pages[$x]['page_text'], " "));
		
		// If the original string continue past the sub-string we extracted then we
		// append an ellipsis to the string so they realize there is more content.
		if( !(($sentence + strlen($pages[$x]['page_text'])) > strlen( $temp_text)))
			{
			$pages[$x]['page_text'] .= "...";
			}
			
		// now strip out any excess whitespace ( more than 1 space in a row, everything else is left untouched )
		$pages[$x]['page_text'] = preg_replace('/\s\s+/', ' ', $pages[$x]['page_text']);
			
		// now add the <strong> tags needed to highlight the keywords in the description
		for( $y = 0; $y < count( $search_words); $y++)	
			{
			$pages[$x]['page_text'] = highlight_keyword( $pages[$x]['page_text'], $search_words[$y] );
			}
		}
		
	// return the array with it's new description text
	return $pages;
	}
	
// ****************************************************************************************************
// ****************************************************************************************************
// this function takes a given string and surrounds any instances of the supplied keyword with <strong> 
// tags to make the keyword more visible to the user
function highlight_keyword( $text, $keyword )
	{
	// check to make sure that the keyword is not null
	if( $keyword == "")	
		{
		return $text;
		}
		
	// convert the keyword and subject text to lower case
	// so that the keyword search can be performed case insensitively
	$keyword = strtolower( $keyword );
	$lower = strtolower( $text );
		
	// setup a loop to find all instances of the keyword in the subject text
	$x = 0;
	while( true )
		{
		// look for the keyword in the text
		$x = strpos( $lower, $keyword, $x);
		
		// check to see if the keyword was found
		if( !( $x === false ))
			{
			// insert the start of the <strong> tag into both the real
			// text and the lowercase version so that their length will still match
			$text = substr_replace( $text, "<strong>", $x, 0);
			$lower = substr_replace( $lower, "<strong>", $x, 0);
			
			// insert the end of the strong tag into both strings
			$text = substr_replace( $text, "</strong>", ( $x + strlen($keyword) + 8), 0 );
			$lower = substr_replace( $lower, "</strong>", ( $x + strlen($keyword) + 8), 0 );
			
			// move the string position marker to the end of the strong tag
			$x =  ( $x + strlen($keyword) + 7);
			}
		// if the keyword was not found then we need to break out of
		// the while loop
		else
			{
			break;
			}
		}
	
	// return the processed text
	return $text;
	}
	

// ****************************************************************************************************
// ****************************************************************************************************
// this function loops through the array containing all of the page information and highlights any instances
// of the search keywords it finds in the title text for each page
function highlight_title_keywords ( $pages, $searchterm )
	{
	// convert the search phrase into an array
	$search_words = explode_searchterm( $searchterm );
		
	// setup the loop to iterate therought the array
	for( $x = 0; $x < count($pages); $x++ )
		{
		// setup a loop to iterate through all the keywords
		for( $y = 0; $y < count( $search_words); $y++ )
			{
			// highlight any keywords we find
			$pages[$x]['title'] = highlight_keyword( $pages[$x]['title'], $search_words[$y]);
			}
		}
		
	// return the processed array
	return $pages;
	}
	

// ****************************************************************************************************
// ****************************************************************************************************
// this function serves to turn the supplied search phrase into an array that is delimited by spaces
// in the absence of any quote marks. If there are quotes surrounding any section of the search phrase
// then that section is given an array element of it's own as it must be searched for verbatim
function explode_searchterm( $search_term )
	{
	// first check to make sure we were actually passed a valid string
	if( !is_string( $search_term ) || $search_term == "" ) return array ();
	
	// check to see if the search phrase contains any double or single quotes
	if( !(strpos( $search_term, "'") === false) || !(strpos( $search_term, '"') === false) )
		{
		// if the search phrase does contain either double or single quotes then we need to
		// extract those sections as verbatim and put them in their own array element.
		// the remainder of the text, if any, can be treated in the normal manner
		
		// create a blank array to contain the extracted keywords
		$search_words = array ();
		
		// look for single quotes
		while( !(strpos( $search_term, "'") === false) )
			{
			// mark the start of the quoted section
			$start = strpos( $search_term, "'");
			if( $start < 0 ) $start = 0;
			
			// mark the end of the quoted section
			$end = strpos( $search_term, "'", $start + 2);
			
			// if the end of the quoted section is not found then we assume the
			// rest of the string should be quoted
			if( $end === false ) 
				{				
				// extract the quoted section, add it to the search_words array
				// and then delete that section from the $search_term string
				$search_words[] = substr( $search_term, $start + 1);
				
				$start = $start - 1;
				if( $start < 0 ) $start = 0;
				$search_term = substr_replace( $search_term, "", $start);
				}
			else
				{
				// extract the quoted section, add it to the search_words array
				// and then delete that section from the $search_term string
				$search_words[] = substr( $search_term, $start + 1, $end - ( $start + 1 ));
				
				$start = $start - 1;
				if( $start < 0 ) $start = 0;
				$search_term = substr_replace( $search_term, "", $start, $end - $start + 1);
				}
			}
			
		// look for double quotes
		while( !(strpos( $search_term, '"') === false) )
			{
			// mark the start of the quoted section
			$start = strpos( $search_term, '"');
			if( $start < 0 ) $start = 0;
			
			// mark the end of the quoted section
			$end = strpos( $search_term, '"', $start + 2);
			
			// if the end of the quoted section is not found then we assume the
			// rest of the string should be quoted
			if( $end === false ) 
				{				
				// extract the quoted section, add it to the search_words array
				// and then delete that section from the $search_term string
				$search_words[] = substr( $search_term, $start + 1);
				
				$start = $start - 1;
				if( $start < 0 ) $start = 0;
				$search_term = substr_replace( $search_term, "", $start);
				}
			else
				{
				// extract the quoted section, add it to the search_words array
				// and then delete that section from the $search_term string
				$search_words[] = substr( $search_term, $start + 1, $end - ( $start + 1 ));
				
				$start = $start - 1;
				if( $start < 0 ) $start = 0;
				$search_term = substr_replace( $search_term, "", $start, $end - $start + 1);
				}
			}
			
		// any remaining words that are not surrounded by quotes we treat in the normal
		// way, then we merge the resulting array with the array we just generated
		if( strlen( $search_term ))
			{
			$tmp = explode( " ", $search_term )	;
			// loop through the array parts and add any that aren't empty to the $search_words
			for( $x = 0; $x < count( $tmp); $x++)
				{
				if( $tmp[$x] != "" ) $search_words[] = $tmp[$x];
				}
			}
		
		// return the generated array
		return $search_words;
		}
	else
		{
		// seeing as the search phrase has no double or single quotes in it
		// we can simply use PHPs built in explode function to turn it into an array
		return explode( " ", $search_term);
		}
	}
	
	
// CHANGELOG:
// November 06 2008:
// --Changed get_file_as_string so that it converts fetched file into PHP's default character encoding
// (ISO-8859-1) and removes the question marks "?" created by any unsupported characters in the process
// --Changed extract_descriptions so that it always terminates the description on the last occurring space
// this prevents edge cases where it was cutting a HTML character entity in half and therefore producing an
// invalid character.

// November 03 2008:
// --Changed all functions that deal with the $pages array to use the standard variable name $pages
// --Changed all fucntions that deal with the $pages array to use an associative array layout

// October 17 2008:
// --Re-formatted some comments to make the code more legible
// --Changed debug mode to force the site to be re-crawled
// --Added crawl-chart generation routines to crawl_site
// --Added code for outputting debug information to generate_html
// --Removed file_exists check from get_file_as_string as it
// was causing the script to refuse to fetch the contents of any absolute URL
// --Added routine to output a list of all pages crawled as part of the debug info
// --Added routine to output a list of all the pages unable to be retrieved as part of the debug info
// --Added some variable existence checking to crawl_site to stop it from throwing warnings
// during automated testing

// July 22 2008:
// --Added support for negative keywords to compute_relevance ( use by preceeding a keyword with the minus "-" sign )
// --fixed bug where compute relevance was not seeing keywords in the title tag
// --fixed bug in explode_searchterm that was causing it to return arrays with blank elements in fringe cases

// July 21 2008:
// --Added function highlight_title_keywords to add emphasis to keywords in the page title via HTML
// --added explode_searchterm function and modified rest of script to use it

// July 18 2008:
// --Changed method of highlighting keywords in descriptions so that the keywords retain their original formatting

// July 15 2008:
// --Created function extract_descriptions from routines originally contained in compute_relevance
// --Created function create_text_pages from routines originally contained in compute_relevance
// --Changed method of computing relevance so that if multiple words are entered all of the words have to 
// be present in a page in order for it to be deemed relevant at all
// --Added functionality to compute_relevance that allows only exact matches when the user enters
// a keyword surrounded by double quotes
// --Added functionality to extract_descriptions to highlight all the search keywords in the description

// July 9 2008:
// --Changed default script timeout to 30 seconds

// July 7 2008:
// --Fixed bug where generate_absolute_urls was being assigned to $page instead of $pages
// --Changed generate_absolute_urls to correctly deal with a URL that already has a leading forward slash

// June 27 2008:
// --Changed data-caching system to make it more re-usable in other projects
// --Changed generate_xml & generate_html functions to allow them to be automatically tested
// --Fixed bug in strip_code_block where it wasn't properly removing the whole end tag
// --Fixed bug in strip_code_block where an empty start_tag or end_tag triggered a PHP warning

// June 26 2008:
// --Changed code to be vastly more atomic to facilitate automated unit tests and easier maintenence
// --Removed output buffering as it actually slowed down the script
// --Removed all debug outputs from the script, similar functionality will be implemented in the automated testing suite

// June 25 2008:
// --Added strip_code_block function which allows unwanted blocks of server-side or client-side code
// to be removed from the page data
// --Did some code clean-up and added some new comments

// June 18 2008:
// --Fixed bug in CRAWL_SITE where array_unique was destroying a lot of the collected data
// --Added output buffering when the user isn't requesting debug info
// --Removed the backup search system as it was unlikely ever to be used and was cluttering up the code
// --Added data caching system to the search engine, defualt cache time is 24 hours

// June 17 2008:
// --Fixed bug where backstep operators were not being resolved correctly

// May 26 2008:
// --Fixed method of extracting description text, sometimes it was returning a blank string
// --Fixed bug where php was reporting errors if $css_path or $exclusions variables were empty

// Apr 02 2008:
// --Added capability to block a given directory or multiple directories from being indexed
// --Made preference variables easier to understand
// --Added extra debug info outputs
// --Moved change-log to end of file

// Mar 20 2008:
// --Fixed issue where XML was being output in wrong character encoding ( should have been UTF-8 )
// --Improved handling of HTML enitities that were already in the source documents
// --Improved stripping of javascript code from descriptions, also the script now strips all HTML comments out of the descriptions

// Mar 19 2008:
// --Fixed issue where some characters should have been converted to HTML entities but weren't and were breaking the XML output

// Jan 25 2008:
// --Added backup search capability, working very nicely!
// --Consolidated the generation of absolute URLs to one loop and added detection of when a URL is already absolute

// Jan 17 2008:
// --Altered output section of script so it returns absolute URLs
// --Documented compute_relevance function
// --Documented crawl_site function
// --Re-encodes HTML entities before returning to the client
// --First full working alpha version complete
// --Performance optimizations - average execution time down to 0.15 secs on shared server ( .08 sec average improvement )

// Jan 11 2008:
// --Crawl_site function working
// --Compute_relevance function working nicely

// Jan 10 2008:
// --Get_file_as_string & extract_urls now working.
// --Added support for backstep operator (..) to extract_urls

// Jan 03 2008:
// --Initial work on extract_urls function & get_file_as_string
	
?>