/*************************************************
				VERSION 03.09
*************************************************/


// PREFERENCE VARIABLES:
// Set this to the relative path to the intrasite_search.php file:
intrasitePath = "intrasite_search.php";

// Set this to the ID of the submit button that is attached to your search box
submitButton = "search_submit";

// Set this to the ID of your search box ( must be an input element of type "text" )
searchBox = "search_box";


// *************************************************
// *************************************************
// this object implements an AJAX system that is linked to a server-side PHP script
// that does the actual indexing
// searchPath: the path to the Walden Search PHP file
// submitButton: the ID of the button / element that you want to be clicked to perform a search
// textField: the textfield form control that will contain the term to be searched for
function AJAXSearch ( searchPath, submitButton, textField )
	{
	// *************************************************
	// this function sets up the XMLHttpRequest object and sends off the search query
	this.executeSearch = function ( )
		{
		// first we need to retrieve the search phrase from the textField that was supplied 
		// upon initializing this object
		if( thisObj.textField )
			{
			thisObj.searchTerm = thisObj.textField.value;
			// now add a CSS rule to allow a loading swizzy to be displayed
			thisObj.textField.className = thisObj.textFieldClass + " busy";
			// look for an ajaxsearch_container div made by a previous search and if found delete it.
			if( document.getElementById("ajaxsearch_container") )
				{
				oldSearch = document.getElementById("ajaxsearch_container");
				oldSearch.parentNode.removeChild( oldSearch );
				}
			// now into the nitty gritty of performing the search, first we need to setup an XMLHttpRequest object
			// create the XMLHttp object for browsers other than IE
			if( window.XMLHttpRequest )
				{
				thisObj.xmlhttp = new XMLHttpRequest();
				}
			// code for IE
			else if ( window.ActiveXObject )
				{
				thisObj.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
			
			// now if we have a valid XMLHttp object we send the request.
			if( thisObj.xmlhttp != null )
				{
				thisObj.xmlhttp.onreadystatechange = thisObj.displayResults;
				thisObj.xmlhttp.open( "GET", thisObj.searchPath + "?searchterm=" + thisObj.searchTerm + "&ajax=true" , true );
				thisObj.xmlhttp.send( null );
				}
			// otherwise tell the user that their browser is crap
			else
				{
				alert( "Sorry your browser does not support some functionality necessary for this search engine to work, please upgrade your browser to a newer version");
				}
			// return false to override the default action of the button that this function has been assigned to 
			// as an event handler
			return( false );
			}
		}
		
	// *************************************************	
	// this function is called once the XMLHttpRequest object receives a response from the server
	// it is responsible for presenting the searach results to the user
	this.displayResults = function ()
		{
		// check if the XMLHttpRequest has been successful
		if( thisObj.xmlhttp.readyState == 4 )
			{
			if( thisObj.xmlhttp.status == 200 )
				{
				// if the results have been retrieved then remove the loading swizzy from the textField
				thisObj.textField.className = thisObj.textFieldClass;
				// grab all the result records from the returned XML document
				var results = thisObj.xmlhttp.responseXML.getElementsByTagName("result");
				// now create the various containers to display the results
				// first we need to add all of the required divs with their associated classes so that the results are nicely styleable
				var resultsContainer = document.createElement("div");
				resultsContainer.id = "ajaxsearch_container";
				resultsContainer.className = "ajaxsearch_container";
		
				var resultsHeader = document.createElement( "div");
				resultsHeader.className = "ajaxsearch_results_header";
				resultsContainer.appendChild( resultsHeader );
		
				var resultTerm = document.createElement("div");
				resultTerm.className = "ajaxsearch_searchtext";
				resultTerm.appendChild( document.createTextNode( "Search for: " + thisObj.searchTerm.substr(0, 50) ));
				resultsHeader.appendChild( resultTerm );
		
				var numberResults = document.createElement("div");
				numberResults.className = "ajaxsearch_number_results";
				numberResults.appendChild( document.createTextNode( results.length + " results found." ));
				resultsHeader.appendChild( numberResults );
		
				// here we will add a close button to remove the results div. there is no image associated  
				// with this, it needs to be added via a css background image
				var closeButton = document.createElement("div");
				closeButton.className = "ajaxsearch_close_button";
				closeButton.onclick = function ()
					{
					var container = document.getElementById("ajaxsearch_container");
					container.parentNode.removeChild( container );
					}
				resultsHeader.appendChild( closeButton );
		
				var resultsBox = document.createElement("div");
				resultsBox.className = "ajaxsearch_results";
				resultsContainer.appendChild( resultsBox );
				
				// now we will add the actual results in one-by-one. each row is assigned an alternating 
				// class of 'odd' or 'even' so that they can be styled to make the list more easily readable
				var odd = false;
				for( x = 0, arrayLength = results.length; x < arrayLength; x++)
					{
					// create the div for the element
					tempDiv = document.createElement("div");
					// assign it a class of odd or even
					if( !odd )
						{
						tempDiv.className = "ajaxsearch_result_element even";
						}
					else
						{
						tempDiv.className = "ajaxsearch_result_element odd";	
						}
					odd = !odd;
					
					//check to see if the entry should be highlighted
					if( results[x].getAttribute("class") == "highlight" )
						{
						tempDiv.className += " highlight";	
						}
			
					// now create the link for the top of the entry
					tempLink = document.createElement("a");
					tempLink.className = "ajaxsearch_result_title";
					tempLink.href = results[x].getElementsByTagName("url")[0].firstChild.nodeValue;
					tempSpan = document.createElement("span");
					tempSpan.innerHTML = results[x].getElementsByTagName("title")[0].firstChild.nodeValue;
					tempLink.appendChild( tempSpan );
					tempDiv.appendChild( tempLink );
			
					// add the description
					if (results[x].getElementsByTagName("description")[0].firstChild)
						{
						var description = document.createElement("div");
						description.innerHTML = results[x].getElementsByTagName("description")[0].firstChild.nodeValue
						tempDiv.appendChild( description );
						}
		
					// now we add the entry to the list of results
					resultsBox.appendChild( tempDiv );
					}
					
				// here we add an endorsement box for the IntraSITE search engine. Just a little image that reads
				// "Powered by IntraSITE Search"
				tempLink = document.createElement( "a" );
				tempLink.href = "http://www.intrasitesearch.com";
				tempLink.id = "intrasite_powered";
				tempImg = document.createElement( "img" );
				tempImg.src = "http://www.waldendesign.com/images/powered_by_intrasite.jpg";
				tempLink.appendChild( tempImg );
				resultsContainer.appendChild( tempLink );
				
				// finally we display the results!
				thisObj.textField.parentNode.appendChild( resultsContainer );
				}
			}
		}
		
	// *************************************************
	// now all the the initialization necessary for proper operation of the object
	
	// store a static reference to THIS to allow its use in closures later
	var thisObj = this;
	// create a null variable that will be used later for the XMLHTTPRequest object later
	this.xmlhttp = null
	// store the searcPath variable in a local object property
	this.searchPath = searchPath;
	// if we have been supplied a string for the submit button instead of an object then
	// get a reference to the relevant object
	if( typeof( submitButton ) == "string" )
		{
		submitButton = document.getElementById( submitButton );	
		}
	if( typeof( submitButton ) == "object" )
		{
		this.submitButton = submitButton;
		}
	// if we have been supplied a string for the text field instead of an object then
	// get a reference to the relevant object
	if( typeof( textField ) == "string" )
		{
		textField = document.getElementById( textField );	
		}
	if( typeof( textField ) == "object" )
		{
		this.textField = textField;
		}	
	// attach the necessary event handlers
	if( this.submitButton )
		{
		this.submitButton.onclick = this.executeSearch;
		}
	this.textField.onsubmit = this.executeSearch;
	// add an event handler to make sure that pressing enter in the searchbox will perform a search
	this.textField.onkeydown = function (e)
		{
		if (!e) 
			{
			e = window.event;
			}
		if( e.keyCode == 13 )
			{
			this.onsubmit();
			return false;
			}
		}
	// store the class attributes of the textField so that we can add / remove a loading swizzy via CSS
	this.textFieldClass = textField.className;
	// add the text 'Search' to the textField
	this.textField.value = "Search";
	// add event handler to automatically get rid of the default text from the search box when it gets the focus
	this.textField.onfocus = function ()
		{
		if( this.value == "Search" )
			{
			this.value = "";	
			}
		}
	// add an event handler to replace the "Search" text if the searchbox is blank when it loses focus
	this.textField.onblur = function ()
		{
		if( this.value == "" )
			{
			this.value = "Search";	
			}
		}	
	}
	
function IntraSITE_search_init ()
	{
	testSearch = new AJAXSearch ( intrasitePath, submitButton, searchBox);	
	}
	
// check to see whether another script has already assigned an event
// to winodw.onload
if( window.onload )
	{
	// if there is already an event registered to window.onload then we need
	// to store a copy of it and call it after we launch our own init function
	var oldOnLoad = window.onload;
	window.onload = function ()
		{
		IntraSITE_search_init();
		oldOnLoad();
		}
	}
// if there are no events already registered then we simply register
// our init function and relax!
else
	{
	window.onload = IntraSITE_search_init;	
	}