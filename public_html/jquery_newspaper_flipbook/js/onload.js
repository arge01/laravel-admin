(function($){

////CONFIGURATION
var WIDTH_BOOK           			//WIDTH BOOK
var HEIGHT_BOOK						//HEIGHT BOOK
var BOOK_SLUG;						//SLUG FOR BOOK
var WINDOW_WIDTH;                   //WIDTH AREA [px]
var WINDOW_HEIGHT;                  //HEIGHT AREA [px]
var ZOOM_STEP 		        		//STEPS SIZE FOR ZOOM
var ZOOM_DOUBLE_CLICK_ENABLED;		//ENABLED DOUBLE CLICK FOR ZOOM
var ZOOM_DOUBLE_CLICK;    			//ZOOM FOR DOUBLE CLICK
var GOTOPAGE_WIDTH;					//WIDTH FOR INPUT FIELD
var IS_AS_TEMPLATE               	//IF THIS TEMPLATE 
var TOOL_TIP_VISIBLE                //TOOLTIP VISIBLE
var SWF_ADDRESS                     //SWF ADDRESS
var TOOLS_VISIBLE                   //TOOLBAR VISIBLE
var RTL                             //RIGHT TO LEFT
var rendered
var pdfDoc
var CONFIG
var DISPLAY
var PAGE_MODE




/* =  event ready 
--------------------------*/
$(document).ready(function(e) {	

    
				///redirect from load_book_lightbox ( change attributes href to onClick )
				$('a[href]').each(function(index, element) {
						var el=$(element);
						var href=el.attr('href');						
						if ( href.indexOf("load_book_lightbox") >= 0 ) {
							   el.attr('onClick',href);
							   el.removeAttr('href');
							   el.css('cursor','pointer');			   
						}
				});
 	 
        
			
				if(  $('#fb5-ajax').attr('data-cat')  == undefined ){ ///as lightbox	
				   
					Ajax_v5.start_book_lightbox();
					
				}else{ //as shortcodes
					
					if( $('#fb5-ajax').hasClass('fb5-fullbrowser')  ){
						$("#fb5-ajax").detach().appendTo('body')
					}
					
					Ajax_v5.start_book_shortcode();
					
					
				}

	
	
				if( general.browser_firefox() ) {
					console.log('book:version jquery = '+$.fn.jquery);	
				}
});


/* =  Ajax load 
--------------------------*/
var Ajax_v5 = {

     all_books_slug:"",	 
	 
	 speed_bcg:function(books_){
		 
	
		 
		    if( $('#fb5-ajax').attr('data-template') == "true"){				
				Ajax_v5.init_from_shortcode( $('#fb5-ajax').attr('data-cat')  );									
				return;					
			}
			
			/*
		    var _cur_book=Ajax_v5.auto_select_book( books_  );				
			var width=fb5_books[_cur_book].w//data_bcg[0]
			var height=fb5_books[_cur_book].h//data_bcg[1]
			var tools_height=fb5_books[_cur_book].toolsHeight//data_bcg[2];
			var bcg=fb5_books[_cur_book].bcg//data_bcg[3];
			var opacity=fb5_books[_cur_book].opacity
			var bcg_div=$('#fb5-ajax .fb5-bcg-book');			
			bcg_div.css('opacity',opacity);             
			if (  bcg.match(/\..{3}$/) !=null  ){
					bcg_div.css('background-image','url("'+bcg+'")');
			}else{
					bcg_div.css('background-color',bcg);				    	
			}
			$('#fb5-ajax').waitForImages({
										   waitForAll: true,
										   finished: function() {
											   
											    if(  $('#fb5-ajax').attr('data-cat')  == undefined ){ ///as lightbox										
											         Ajax_v5.init_book(books_)
												}else{
													 Ajax_v5.init_from_shortcode( $('#fb5-ajax').attr('data-cat')  );
												}
											   										  
										   }
			});
			Book_v5.book_area(width,height,tools_height);
			/*/
			
			if(  $('#fb5-ajax').attr('data-cat')  == undefined ){ ///as lightbox										
				  Ajax_v5.init_book(books_)
			}else{
	              Ajax_v5.init_from_shortcode( $('#fb5-ajax').attr('data-cat')  );
			}
		 
		 
	 },
	 
	 start_book_shortcode:function(){
		 
		 var books=$('#fb5-ajax').attr('data-cat')
		 Ajax_v5.speed_bcg( books  );	 
		 
	 },
	 
	 
	 start_book_lightbox:function(){		 

				///lightbox from deeplinking
				var cur_book=$.address.pathNames()[0]
				if(cur_book!=undefined&&cur_book!='book_close'){
								 
							///search function load_book_lightbox in body document
							var string=$('body').html();
							var regex = /load_book_lightbox\(\'(.+?)\'(,(.+?))?\)/g;
							var array=string.match(regex);
							
								
							$.each(array, function( index, value ) {
								var regex=/load_book_lightbox\(\'(.+?)\'(,(.+?))?\)/;
								var books=value.match(regex)[1];														
								if( books.indexOf(cur_book) >=0 ){						
									Ajax_v5.init_from_function(books)												
									return false;				
								}			
							});
						
				
				}else{   //autostart lightbox
					
						var string=$('body').html();
						var regex = /load_book_lightbox\(\'(.+?)\',(true)\)/;
						var results=string.match( regex )
						if( results != null ){
							Ajax_v5.init_from_function(results[1])
						}
					
				}

	 },

     init_from_shortcode:function(books_){              
			  
			  if(books_!=undefined){
			  	this.init_book( books_ ); 
			  }
	 },	
	  
	 init_from_function:function(books_){
 
		 $("body").append("<div id='fb5-ajax' class='fb5-fullbrowser fb5-lightbox'><div class='fb5-bcg-book'></div></div>")
		 Ajax_v5.speed_bcg( books_ );
		 $('body,html').addClass('remove_scroll');
	 },
	 
	 auto_select_book:function(books_){		 		   		   
		   		 
		   var categories=books_.split(",");  //array
		   var address=$.address.pathNames()[0]
			  
			  //set category
			  var cat=categories[0];
			  $.each(categories, function(index, value) { 
					 if(value==address){
						 cat=value;
					 }
			  });
			  
		   return cat;	  
	 },
	 
	 init_book:function(books_){
		   
		   this.all_books_slug=books_;		   		   
		   		 
		   var categories=books_.split(",");  //array
		   var address=$.address.pathNames()[0]
			  
			  //set category
			  var cat=categories[0];
			  $.each(categories, function(index, value) { 
					 if(value==address){
						 cat=value;
					 }
			  });
			  
		    
		   //set background				  
	  
	
	
	 this.load_config( cat );	  
		 
	 },
	 
	 isPdf_js:function(){
		 
		if(  Book_v5.getConfig('pdf_type') == "js" && Book_v5.getConfig('pdfjs_source').length > 0 ){
		  return true;				
		}else{
		  return false;	
		}
	 },
	 
	 
	 get_ajax_url:function(){
		 
		         var is_as_template=$('#fb5-ajax').attr('data-template');	
				 if( is_as_template == "true" ){
					 var url=$('#fb5-ajax').attr('ajax_url');
				 }else{
				     var url=ajax_object.ajax_url;
				 } 
				 return url;
		 
	 },
	 
	 addConfigData:function(config_){
		 
		                CONFIG={}; //create object with configuration 						
						if( $('#fb5-ajax').attr('data-cat')   == undefined ){ ///lightbox
						    var config=config_;
						}else{ //shortcode
							var config='#config';							
						}
						$(config).find('ul li').each(function(index, element) {
									var _li=$(element);
									var _key=_li.attr('key');
									var _value=_li.text();
									CONFIG[_key]=_value                            
						});
				 		/////
						var pdf_url=Book_v5.getConfig('pdf_url');
						if( pdf_url.length ){
							 Book_v5.setConfig('pdf_type','js');
						     Book_v5.setConfig('pdfjs_source',pdf_url);
						}
						
						
		 
	 },
	 
	 check_pdf:function(cat_){
		                //if PDF.js						
						if( Book_v5.getConfig('pdf_type') == "js" && Book_v5.getConfig('pdfjs_source').length > 0 ){ 
						                       
						                        var url=Book_v5.getConfig('pdfjs_source');
												var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;												
												if(!is_chrome ){
													//PDFJS.disableWorker = true;
												}
												
												//PDFJS.workerSrc = 'js/pdf.worker.js'
												PDFJS.getDocument(url).then(function getPdfFile(_pdfDoc) {                                          																
																 															 
															  pdfDoc = _pdfDoc;		
															  var pdf_length=pdfDoc.numPages;	
															  Book_v5.pdf_length= pdf_length;
															  
															  pdfDoc.getPage(1).then(function(page) {
																        var scale=Book_v5.getConfig('pdf_scale');
																		var viewport = page.getViewport(scale);
																		var w=viewport.width;
																		var h=viewport.height;
																		Book_v5.setConfig('page_width',w);
																		Book_v5.setConfig('page_height',h);
														     			Ajax_v5.load_book(cat_)
																	
															   })
						  
												});	
												
						}else{   ///not pdf.js
							Ajax_v5.load_book(cat_,[])							
						}
		 
	 },

	 load_config:function(cat_){		 
		   		  
		   
		    //load config for flipbook
			if( $('#fb5-ajax').attr('data-cat')   == undefined ){ ///lightbox	
					
						var url_config				
						$('a[onClick*=load_book_lightbox]').each(function(index, element) {
							var el=$(element); 
							var _onClick=el.attr('onClick');
							var regex=/load_book_lightbox\(\'(.+?)\'(,(.+?))?\)/;
							var book_name=_onClick.match(regex)[1];
							if(book_name==cat_){
							   url_config=el.attr('data-config'); 						
							}
						});
						$.ajax({                                      
							  url:url_config,					           
							  success: function(config_)         
							  {	
								//add config
								Ajax_v5.addConfigData(config_);
								//event added config
								Ajax_v5.check_pdf(cat_)
							  }
					   })				
				
			}else{ //shortcode						
				
				//add config
				Ajax_v5.addConfigData();
				//event added config
				Ajax_v5.check_pdf(cat_)		
			}
			
		    
   
	     
	 },
	
	load_book:function(cat_){
		
			
				if( general.browser_firefox() ) {
						console.log("book:ajax load cat="+cat_); 
				}
	
				 var cat=cat_;
				 var url;
				 ////BEGIN get URL from html code
				 if( $('#fb5-ajax').attr('data-cat')   == undefined ){ ///lightbox	
				       
					    $('a[onClick*=load_book_lightbox]').each(function(index, element) {
							var el=$(element); 
							var _onClick=el.attr('onClick'); 
							var _data_content=el.attr('data-content');
							var regex=/load_book_lightbox\(\'(.+?)\'(,(.+?))?\)/;
					        var book_name=_onClick.match(regex)[1];
							if( book_name==cat_ ){
							   url=_data_content; 						
							}
					     });
						 
						 $.ajax({
                            url: url,
                         	fb5:true,
                            dataType: 'html',
							async: true,
                            beforeSend: function() {
                               
                            },
							complete:function(){
								 $('#fb5').attr('data-current',cat_);
								 Book_v5.ready();							 
								
							},
                            success: function(data, textStatus, xhr) {
								
								 
								 $('#fb5-ajax').append(data).waitForImages({
									   waitForAll: true,
									   finished: function() {
										  if( general.browser_firefox() ) { 
										  	console.log('book:load all images in ajax');
										  }
										 
										  Book_v5.load()
										   
										   
									   }
								});
                                  
								
                               
                            },
                            error: function(xhr, textStatus, errorThrown) {
                               alert("error load book  / "+errorThrown);
                            }
                        });
						
						
						 				 
				 }else{ //shortcode			 
                      
					  $('#fb5').attr('data-current',cat_);
					  Book_v5.ready();					  
					  $('#fb5-ajax').waitForImages({
									   waitForAll: true,
									   finished: function() {
										  if( general.browser_firefox() ) { 
										  	console.log('book:load all images in ajax');
										  }										 
										  Book_v5.load()		   
									   }
			          });				  
					  					 
				 }
	 	}
}

/* =  event ajaxSuccess 
--------------------------*/
$(document).ajaxSuccess( function(event, xhr, settings){
      
	   if(  settings.fb5==true ){
			   //Book_v5.ready();  

          //Book_v5.renderPage(1);
    
	  
	   }

});


/* =  event ajaxComplete 
--------------------------*/
$(document).ajaxComplete(function(event, xhr, settings){
	
	 if(  settings.fb5==true ){
		 //Book_v5.load();
	 }
	 
})


/* =  show Book
--------------------------*/
  load_book_lightbox=function(books_){
		Ajax_v5.init_from_function(books_);
  }
  

/* =  show Book
--------------------------*/  
  
  function clean(obj) {
	    rendered=[]
		var it;
		while(obj.children().length) {
		it = obj.children(":eq(0)").unbind().removeData().remove();
		clean(it);
		}
		
		$(document).unbind('mousemove');
		$(document).unbind('touchmove');
		
		$(document).unbind('mouseup');
		$(document).unbind('touchend');
}

 
/* =  set Page
--------------------------*/
     
  setPage=function(nr_) {
	      
      if( SWF_ADDRESS == "true" ){ 
          var results= $("#fb5-deeplinking ul li[data-page="+nr_+"]");
		  var address = results.attr('data-address');
	  	  setAddress( $('#fb5').attr('data-current')+"/"+address);	
      }else{
           $('#fb5-book').turn('page',nr_);      
      }
       
 };
 
 
 /* =  set Page
--------------------------
NO the problem with the Iphone Landscape
*/
     
  setPageTurn=function(nr_) {      
        var nr=nr_;
		if(RTL=='true'){
	      nr=new Number(nr_).rtl()    
		}	  
        $('#fb5-book').turn('page',nr);      
  };
 
 
 /* =  set Page from page links  ( pdf links in page )
-------------------------------------------------------*/ 
  
 setPagePdfLinks=function(num_,id_){  
		  		
		   if(id_){ 
			   var dest_=Book_v5.getAnnotation(num_,id_).dest;	
		   }else{
			   var dest_=num_;	   
		   }					
		   setPageDest(dest_)		
  }
  
  
/* =  set Page from 'dest' ( documentation in pdf.js )
---------------------------------------------------------*/ 
  
 setPageDest=function(dest_){  
		  	
			
		   if( typeof(dest_)  == 'object' ){ //object
			  var promise=  Promise.resolve(dest_)
		   }else{ //string
		      var promise=  pdfDoc.getDestination(dest_)   
		   } 	
				
		   ////get number page for dest												
		   promise.then(function(dest) {
                    return pdfDoc.getPageIndex(dest[0])
           }).then(function(number) {
	                setPageTurn(number+1);
           }).catch(function() {
                   return console.error("error link")
            })   
		
  }
 
 

/* =  set Address
--------------------------*/

 setAddress=function(address_) {
       
	   $.address.value( address_ );
  };


/* =  show lightbox with video 
--------------------------*/

  youtube=function(id_,w_,h_) {

	 var w=w_;
	 var h=h_;
	 var id=id_;
	 
	$('body').prepend('<div id="v5_lightbox"><div class="bcg"></div><iframe class="youtube-player" width='+w+' height='+h+' src="http://www.youtube.com/embed/'+id+'?html5=1" frameborder="0" allowfullscreen></iframe></div>');
  
    $(window).trigger('orientationchange');
	  	
	$("#v5_lightbox").click(function(){
		$(this).children().hide();
		$(this).remove();
        
        Book_v5.zoomAuto();
	})
	
	$("#v5_lightbox").css('display','block');
	
 };
 
 
/* =  prototype 
--------------------------*/
Number.prototype.rtl=function()
{
return (Book_v5.getLength()+1)-this.valueOf();
}


/* =  local general function 
--------------------------*/
var general={

browser_firefox:function(){	
	if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
	  return true;	
	}else{
	  return false;	
	}
}

}


/* =  FlipBook v5
--------------------------*/
var Book_v5 = {

	toolsHeight:0,   //tools height
    zoom:1,           //zoom
    page_padding:0.1,
    paddingL:0.03,
    paddingR:0.05,
    paddingT:0.02,
    paddingB:0.02,
	width_slider:0,
	inter_font:0,
    currentPage:0,
    


    ready: function(){
	   if( general.browser_firefox() ) {	
       		console.log('book:ready');    
	   }
	   
	   this.annotationsData=[];	 
	  
	   //lightbox
	   if(  $('#fb5-ajax').attr('data-cat')  == undefined ){
	   		
			//$('#fb5-ajax').addClass('fb5-lightbox');
			//$('#fb5-ajax').addClass('fb5-fullbrowser');
			
				 
			$('#fb5-close-lightbox').bind('click',function(e){	
			
			    setTimeout(function(){
					$('body,html').removeClass('remove_scroll');			
				},100);
				
				if(  $('#fb5-ajax').hasClass('fullScreen')  ){
					
					Navigation_v5.full_screen();
					//return false;
				}
				
				setTimeout( function(){				
				$(this).remove();			//remove button close	
				clean( $('#fb5')  );  		//clean book html				
				$('#fb5-ajax').remove();    //remove container book
				window.location.hash="#book_close";  //remove hash				
				Book_v5.load_one_thumbs=null;
				},1);
				
			})
	   
	   }
	   
	   
	   //remove default touch move  
		//$(document).bind('touchmove',function(e) {
				//e.preventDefault(); 
			//});
		
	   
	  
	   
	  
       //Configuration
	   PAGE_MODE=Book_v5.getConfig('page_mode');
	  	   
	   if( PAGE_MODE == "auto" ){
		   if( $(window).width() > $(window).height() ){
			   DISPLAY="double";
		   }else{
			   DISPLAY="single";   
		   }
	   }else{
		   DISPLAY=PAGE_MODE; 
	   }
	   
	   if( DISPLAY == "single"){	   
		  CONFIG['page_width']= CONFIG['page_width']/2;	
	   }
       WIDTH_BOOK=Number(  Book_v5.getConfig('page_width')   )*2;	  	    	 
       HEIGHT_BOOK=Number(  Book_v5.getConfig('page_height')  );
       ZOOM_STEP=Number(    Book_v5.getConfig('zoom_step')   );
       ZOOM_DOUBLE_CLICK_ENABLED=(  Book_v5.getConfig('double_click_enabled')  );           
       ZOOM_DOUBLE_CLICK=Number(  Book_v5.getConfig('zoom_double_click')  )
       GOTOPAGE_WIDTH=Number(   Book_v5.getConfig('gotopage_width')   );
       TOOL_TIP_VISIBLE=(  Book_v5.getConfig('tooltip_visible') );
       SWF_ADDRESS=(  Book_v5.getConfig('deeplinking_enabled')  );
	   RTL=Book_v5.getConfig('rtl');
	   
       IS_AS_TEMPLATE= $('#fb5-ajax').attr('data-template') == "true" ? true : false;
       TOOLS_VISIBLE=(  Book_v5.getConfig('toolbar_visible') );
       if( TOOLS_VISIBLE == "true" ){
			 Book_v5.toolsHeight=50;
	   }else{
			 Book_v5.toolsHeight=0;
		}
		
		
		
		////add section links for page
		if( Book_v5.getConfig('pdf_type')!="js" ){
				$('#fb5-book > div').each(function(index, element) {
						var links=$('#links div[data-page="'+(index+1)+'"]');
						if( links.length ){
						   links= links.html();
						   $(element).append("<div class='links'>"+links+"</div>");	
						}
				});
		}
		
	
		
		
		/////enabled/disabled lazy loading for thumbs
		if(  Book_v5.getConfig('lazy_loading_thumbs')!='true' && Book_v5.getConfig('pdf_type')!="js"  ){
				$('#fb5-all-pages li img').each(function(index, element) { 										
							var el=$(element);                            
							var src=el.attr('data-src');												
							if( el.attr('src')==undefined  ){
								el.attr('src',src);					
							}
				});	
		}
		
		
		/////enabled/disabled lazy loading for pages
		if( Book_v5.getConfig('pdf_type')!="js" ){
			
						if( Book_v5.getConfig('lazy_loading_pages')=="true" ){	
						
							/*lazy loading for pages enabled
							you need to load a previously two current page
							( change attributes data to src )			
							/*/		
							
							//get current pages
							var address=$.address.pathNames()[1];
							var results=$('#fb5-deeplinking ul li[data-address='+address+']');
							var nrPage=new Number(results.attr('data-page'))  //nr page from deeplinking
							var left=Book_v5.getCurrentPages(nrPage).left;
							var right=Book_v5.getCurrentPages(nrPage).right;
							
							if( left != null ){ //current left page
								 var left_div=$('#fb5-book > div').eq(left-1);
								 //change data-background-image to background-image
								 var data_background_image=left_div.attr('data-background-image');			 			 
								 if(   data_background_image!=""   ){				 
									   left_div.css('background-image', 'url("'+data_background_image+'")');				 
								 }
								 //change data to src for image in description page
								 $('.fb5-page-book img',left_div).each(function(index, element) {
										var data_src=$(element).attr('data-src');
										$(element).attr('src',data_src);					
								 });		
								 
							}
							
							if( right != null ){  //current right page
								 var right_div=$('#fb5-book > div').eq(right-1);
								  //change data-background-image to background-image
								 var data_background_image=right_div.attr('data-background-image');			 			 
								 if(   data_background_image!=""   ){				 
									right_div.css('background-image', 'url("'+data_background_image+'")');				 
								 }
								  //change data to src for image in description page
								 $('.fb5-page-book img',right_div).each(function(index, element) {
										var data_src=$(element).attr('data-src');
										$(element).attr('src',data_src);					
								 });	
							}
							
						}else{ 
						
							  /*lazdy loading for pages disabled
							  you need to replace the data-src attribute to src
							  /*/  
							
							  //change attributes data-background-image to background-image
							  $('#fb5-book > div').each(function(index, element) {           
									 var page_div=$(element);
									 var data_background_image=page_div.attr('data-background-image');	
																		 
									 if(   data_background_image!="" &&  data_background_image!=undefined   ){	
										 page_div.css('background-image', 'url("'+data_background_image+'")');	
											 
									 }
							   });	
							   //change data to src for image in description page
							   $('.fb5-page-book img').each(function(index, element) {
										var data_src=$(element).attr('data-src');
										$(element).attr('src',data_src);
									
							   });			    
									
						}
		}
		
		
		////generate html code ( if use PDF.js )
		if( Book_v5.getConfig('pdf_type')=="js" ){
		     
			  
			 $('#fb5-slider').empty(); ///remove all thumbs
			 $('#fb5-book').empty(); ///remove all pages in book
			 $('#fb5-deeplinking ul').empty(); //remove all data from deeplinking
			 var _pdf_length=Book_v5.pdf_length;
			  
			 for(var i=1;i<=_pdf_length;i++){
				 
				//add thumbs 
				var thumb='<li class="'+i+'"></li>'
				$('#fb5-slider').append(thumb);
				
				//add pages
				var links=$('#links div[data-page="'+i+'"]');
				if( links.length ){
				   links= links.html();	
				}else{
				   links='';
				}
				
				var page='<div data-background-image=""><div class="fb5-cont-page-book"><div id="canv'+i+'" class="pdfjs"><canvas></canvas><div class="annotation"></div></div><div class="fb5-gradient-page"></div><div class="fb5-page-book"></div></div><div class="links">'+links+'</div></div>';                                                              
                 $('#fb5-book').append(page); 
				 
				
				 
				 
				 
			   //add deep linking			  
			   var left_a
			   var right_a
			   if(i==1){
				 left_a=1; 
				 right_a='';
			   }else if(i==_pdf_length){
				 left_a=''; 
				 right_a=_pdf_length;
			   }else if(i%2==0){
				 left_a=i;
				 right_a="-"+(i+1)
			   }else{
				 left_a=i-1   
			   }
	
			   var address=i//left_a+right_a;
			   var dep='<li data-address="'+address+'" data-page="'+i+'"></li>';
			   $('#fb5-deeplinking ul').append(dep);	                    
	
			 }
		}
		
		
		
	   //add class 'even' and 'odd' using jQuery
	   if( RTL == "false" ){	
	        if( DISPLAY=="single"){
			   $("#fb5-book > div:odd").addClass("even");
			   $("#fb5-book > div:even").addClass("even");
			}else{
			   $("#fb5-book > div:odd").addClass("odd");
			   $("#fb5-book > div:even").addClass("even");
			}
	   }else{
		   if( DISPLAY=="single"){
			   $("#fb5-book > div:odd").addClass("even");
			   $("#fb5-book > div:even").addClass("even");			   
		   }else{
			   $("#fb5-book > div:odd").addClass("even");
			   $("#fb5-book > div:even").addClass("odd");	
		   }
	   }	
	   
	   
	   
	   
		
		
		
		//reverse book		
		$( $('#fb5-book>div').get().reverse()  ).each(function(index,element) { 
			    var item=$(element);
				var meta=$('div.fb5-meta',this);
				///for only reverse
				if( RTL == "true" ){				  
					  //reverse					
					  $(this).appendTo( $(this).parent() );					  
					  //reorder description and number
					  var desc=$('span.fb5-description',item);
					  if( desc.index() ==0 ){
						desc.appendTo(meta);						  
					  }else{
						desc.prependTo(meta); 
					  }				  					  
					  ///for double
					  if( item.hasClass('fb5-double') ){						  
						if(  item.hasClass('fb5-first') ){
						     item.removeClass('fb5-first').addClass('fb5-second');							
						}else if( item.hasClass('fb5-second') ){
							 item.removeClass('fb5-second').addClass('fb5-first');							
						}						  
					  }		
					 //add data for meta
				 	 if( index%2!=0 ){			 
				  		meta.addClass('fb5-left');		
				 	 }else{
				  		meta.addClass('fb5-right');					 
				 	 }			  
      			}else{
					 //add data for meta
				 	 if( index%2==0 ){			 
				  		meta.addClass('fb5-left');		
				 	 }else{
				  		meta.addClass('fb5-right');					 
				 	 }					
				} 
		});
		
		
		
		
		///about show			
		if( DISPLAY == "double"){	   
		  $('#fb5-about').css('display','block');	
	    }
		  

       //event resize
       $(window).bind('orientationchange resize', function(event){
		   
		    ///refresh only for change orientation
		    if(event.type=='orientationchange' && PAGE_MODE=="auto" && Book_v5.isMobile() ){
					setTimeout(function(){
								   window.location.reload();								   
					},1);
			}
		   
            Book_v5.book_area();
            Book_v5.zoomAuto();
            Book_v5.book_position();
            Book_v5.dragdrop_init();        
            Book_v5.resize_page()     
            Book_v5.center($('#v5_lightbox'));           
            Book_v5.center_icon();
            Book_v5.center_icon();
            Book_v5.media_queries()
		});
		////end  
		
		   
         
        WINDOW_WIDTH=$('#fb5').width();
        WINDOW_HEIGHT=$('#fb5').height();
        
        Book_v5.resize_input_text()
    	Book_v5.book_area();
    	$("#fb5").css('opacity','1');
    	
            
        
        /* SCALE PAGE IN FLIPBOOK  /*/
        //size default for class .fb5-cont-page-book
		if(DISPLAY=="single"){
			$("#fb5 .fb5-cont-page-book").css('width',(WIDTH_BOOK)+'px');
		}else{
        	$("#fb5 .fb5-cont-page-book").css('width',(WIDTH_BOOK/2)+'px');
		}
        $("#fb5 .fb5-cont-page-book").css('height',HEIGHT_BOOK+'px');
        $("#fb5 .fb5-cont-page-book").css({'transform-origin':'0 0','-ms-transform-origin':'0 0','-webkit-transform-origin':'0 0'});
        //size default for class .page_book
        var paddingL=WIDTH_BOOK*this.paddingL;
        var paddingR=WIDTH_BOOK*this.paddingR;
        var paddingT=WIDTH_BOOK*this.paddingT;
        var paddingB=WIDTH_BOOK*this.paddingB;        
		if(DISPLAY=="single"){
			$("#fb5 .fb5-page-book").css('width',(WIDTH_BOOK-(paddingL+paddingR))+'px');
		}else{
			$("#fb5 .fb5-page-book").css('width',(WIDTH_BOOK/2-(paddingL+paddingR))+'px');
		}
        $("#fb5 .fb5-page-book").css('height',(HEIGHT_BOOK-(paddingT+paddingB))+'px');
        
        /* SCALE ABOUT near FLIPBOOK  /*/
        $("#fb5 #fb5-about").css('width',(WIDTH_BOOK/2)+'px');
        $("#fb5 #fb5-about").css('height',HEIGHT_BOOK+'px');
		if(RTL=='true'){
			$("#fb5 #fb5-about").css('right','0px');
			$("#fb5 #fb5-about").css({'transform-origin':'right 0','-ms-transform-origin':'right 0','-webkit-transform-origin':'right 0'});
		}else{
        	$("#fb5 #fb5-about").css({'transform-origin':'0 0','-ms-transform-origin':'0 0','-webkit-transform-origin':'0 0'});
		}
		
        //run key
        this.key_down();    

        //show and hide full screen icon
        if(!$.support.fullscreen){
        	$('li a.fb5-fullscreen').parent(this).remove();
        }
		
		///redirect from youtube and setPage ( change attributes href to onClick )
		$('#fb5 a[href]').each(function(index, element) {
			var el=$(element);
            var href=el.attr('href');						
			if ( href.indexOf("youtube") >= 0 || href.indexOf("setPage") >= 0 ) {
				   el.attr('onClick',href);
				   el.removeAttr('href');			   
		    }
        });
		
		
			
		
		/////add remove scrollbar
	   //if( $('#fb5-ajax').hasClass('fb5-fullbrowser') ){
	    	//$('body,html').addClass('remove_scroll');
	   //}
             
    },
        
    load: function(){
		if( general.browser_firefox() ) {
        	console.log('book:load');
		}
		
		//show class .links
		if( Book_v5.getConfig('lazy_loading_pages')=="false" ){	
		    $('.links').css('display','block');
		}
		
		//preloader hide
		if( Book_v5.getConfig('pdf_type')!="js" ){
        	$('#fb5 .fb5-preloader').css('display','none');
		}
        
   		$.address.strict(false)
		$.address.autoUpdate(true)
	
		$('#fb5-container-book').show();
		
		Book_v5.init();
	
	 
		Book_v5.setPointZoomDefault();
		Book_v5.zoomAuto();
		Book_v5.zoomAuto();
		
		Book_v5.book_position();
	
		Book_v5.dragdrop_init();

		Navigation_v5.init();

		Book_v5.resize_page();   
        
		
		clearInterval(Book_v5.inter_font);
		Book_v5.inter_font=setInterval( function(){
						$('#fb5-center ul li').each(function(index, element) {
						var el=$(element);
						if(el.width()>0){
							        if( TOOLS_VISIBLE == "true" ){
										$("#fb5 #fb5-footer").css('opacity','1');
									}									
									 //center icon
									Book_v5.center_icon();
									Book_v5.center_icon();
									Book_v5.media_queries()	
									clearInterval(Book_v5.inter_font);	
									return false;					
						}						
					});

		},100);		
	  
	  
	  //pinch zoom
	 //Book_v5.pinchZoom();
	 
	 //mousewheel
	 Book_v5.mousewheel_on();
	  
			 
    },
	
	mousewheel_on:function(){
		this.mousewheel_off();
		$('#fb5-container-book').mousewheel(function(event, delta) {
			
			            event.preventDefault();
			
						var offset=$('#fb5-container-book').offset();
						var mouse_x=event.pageX-offset.left;
						var mouse_y=event.pageY-offset.top;					
						Book_v5.setPointZoom(mouse_x,mouse_y);
													  
						if( delta > 0 ){
							Book_v5.zoomIn()										  
						}else{
							Book_v5.zoomOut();  
				  		}		
		});				
	},
	
	mousewheel_off:function(){
		$('#fb5-container-book').unmousewheel();				
	},
	
	 //pinch zoom and grab flipbook for mobile
	 pinchZoom:function(){
			
	   var _this=this				  
	   this.first_c;
	   this.first_zoom;
	   this.lastTime=null;
	   this.swipe={}
	   this._click=0;
	   this.pinchEvent;
	   this.prevent;
	   
	   if( !this.prevent ){	
		   //remove default zoom for mobile device
		   $(document).bind('touchmove',function(e) {
					 if(  _this.pinchEvent=="move" ){
						 e.preventDefault(); 
					 }
		   });
		   this.prevent=1;
	   }
	   
	   $('#fb5-container-book').bind('touchstart',function(e){
		   //e.preventDefault();
		   //e.stopPropagation()
		   
		   _this.pinchEvent="start";
		   
		   //for swipe
		    if(e.originalEvent.touches.length==1){
				   _this.swipe.sx=e.originalEvent.touches[0].pageX;
				   _this.swipe.sy=e.originalEvent.touches[0].pageY;
				   _this.swipe.st=new Date().getTime();
				   _this.swipe.ex=e.originalEvent.touches[0].pageX;
				   _this.swipe.ey=e.originalEvent.touches[0].pageY;
			}
		   
		   
		   _this.book_x = e.originalEvent.touches[0].pageX;
           _this.book_y = e.originalEvent.touches[0].pageY;	
		  
		  
		   //start double click for mobile devices
		   if( Book_v5.isiPhone() ){
					if(e.originalEvent.touches.length==1){
							  var currentTime = new Date().getTime();
							  var deltaTime=currentTime-_this.lastTime;
							  
							  _this._click++
														  
							  if( deltaTime< 300 && _this._click>=2   ){
								 
								 _this._click=0
								 if(Book_v5.checkScrollBook()==false){ //zoom
								         var new_zoom=ZOOM_DOUBLE_CLICK+Book_v5.zoom
										 if( new_zoom > 1 ){
											new_zoom=1; 
										 }
                                         var container_book =  $('#fb5-container-book').offset();    
										 Book_v5.setPointZoom(_this.book_x-container_book.left,_this.book_y-container_book.top)
										 Book_v5.zoomTo(new_zoom)
								  }else{
									    Book_v5.setPointZoomDefault();
										Book_v5.zoomAuto()
										Book_v5.book_position();
								  }
							  }
							
							
							 _this.lastTime=currentTime;
					 }
		   }
		    //end double click
				 
				 	   
		   
	   })
	   
	  		
	   $('#fb5-container-book').bind("touchmove", function(e) {    
	  		
			  _this.pinchEvent="move";
		
	          //for swipe
			    if(e.originalEvent.touches.length==1){
					 _this.swipe.ex=e.originalEvent.touches[0].pageX;
					 _this.swipe.ey=e.originalEvent.touches[0].pageY;
					 _this.swipe.et=new Date().getTime();
				}
	            
				   
			  //pinch zoom	   
			  if(e.originalEvent.touches.length==2){   
				       
					   _this.two_finger=1;
				      
					   var x=e.originalEvent.touches[0].pageX;
					   var y=e.originalEvent.touches[0].pageY;
									
					   var x2=e.originalEvent.touches[1].pageX;			  
					   var y2=e.originalEvent.touches[1].pageY;
				
					   var a=x2-x;
					   var b=y2-y;
					   
					   var c = Math.sqrt(a*a + b*b);
					   if(!_this.first_c){
						  _this.first_c=c 
						  _this.first_zoom= Book_v5.zoom	 
					   }
					   c=(c-_this.first_c)/300;
					   
					   
					   //calculate zoom
					   var zoom= _this.first_zoom+c
					   var zoom_max=1//Number(Book_v5.getConfig('zoom_max'))
					   if( zoom>=zoom_max){
						  zoom=zoom_max;   
					   }	
					   var min_zoom=Book_v5.getAutoZoomBook(0);
					   if( zoom<min_zoom){
						  zoom=min_zoom   
					   }
					   
					   
					   ///calculate point zoom
					   var container_book =  $('#fb5-container-book').offset();							 
					   var point_zoom_x=x+a/2-container_book.left
					   var point_zoom_y=y+b/2-container_book.top
					   Book_v5.setPointZoom(point_zoom_x,point_zoom_y);

                       //set Zoom
					   Book_v5.zoomTo(zoom)	
					   //Book_v5.book_position();   
					   		
					   //the flipbook scale can not be smaller than the original			
					   if( Book_v5.checkScrollBook(true)==false){
		  					Book_v5.zoomAuto();
							Book_v5.book_position();	
								   				   	   
					   }
					  
					  
			  }
			  
			  
			  //drag
			  if(e.originalEvent.touches.length==1){
				           				   
									 //delta x
									_this.book_x_delta=e.originalEvent.touches[0].pageX-_this.book_x;
									_this.book_x=e.originalEvent.touches[0].pageX;
									
									//delta y
									_this.book_y_delta=e.originalEvent.touches[0].pageY-_this.book_y;
									_this.book_y=e.originalEvent.touches[0].pageY;
									
											
									var current_x= parseInt(  $('#fb5-container-book').css('left')  )
									var current_y= parseInt(  $('#fb5-container-book').css('top')  )
									
									var x=current_x+_this.book_x_delta;
									var y=current_y+_this.book_y_delta;
									if(_this.checkScrollBook() == true){
										$('#fb5-container-book').css( {left:x,top:y } ); 
									}else{
										Book_v5.book_position();
									}
									
									e.preventDefault(); // it is very important
		   
			   }
   
   
		});
		
		 $('#fb5-container-book').bind("touchend", function(e) {             
				   
				 
				    
				  
				  //for swipe
				   if(_this.two_finger!=1){
					   
							   var delta_x=_this.swipe.ex-_this.swipe.sx
							   var delta_t=_this.swipe.et-_this.swipe.st
							   							   						
							   if( Math.abs(delta_x) > 170 && delta_t<200 && Book_v5.checkScrollBook()==false ){	
								   if(delta_x<0){
										Book_v5.nextPage();
										//$('#fb5-about').html("++")
								   }else {
										Book_v5.prevPage();
										//$('#fb5-about').html("--")
								   }
								   
								  
							   }
					   
				   }
				 
				   
			    _this.first_c=null;
			  
			      //for drag flipbook ( if one finger on pinchzoom )
				  if(e.originalEvent.touches.length==1){   
					 _this.book_x = e.originalEvent.touches[0].pageX;
					 _this.book_y = e.originalEvent.touches[0].pageY;
				  }
				  
				   if(e.originalEvent.touches.length==0){  
				  		_this.two_finger=0;
				   }
				 
				 
				    _this.pinchEvent="end";
				
				 
				///remove event 'touchmove' for all area 
				 //$(document).bind('touchmove',function(e) {
				  //return true; 
			  	//});
		});
		
	},
	
	renderPage:function(num){
		
		//$('#fb5 .fb5-preloader').css('display','block');
         		
        var scale = (Book_v5.getConfig('pdf_scale'));
		var canvasID = '#canv' + num;
		var canvas = $(canvasID+' > canvas')[0];
		if (canvas == null) return;
		canvas.style.width = 100+"%"
		canvas.style.height = 100+"%"
        var ctx = canvas.getContext('2d');	
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
		//render
        var renderTask=page.render(renderContext);
		
		//annotation links
		Book_v5.add_annotations(num, page, viewport, canvas, $(canvasID+'> .annotation'));
		
		//on render ready
		renderTask.promise.then(
			  function pdfPageRenderCallback() {
		  		  //preloader hide
                  $('#fb5-ajax .fb5-preloader').css('display','none');
				  
				
			  }
		);
		
		
		
       });
   
		
	},
	
	
	getAnnotation:function(index_,id_){
		var _this=this;	
			
			for (var i = 0;i<_this.annotationsData[index_].length; i++) {
				
				if (_this.annotationsData[index_][i].id === id_){
					//console.log( this.annotationsData[i] )
					return _this.annotationsData[index_][i];
				}
			}
			return null;
			
		
	},
	
	add_annotations:function(num_, page, viewport, canvas,annotation) {
		
		
       		
		var _this=this;	
        var promise = page.getAnnotations().then(function (annotationsData) {
						 
						 //save annotatin to array ( see function getAnnottion )
						 _this.annotationsData[num_]=  annotationsData;
				
						 viewport = viewport.clone({
							dontFlip: true
						 });
						 	
												 
						 //getAllBookmarks
						 //Book_v5.getAllBookmarks();	
												 
						 //get links
						 for (var i = 0; i < annotationsData.length; i++) {
							 
							   var data = annotationsData[i];
							   var dest=data.dest
							   var id=data.id;
							  
							   //rectangle		   
							   var element=$('<a/>', {
											id: id,
											href: data.url,
											class:"link_pdf",
								  		    target:"_blank"	
											
								})
								
							
									
								//position and size rectangle						
								var rect = data.rect;
								var view = page.view;
								rect = PDFJS.Util.normalizeRect([rect[0],view[3] - rect[1] + view[1],rect[2],view[3] - rect[3] + view[1]]);           											                                var scale=Book_v5.getConfig('pdf_scale');
								$(element).css('left',( rect[0]*scale) + 'px');
								$(element).css('top',( rect[1]*scale) + 'px');
								$(element).css('width', (rect[2] - rect[0])*scale+'px');
								$(element).css('height',(rect[3] - rect[1])*scale+'px');
																
							
								//setPage from links in pdf file ( inside link - change page in flipbook )
								if( dest ){
									if( typeof(dest) == 'object' ) {
										$(element).attr('onClick', "setPagePdfLinks(\'"+num_+"\',\'"+id+"\')");
									}else{
										$(element).attr('onClick', "setPagePdfLinks(\'"+dest+"\')");
									}
								}
		
							
								//add to html			   
								annotation.append(element);
						}
        });
		
        return promise;
    },
	
	getAllBookmarks:function(){  //get All Bookmark
								 
		pdfDoc.getOutline().then(function(t) {
			console.log(t) //show list bookmark in Array
        })				
	
	},	
	
	renderThumb:function(num){
		         
		//add el canvas using jquery 
		var newCanvas = $('<canvas/>', {id:'canvas_thumb'+num}); 		
		var target=$('#fb5-slider li[class='+num+']');
		target.append(newCanvas)	
				
		///calculate scale
		var scale_book = parseInt(Book_v5.getConfig('pdf_scale'));
		var h=parseInt( Book_v5.getConfig('page_height') );
        var scale = 228*scale_book/h;		
		var canvasID = 'canvas_thumb' + num;
		var canvas = document.getElementById(canvasID);
		if (canvas == null) return;
        var ctx = canvas.getContext('2d');	
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport(scale);
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render PDF page into canvas context
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        page.render(renderContext);
       });
   
		
	},
		
	getConfig:function(attr_){		
		return CONFIG[attr_];	
		
	},
	
	setConfig:function(attr_,value_){		
		CONFIG[attr_]=value_;		 
	},
	
	
	getLength:function(){		
		return $('#fb5-deeplinking ul li').length;		
	},
    
    center_icon:function(){
    
        //icon tools position
        var icon=$('#fb5-center');
        var all_width=$('#fb5').width();
        var left_w=$('#fb5-logo').width();
        var center_w=$('#fb5-center').width();
        var right_w=$('#fb5-right').width();    
        var posX=all_width/2-center_w/2;
        icon.css('left',posX+'px');
        
        
        
        
    },
    
    media_queries:function (){
            
       //center
       var position_center=$('#fb5-center').position();
	   var xMax_center=position_center.left+$('#fb5-center').width();
       var xMin_center=position_center.left
       //right
       var position_right=$('#fb5-right').position();
       var xMin_right=position_right.left;
       //left
       var position_left=$('#fb5-logo').position();
       var xMax_left=position_left.left+$('#fb5-logo').width();
          
	   var source=$('#fb5 #fb5-logo,#fb5 #fb5-right');	  
		      
       if( xMax_center > xMin_right || xMax_left > xMin_center  ){
         source.css('visibility','hidden');
		 source.css('opacity','0');
		
       }else{
         source.css('visibility','visible');
		 source.css('opacity','1');
       }


    }, 
    
    autoMarginB:function(){
      return Math.round(  $('#fb5').height()*0.02 )
    },
    
    autoMarginT:function(){
        return Math.round( $('#fb5').height()*0.02 )    
    },
    
     autoMarginL:function(){
      return Math.round( $('#fb5').width()*0.02 )    
    },
    
     autoMarginR:function(){
       return Math.round(  $('#fb5').width()*0.02 )   
    },
	
	change_address:function(){
		
						var th=this;
						if( general.browser_firefox() ) {
							console.log("book:change address")
						}
						//$('h1.entry-title').append(' /change ')
					    ///for slug
					    var slug=$.address.pathNames()[0];
					    if(th.tmp_slug!=undefined&&slug!=th.tmp_slug){
			   			 
					      
						 //setAddress('book5-1'); 
						 //setTimeout(function(){
						   //window.location.reload();
						 //},1);
						 
						 if( general.browser_firefox() ) {
						 	console.log("book:change book")
						 }
						 //$('h1.entry-title').append(' /change book ')
						 
						 //$("#fb5").remove();
						 // Ajax_v5.ready()
						 return;
					   }
					   
					   th.tmp_slug=slug;
					
					   //normal
                       var address=$.address.pathNames()[$.address.pathNames().length-1];
                       var results=$('#fb5-deeplinking ul li[data-address='+address+']');
                       var nrPage=results.attr('data-page')
					   if(RTL=='true'){
				           var nrPage =  ( Book_v5.getLength()+1 ) -results.attr('data-page');						
				       }
					   //error nr page
					   if(!nrPage){
						   if(RTL=='true'){
						      nrPage=Book_v5.getLength();
					       }else{ 
                              nrPage=1;   
						   }
                       }
				
                       $('#fb5-book').turn('page',nrPage);
                       Book_v5.resize_page();
		
	},	
	
	getCurrentPage:function(){
		var current_pages=Book_v5.getCurrentPages();
		var left=current_pages.left;
		var right=current_pages.right;
		var nr_page=right
		if(right==null){
			var nr_page=left;
		}	
		
		if( DISPLAY == "single" ){
			nr_page=Book_v5.currentPage;	
		}
		
		return nr_page;	
	},
	
	getCurrentPages:function(page){
		
							if(!page){
							   page=Book_v5.currentPage;	
							}
		
							if(page%2==0){
								var page_left=page
								var page_right=page+1
							}else{
								var page_right=page
								var page_left=page-1							
							}
							/////if current page is page oldf
							if(page_left==Book_v5.getLength()){
							   page_right=null	
							}
							////if current page is page first 
							if(page_right==1){
							   page_left=null	
							}
							
							return {left:page_left,right:page_right}									
	  	
		
	},
    
    init: function() {
		
		var th=this;
		//this.on_start = true;
		
		
	    if( SWF_ADDRESS=="true" ){
        
                /* =  jQuery Addresss INIT
                --------------------------*/
                var current_address=$.address.pathNames()[$.address.pathNames().length-1];
                BOOK_SLUG=$.address.pathNames()[0];
                var results=$('#fb5-deeplinking ul li[data-address='+current_address+']');
                var nrPage =   results.attr('data-page');
				if(RTL=='true'){
				 var nrPage =   ( Book_v5.getLength()+1 ) -results.attr('data-page');						
				}
               
			    //error nr page
			    if(!nrPage){
					if(RTL=='true'){
						 nrPage=Book_v5.getLength();
					 }else{ 
                         nrPage=1;   
					 }
                }
			
       
                /* =  jQuery Addresss CHANGE
                --------------------------*/
				if(Book_v5.one_init_swf_address==null){ 
					$.address.change(function(event) {
						   th.change_address()     
					})
				}
				Book_v5.one_init_swf_address=1
			   
			   
       }
	   
	  	 
		
		$('#fb5-book').turn({
			display: DISPLAY,
			duration: 600,
			acceleration: true,
			elevation:50,
			page:nrPage,
			when: {
				first: function(e, page) {
					$('.fb5-nav-arrow.prev').hide();
				},
				
				turned: function(e, page) {
					
					Book_v5.currentPage=page;  //Do not delete this, other function use this.
					
					if (page > 1) {
						$('.fb5-nav-arrow.prev').fadeIn();
						//$('#fb5-about').hide();
					}
					
					if( (page==1&&RTL=='false') || ( page==$(this).turn('pages')&&RTL=='true') ){	
						$('#fb5-about').css('z-index',11);
					}						
					
					if ( page < $(this).turn('pages') ) {
						$('.fb5-nav-arrow.next').fadeIn();
					}
					
					
					///add current number page
					var page1=Book_v5.getCurrentPage();
					if(RTL=="true"){
						 page1=Book_v5.getLength()-page+1;
					}
					$('#fb5-page-number').val(page1);
					$('#fb5-page-number-two').empty().append(" /  "+Book_v5.getLength());
					
					
					
					
                                       
					Book_v5.resize_page();
                    if(SWF_ADDRESS=="true"){						
						var new_page=Book_v5.getCurrentPage();
												
                       if(RTL=='true'){
						 setPage( new Number(new_page).rtl() )   
					   }else{
						 setPage(new_page);   
					   }
					       
					   th.tmp_slug=$.address.pathNames()[0]             
                    }
										
					
					//add image required ( lazy loading )
					if(  Book_v5.getConfig('lazy_loading_pages')=="true" || Ajax_v5.isPdf_js()  ){
						    
							//create array with list number pages for left and right side
							var array_right=[];
							var array_left=[];
							
							//get list requided number pages
							var range = $(this).turn('range', page);
							var _pages=[]
							for (i = range[0]; i<=range[1]; i++){ 
								 _pages.push(i)												 	
							}							
							
							////get curent page 'page_left' and 'page_right'
						    var page_left=Book_v5.getCurrentPages(page).left;
							var page_right=Book_v5.getCurrentPages(page).right;								
													
							//create array pages for right side
							if(page_right!=null){
								var index_right=$.inArray(page_right,_pages);
								var array_right=_pages.slice(index_right);
							}
							//createarray pages for left side
							if(page_left!=null){
								var index_left=$.inArray(page_left,_pages)+1;
								var array_left=_pages.slice(0,index_left).reverse();
							}
							//contact array pages ( right+left )
							var pages_new=[];
							var first_left=array_left.shift();
							if(first_left!=undefined){
								array_right.unshift(first_left);
							}
							
							//combine two arrays
							if( RTL == "true" ){
							  pages_new=array_left.concat(array_right);
							}else{
							  pages_new=array_right.concat(array_left); 	
							}
							
																			
							//run pdf loading with array required pages
							if( Ajax_v5.isPdf_js() ){
							   Book_v5.pdf_loading( pages_new )
							}else{ //run lazy loading with array required pages
							   Book_v5.lazy_loading( pages_new )
							}
					}		
					    
						
					  //sound_sheet.pause();
					 
				}, 
				
				turning: function(e, page) {
							
					$('#fb5-about').css('z-index',5);
		
		            /*
					//sound for sheet
					if( Book_v5.without_first_sound_sheet!=null ){
						if( Book_v5.getConfig('sound_sheet').length ){
						  Book_v5.sound_sheet(page);					
						}
					}
					Book_v5.without_first_sound_sheet=1;
	                /*/
				
	   
				},
				
				last: function(e, page) {
					$('.fb5-nav-arrow.next').hide();
				}	
			}
		});
		Book_v5.arrows();
		
	},
	
	sound_sheet: function(page){
		/*
		var current=$('#fb5-book').turn('page')
		if( current%2==0){
		   var page=current+1
        }else{
           var page=current 
        } 
		/*/     
		
		/*
		Book_v5.current_right=Book_v5.getCurrentPages(page).right;									
		if(  Book_v5.current_right!=Book_v5.old_right  ){
			sound_sheet.currentTime=0;
			sound_sheet.play();
		}		
		Book_v5.old_right=Book_v5.current_right;		
		/*/
	},
	
	pdf_loading: function(pages_){	
		
		    if( !rendered ){
			    rendered=[];	
			}

		 
			$.each(pages_, function(index, value) {

				var element=$( '.turn-page.p'+(value) );                		
				
				////PDF.js
				if(RTL=="true"){
					var page=new Number(value).rtl();
				}else{
					var page=value;
				}
				
				if( Ajax_v5.isPdf_js() == true ){
					if ( !rendered[page] ) {
							Book_v5.renderPage(page);
							rendered[page] = true;						
					}
				}
			});
				
      
		
	},
	
	lazy_loading: function(pages_){	
		
		 

		 
			$.each(pages_, function(index, value) {

				var element=$( '.turn-page.p'+(value) );                		
	
				//if( $(element).css('background-image')=='none'  ){		                                  
				var src=element.attr('data-background-image');
											
			    $('<img>').attr('src', src).load(function(){	
					 element.css('background-image', 'url("'+src+'")');
					 //show class .links
					 element.find('.links').css('display','block');
        		});	

				
				//for Firefox  ( not load background image if display:none )
				var el=element.parent()
				if( el.css('display')=='none'  ){					
					
					el.css('opacity','0');
					el.css('display','block')
									    
					setTimeout(function(){
					el.css('display','none');
					el.css('opacity','1');
					},1);
				}
				
				
				////PDF.js
				
			});
				

		
	},
	
	corner_change:function(boolean_){
		//$('#fb5-book').turn("disable",boolean_);		
	},
        
	center: function (lightbox_) {
	
			var iframe=$('iframe',lightbox_);
			var old_w=iframe.attr("width");
			var old_h=iframe.attr("height");
    		iframe.css("position","absolute");
	
			var stage_w=$(window).width();
            var stage_h=$(window).height();
            var delta_w=stage_w-old_w;
            var delta_h=stage_h-old_h
            
            if(delta_w<delta_h){
                var new_w=$(window).width()-200;
                var new_h=(new_w*old_h)/old_w
            }else{
                var new_h=$(window).height()-200;
                var new_w=(old_w*new_h)/old_h
            }
            iframe.attr("width", new_w);
            iframe.attr("height",new_h);
            
            var height=iframe.height();
            var width=iframe.width();
            iframe.css("top", ( $(window).height()/2 - height/2+"px"));
            iframe.css("left", ( $(window).width()/2 -width/2+"px"  ));
	},    
        
    key_down: function(){
        $(window).bind('keydown', function(e){
		if (e.keyCode==37)
			//$('#fb5-book').turn('previous');
            Book_v5.prevPage();
		else if (e.keyCode==39)
			//$('#fb5-book').turn('next');
            Book_v5.nextPage();

		});	
    },

    resize_input_text: function (){
		var input=$('#fb5-page-number');
		var input_two=$('#fb5-page-number-two');
		var btn=$('div#fb5-right button');
		input.css('width',GOTOPAGE_WIDTH);
		//input_two.css('width',GOTOPAGE_WIDTH);
		///input.css('padding-right',btn.width()+2);
	}, 

    isiPhone: function (){
       return ( (navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPad") != -1)  );
    },

	arrows: function() {
		$('.fb5-nav-arrow.prev,.fb5-arrow-left').click(function() {
			//$('#fb5-book').turn('previous');
			
            Book_v5.prevPage();
            Book_v5.resize_page()
		});
		$('.fb5-nav-arrow.next,.fb5-arrow-right').click(function() {
			//$('#fb5-book').turn('next');
            Book_v5.nextPage();
            Book_v5.resize_page()
		});
	},
    
    nextPage:function(){
      
	  $('#fb5-book').turn('next');
	  /*
      var current=$('#fb5-book').turn('page');
      if( current%2==0){
		 var page=current+2
      }else{
         var page=current+1 
      }      

      if(RTL=='true'){
		setPage( new Number(page).rtl() )   
	  }else{
		setPage(page);   
	  }
	  /*/
  
    
    },
    
    prevPage:function(){
    
	  $('#fb5-book').turn('previous');
	  
	  /*
      var current=$('#fb5-book').turn('page');
      if(current==1) {return;}
      if( current%2==0){
         var page=current-1;
      }else{
         var page=current-2;
      }
	  
	  if(RTL=='true'){
		setPage( new Number(page).rtl() )   
	  }else{
		setPage(page);   
	  }
	  /*/
	  
    
    },
	
	setAutoWidthSlider:function(){
			
		var summary = 0;
		$('#fb5-slider li').each(function() {
			var li_width = $(this).outerWidth();		
			summary += li_width;			
		})	
	    summary+=10;  //bug for firefox aln IE
		
		$('#fb5-slider').css('width', summary);
		this.width_slider=summary;
		return this.width_slider
		
	},

	all_pages: function() {
        
		//remove corner
		Book_v5.corner_change(true);     
		
		//lazy loading for thumbs
		if( Book_v5.getConfig('lazy_loading_thumbs')=="true" && Book_v5.getConfig('pdf_type')!="js" ){
					if(!this.load_one_thumbs){
						
							$('#fb5-all-pages li img').each(function(index, element) { 
											
									var el=$(element);                            
									var src=el.attr('data-src');		
													
									if( el.attr('src')==undefined  ){
									
											setTimeout( function(){
																		
													$('<img>').attr('src',src).load(function(){	
														el.css('opacity',0).animate({'opacity':1});
														el.attr('src',src);
														Book_v5.setAutoWidthSlider()
													});				
											
											},index*200)				
									}
							});	
					        this.load_one_thumbs=1;
					}
		}
		
		///load using PDF.js
		if( Book_v5.getConfig('pdf_type')=="js"  ){
					
			if(!this.load_one_thumbs2){	
				
					//for( var i=1;i<=Book_v5.pdf_length;i++){
						  var i=1;
						  var inter_thumb=setInterval( function(){
				
							  Book_v5.renderThumb(i);
							  i++;
							  Book_v5.setAutoWidthSlider()
							  
							  if(i>Book_v5.pdf_length){
								 clearInterval(inter_thumb)  
							  }
							  
						  },i*200);
					
					//}
					
					
			this.load_one_thumbs2=1;		
			}
		}
			 
        ///height thumbs
        var cont_thumbs=$('#fb5-all-pages .fb5-container-pages');
        var area_height=$('#fb5').height()-this.toolsHeight;
        var height_container=area_height*80/100;
        if(height_container>225){
          height_container=225;
        }
        cont_thumbs.css('height',height_container+'px');
        //position thumbs
        var _top=( (area_height/2) -  ( (cont_thumbs.outerHeight())/2   )  )
        cont_thumbs.css('top',_top+'px');
     
		
		var self = this;
		Book_v5.setAutoWidthSlider();	
		
				
	
		$("#fb5-menu-holder").mousemove(function(e) {
		
		///////////////////////////////////////////
	                     	
			if ( $(this).width() < $("#fb5-slider").width() ) {
	     		var distance = e.pageX - $(this).offset().left;
				var percentage = distance / $(this).width();
				var targetX = -Math.round(($("#fb5-slider").width() - $(this).width()) * percentage);
	    		$('#fb5-slider').animate({left: [targetX+"px",'easeOutCubic']  }, { queue:false, duration: 200 });
			}
		});

        //////////////////////SWIPE
        if(self.events_thumbs!=1){
        $('#fb5-all-pages .fb5-container-pages').bind("touchstart", function(e) {
               
			  
			   
               $('#fb5-slider').stop();
               
               //time
               self.time_start=new Date().getTime();
               self.time_move_old=self.time_start;
               
               //road
			   self.x_start = e.originalEvent.targetTouches[0].pageX;
			   self.x_move=undefined;
               self.x_move_old=self.x_start;
			   
			   //remove default action
		       e.preventDefault(e); 
			   
		});
        
        
				
        $('#fb5-all-pages .fb5-container-pages').bind("touchmove", function(e) {
		       		
   			   	
                //current round and time
                self.x_move = e.originalEvent.targetTouches[0].pageX;  
                self.time_move=new Date().getTime();
                                        
                //time - delta
                self.delta_t=new Date().getTime()-self.time_move_old;
                self.time_move_old=new Date().getTime();                
                                        
                //round- delta
                self.delta_s=self.x_move-self.x_move_old;
                self.x_move_old=self.x_move;
                    
                //set position thumbs
                self.current_x=parseInt( $('#fb5-slider').css('left') ); 
                var new_position=self.current_x+self.delta_s;
                if(new_position>0){ new_position=0 }   
                var minX=-Book_v5.width_slider+WINDOW_WIDTH;
                if(new_position<minX ){new_position=minX}
                $('#fb5-slider').css({left:new_position});
              
                //remove default action
                e.preventDefault(e);       
                
                         
		 });
         
         $('#fb5-all-pages .fb5-container-pages li').bind("touchend", function(e) {   
              			   			   
               //calculation speed                 
               var v=self.delta_s/self.delta_t;
               var s= ( WINDOW_WIDTH*0.25 )*v; 
               var t=Math.abs(s/v);
            
               //set position thumbs
               var new_position=self.current_x+s
               if(new_position>0){new_position=0}   
               var minX=-Book_v5.width_slider+WINDOW_WIDTH;
               if(new_position<minX ){new_position=minX } 
             
               if( Math.abs( self.delta_s ) > 5){
                 
				 
          		 $('#fb5-slider').animate({ left:[new_position+"px","easeOutCubic"]  },t); 
				    
				              
               }			    
			   				
			   //redirect to page	     
			   if( self.x_move==undefined ){
			         var page_index = $(this).attr('class');
			         var tmp = parseInt(page_index);		
			         setPage(tmp)
					 setTimeout(function(){					   
					    close_overlay();
				     },200);
			    }
						   
              //e.preventDefault(e);
 
		});		
        //////////////////////end SWIPE
        self.events_thumbs=1;
        }        
		
        
		////redirect to click thumbs ( not work in IPhone )
		if ( !Book_v5.isiPhone() ) {
			$('#fb5-slider li').bind('click',function() {
				self.x_start=null;
				self.x_move=null;
				$('#fb5-slider').stop();
				var page_index = $(this).attr('class');
				var tmp = parseInt(page_index);
				
				close_overlay();				
				
				setTimeout(function(){					  
					setPage(tmp); 
				},200);
	
			})
		}

		$(document).on('click',function(e) {
			var target = $(e.target);
			if ( target.hasClass('fb5-overlay') ) close_overlay();
		});
        
       
	
	},

	book_grab: function() {
		$('#fb5-container-book').css('cursor', '-webkit-grab');
		$('#fb5-container-book').css('cursor', '-moz-grab');
	},

	book_grabbing: function() {
		$('#fb5-container-book').css('cursor', '-webkit-grabbing');
		$('#fb5-container-book').css('cursor', '-moz-grabbing');
	},
    
    book_area: function(w_,h_,tools_){
		
		var width_book=$('#fb5-ajax').width();
		
		if( w_ ){
		   	WIDTH_BOOK=Number(w_)*2;
		}
		
		if( h_ ){
		   	HEIGHT_BOOK=Number(h_);
		}
		
		if( tools_ ){
		   	this.toolsHeight=Number(tools_);
		}
		
        var width_book=$('#fb5-ajax').width();
                
        ///if(IS_AS_TEMPLATE==true){
           // var height=$(window).height()+"px";
        //}else{
            //var height=(width_book*HEIGHT_BOOK/WIDTH_BOOK)+this.toolsHeight+"px";
        ///}
        
        if( $('#fb5-ajax').attr('data-template')=="true" || $('#fb5-ajax').hasClass('fb5-fullbrowser') || $('#fb5-ajax').hasClass('fullScreen')  ){
           //var height=$(window).height()+"px";
		   $('#fb5-ajax').removeAttr('style');
        }else{           
            var height=(width_book*HEIGHT_BOOK/WIDTH_BOOK)+this.toolsHeight+"px";  
		    $("#fb5-ajax").css('height',height); 
		}    
          
       
		
	},
    
    ///current width book
    widthBook:  function(){		 
			return $('#fb5-container-book').width();  
	},
    
    //current height book
    heightBook: function(){
         return $('#fb5-container-book').height();    
    },

	book_position: function() {
    
  
        //old 
		var book_height	= this.heightBook();
		var book_width	= this.widthBook();
		
		var half_height	= (  (book_height/2)+this.toolsHeight/2   );
		var half_width	= (  book_width/2 );
        
        var x=$('#fb5').width()/2-half_width;
        var y=this.autoMarginT()+this.toolsHeight                  //$('#fb5').height()/2-half_height;
		$('#fb5-container-book').css({ left: x, top:y });
		
		
		Book_v5.dragdrop_init();
		
		/*footer position/*/
		//var new_y=book_height+this.autoMarginT()+this.autoMarginB();
		//$("#fb5-footer").css({top:new_y+'px'});
		//$("#fb5").css('height',new_y+this.toolsHeight);
		
		
		////////new
		/*
		var width_book=Book_v5.widthBook()
		var height_book=Book_v5.heightBook();
		
		var offset=$('#fb5-container-book').offset();
		
		var point_x=width_book/2
		var point_y=height_book/2;
		
		var x=$('#fb5').width()/2-point_x
        var y=65                  
		$('#fb5-container-book').css({ left: x, top:y });
		
		
		console.log(point_x+"  /   ");
		
		/*/
        
	},
    
    touchstart_book:function(e){
    
       this.book_x = e.originalEvent.touches[0].pageX;
       this.book_y = e.originalEvent.touches[0].pageY;
         
    },
    
    touchmove_book:function(e){
    
        //delta x
        this.book_x_delta=e.originalEvent.touches[0].pageX-this.book_x;
        this.book_x=e.originalEvent.touches[0].pageX;
        
        //delta y
        this.book_y_delta=e.originalEvent.touches[0].pageY-this.book_y;
        this.book_y=e.originalEvent.touches[0].pageY;
        
                
        var current_x= parseInt(  $('#fb5-container-book').css('left')  )
        var current_y= parseInt(  $('#fb5-container-book').css('top')  )
        
        var x=current_x+this.book_x_delta;
        var y=current_y+this.book_y_delta;
        $('#fb5-container-book').css( {left:x,top:y } ); 
        
        e.preventDefault();
        
        
        
        //var t=e.originalEvent.changedTouches[0].pageX
        
        //alert("move");
    
    },
    touchend_book:function(e){
    
    
        
           
    },    

	drag: function(e) {
		
		var el = $(this);
		var dragged = el.addClass('draggable');

		$('#fb5-container-book').unbind('mousemove');
		$('#fb5-container-book').bind('mousemove', Book_v5.book_grabbing);
        

        var d_h = dragged.outerHeight();
        var d_w = dragged.outerWidth();
        var pos_y = dragged.offset().top + d_h - e.pageY;
        var pos_x = dragged.offset().left + d_w - e.pageX;
        
		dragged.parents().unbind("mousemove");
        dragged.parents().bind("mousemove", function(e) {
            $('.draggable').offset({
                top:e.pageY + pos_y - d_h,
                left:e.pageX + pos_x - d_w
            });
        });
        e.preventDefault();
	},
	
	drop: function() {
		Book_v5.book_grab();
		$('#fb5-container-book').bind('mousemove', Book_v5.book_grab);
		$('#fb5-container-book').removeClass('draggable');
	},
    
    checkScrollBook: function () {
      
      var vertical=$('#fb5-book').height() > $("#fb5").height() - this.toolsHeight;
	  var horizontal=$('#fb5-book').width() > $("#fb5").width() - (this.arrow_width*2);
      
 	
	  if ( vertical || horizontal ) {
		higherThanWindow = true;
      } else {
		higherThanWindow = false;
	  }
	   return higherThanWindow;
    },

	dragdrop_init: function() {
		this.checkScrollBook();

		if ( higherThanWindow == false ) {
            //mobile ( disable this if use pinchZoom )		
            $('#fb5-container-book').unbind('touchstart', Book_v5.touchstart_book);
            $('#fb5-container-book').unbind('touchmove', Book_v5.touchmove_book);
            $('#fb5-container-book').unbind('touchend', Book_v5.touchend_book); 
			   
            
        
			$('#fb5-container-book').unbind('mousedown', Book_v5.drag);
			$('#fb5-container-book').unbind('mouseup', Book_v5.drop);
			$('#fb5-container-book').unbind('mousemove', Book_v5.book_grab);
			$('#fb5-container-book').unbind('mousemove', Book_v5.book_grabbing);
			$('#fb5-container-book').css('cursor', 'default');
		} else {
            //mobile   ( disable this if use pinchZoom )			
            $('#fb5-container-book').bind('touchstart', Book_v5.touchstart_book);
            $('#fb5-container-book').bind('touchmove', Book_v5.touchmove_book);
            $('#fb5-container-book').bind('touchend', Book_v5.touchend_book);
            
			
			$('#fb5-container-book').bind('mousedown', Book_v5.drag);
			$('#fb5-container-book').bind('mouseup', Book_v5.drop);
			$('#fb5-container-book').bind('mousemove', Book_v5.book_grab);
            Book_v5.book_grab();
			
		}
		Book_v5.resize_page();
	},
	
	scaleStart: function() {
		//if ( this.on_start == true ) {
			this.checkScrollBook();			
			//this.on_start = false;
		//}
	},
	
	setPointZoomDefault:function(){
		this.setPointZoom("C","T")		
	},
	
	setPointZoom:function(x_,y_){
		
	   this.point_zoom={};
	   this.point_zoom.x=x_;
	   this.point_zoom.y=y_;
		
	},
	
	getPointZoom:function(){
		var x,y
		
		
		//remove error in browser chrome console
		if(!this.point_zoom ){
		   return;	
		}
		
		///point X
		if(this.point_zoom.x=="C"){
		   x=Book_v5.widthBook()/2;	
		}else if(this.point_zoom.x=="R"){
		   x=Book_v5.widthBook();
		}else if(this.point_zoom.x=="L"){
		   x=0
		}else{
		    x=	this.point_zoom.x
		}
		
		//point Y
		if(this.point_zoom.y=="C"){
		   y=Book_v5.heightBook()/2;	
		}else if(this.point_zoom.y=="T"){
		   y=0;
		}else if(this.point_zoom.y=="D"){
		   y=Book_v5.heightBook()
		}else{
		   y=	this.point_zoom.y
		}
		
		
		return {x:x,y:y}
		
	},
	    
    
    setSize:function(w_,h_){
    
	   //remove error in browser chrome console
	   if(!this.point_zoom ){
		   return;	
	   }
	
       //get point zoom
	   var point_zoom=this.getPointZoom();
	  	
	   //point before
	   var point_before={}
	   var offset=$('#fb5-container-book').offset();
	   point_before.x=point_zoom.x+offset.left
	   point_before.y=point_zoom.y+offset.top;
	  	   
	   //scale
	   var width_before=Book_v5.widthBook()
	   $('#fb5-container-book').css({ width:w_, height:h_ });
	   $('#fb5-book').turn('size',w_,h_);
	   var width_after=Book_v5.widthBook()
	   var scale=width_after/width_before;
	   	   	   
	   //point after
	   var offset=$('#fb5-container-book').offset();
	   var point_after={}
	   point_after.x=(point_zoom.x*scale)+offset.left
	   point_after.y=(point_zoom.y*scale)+offset.top
	   	   	      
	   //delta point
	   var delta_point_x=point_after.x-point_before.x
	   var delta_point_y=point_after.y-point_before.y	   
	      
	   //corect position	  
	   var x=-delta_point_x
       var y=-delta_point_y                 
	   $('#fb5-container-book').css({ left:"+="+x, top:"+="+y });
	   
	   //correct point after zoom
	   Book_v5.setPointZoom((point_zoom.x*scale), (point_zoom.y*scale));
    
    },
    
    zoomTo:function(zoom_){
       
     
	   	
	  
	  this.zoom=zoom_;
       
	     
       var new_width=(WIDTH_BOOK*this.zoom);
       var new_height=(HEIGHT_BOOK*this.zoom);
       
	  
      
       this.setSize(new_width,new_height);
       this.scale_arrows()
	   
	  
	  
       
       //this.book_position();
       Book_v5.dragdrop_init();
       Book_v5.resize_page()
      
       
    },
    
    zoomOriginal:function(){
    
        this.zoomTo(1);
             
    },   
   
    scale_arrows:function(){
       
       var HEIGHT_ARROW=136;
       var WIDTH_ARROW=34;
       
       var height_arrow=this.heightBook()*0.45;
       if( height_arrow > 136 ){
         height_arrow=136;
       }
        
       
       var width_arrow= (height_arrow*WIDTH_ARROW)/HEIGHT_ARROW;
      
       this.zoom_arrows=height_arrow/HEIGHT_ARROW;   
         
           				$('.fb5-nav-arrow').css({'transform':'scale('+this.zoom_arrows+')','-ms-transform':'scale('+this.zoom_arrows+')','-webkit-transform':'scale('+this.zoom_arrows+')'});    
    },
    
	zoomAuto: function() {
				
		Book_v5.scaleStart();	
        
          
        ////resize one 
        var zoom=this.getAutoZoomBook(0);   
        this.zoomTo( zoom  ) 
          
		////resize two (with arrow)
        this.scale_arrows();
        var arrow_width=0//$('.fb5-nav-arrow').width()*this.zoom_arrows; 
        this.arrow_width=arrow_width;
        var zoom=this.getAutoZoomBook(arrow_width*2);
        //calculate optimal zoom
		/*
        zoom=Math.round(zoom * 100) / 100
        var percent=zoom*100;
        if(percent%2!=0){
          zoom=zoom-0.01;
        }
		/*/
   		this.zoomTo( zoom   )

		Book_v5.resize_page()
      
	},
         
    getAutoZoomBook: function(arrow_width_){
       
        var book_width=this.widthBook();
		var book_height=this.heightBook();
		var screen_width	=  $("#fb5").width()-  ( this.autoMarginL()+this.autoMarginR() + (arrow_width_) );
		var screen_height	= $("#fb5").height()-this.toolsHeight-( this.autoMarginT()+this.autoMarginB()  )
 
		
		if(screen_width>WIDTH_BOOK){
		  screen_width=WIDTH_BOOK	
		}
		
		if(screen_height>HEIGHT_BOOK){
		  screen_height=HEIGHT_BOOK	
		}
		
		
		var scaleW=screen_width/book_width;
		var scaleH=screen_height/book_height;
		
		var scale=Math.min(scaleW,scaleH)	
		var new_width		= book_width*scale;
		var new_height		= book_height*scale;
        var auto_zoom= new_width/WIDTH_BOOK
        return auto_zoom;
    
    },

	zoomIn: function() {
       var zoom=this.zoom;  
       
        
       this.zoomTo(zoom+ZOOM_STEP  );
	},
	
	zoomOut: function() {
		
	   this.zoomTo( this.zoom-ZOOM_STEP );
	   
	    if( Book_v5.checkScrollBook(true)==false){
		   Book_v5.zoomAuto();
		   Book_v5.book_position(); 
		   	   
	   }
	},
    
    resize_page: function (){
		
         /* RESIZE PAGE IN FLIPBOOK  /*/
         //resize class .fb5-page-book
         var page_width=this.widthBook()/2;
         var width_current_page=(page_width)
         var width_orginal_page=  ( WIDTH_BOOK/2 )     
         var zoom= (width_current_page / width_orginal_page);
         $('.fb5-cont-page-book,.links').css({'transform':'scale('+zoom+')','-ms-transform':'scale('+zoom+')','-webkit-transform':'scale('+zoom+')'});
         ///center class .fb5-page-book
         var paddingL=(this.widthBook()*this.paddingL)/zoom;
		 var paddingR=(this.widthBook()*this.paddingR)/zoom;
         var paddingT=(this.widthBook()*this.paddingT)/zoom;
		 
         $('#fb5 .odd.turn-page .fb5-page-book').css({'left':paddingL+'px','top':paddingT+'px'});
		 $('#fb5 .even.turn-page .fb5-page-book').css({'left':paddingR+'px','top':paddingT+'px'});
            
         /* RESIZE ABOUT IN FLIPBOOK  /*/
         $('#fb5-about').css({'transform':'scale('+zoom+')','-ms-transform':'scale('+zoom+')','-webkit-transform':'scale('+zoom+')'});
         //padding top
         var padding_top=(this.heightBook()*0.05);
         $('#fb5-about').css('top',padding_top+'px');
         //height
         var height=(this.heightBook()-( padding_top*2) )/zoom;
         $('#fb5-about').css('height',height+'px');
         //width
         var width=(  (this.widthBook()/2)-( this.widthBook()*0.05  ) )/zoom;
         $('#fb5-about').css('width',width+'px');
		 
		 
		 //CENTER VERTICAL FOR HOME PAGE
		 //var posY=$('.fb5-page-book').height()/2 - $('#fb5 #fb5-cover ul').innerHeight()/2;
		 //$('#fb5 #fb5-cover ul').css('top',posY+'px');
		 
		 
	},
    
    resize_font:  function($size_original_,path_){
		var w=this.widthBook();
		var size= ($size_original_*w)/WIDTH_BOOK;
		var new_size=Math.round(parseInt(size))+"px";
		///$(path_).css('font-size',new_size);
		///$(path_).css('line-height',new_size);
        $(path_).css('font-size',$size_original_+"px");
		$(path_).css('line-height',$size_original_+"px");
	}
}


/* =  Navigation
--------------------------*/

var Navigation_v5 = {
	
	tooltip: function() {
    
    
		$('.fb5-menu li').filter(':not(.fb5-goto)').each(function() {
			var description = $('a', this).attr('title');
			var tooltip = '<span class="fb5-tooltip">'+description+'<b></b></span>';
			$('a', this).removeAttr("title");
			$(this).append(tooltip);
		});
		
		$('.fb5-menu li').mousemove(function(e) {
			         
            var tooltip=$('.fb5-tooltip', this);
			var offset = $(this).offset(); 
            var relY = e.pageY - offset.top;
            var x2= e.pageX-$('#fb5').offset().left+tooltip.width()  
            var width_area=$('#fb5').width()
            
            if( (x2+10)>width_area){
                var orient="right";
            }else{
            	var orient="left";
            }
            
            if(orient=="left"){
     			var relX = e.pageX - offset.left-tooltip.width()/2;
                $('#fb5 .fb5-tooltip b').css('left','6px')
            }else{
                var relX = e.pageX - offset.left-tooltip.width()-5;
                $('#fb5 .fb5-tooltip b').css('left',(tooltip.width()+6)+'px') 
            }			            
            
            //$('.fb5-tooltip', this).html( x2+" > "+width_area  );
			$('.fb5-tooltip', this).css({ left: relX, top: relY+38 });
			
		})
		
		$('.fb5-menu li').hover(function() { 
			$('.fb5-tooltip').stop();
			$('.fb5-tooltip', this).fadeIn();
		}, function() {
			$('.fb5-tooltip').hide();
		});
		
		Book_v5.resize_page()

	},


    ///event mouse down in book 
	book_mouse_down: function(){
   			$('#fb5-about').css('z-index',5);
			//Book_v5.resize_page();
	},
	
	book_mouse_up: function(e){
		 var offset = $(this).offset();
		 var relativeX = (e.pageX - offset.left);
         if( relativeX > ( WIDTH_BOOK / 2 )  ){
			//$('#fb5-about').css('z-index',11); 
		 }
	    
	},
	
	full_screen:function(){
		
		  $('#fb5-ajax').fullScreen({
         
         'callback': function(isFullScreen){         
             //Book_v5.book_area();
             //Book_v5.zoomAuto();
             //Book_v5.center_icon();
		     //Book_v5.center_icon();
		     $(window).trigger('orientationchange');
         
             if(isFullScreen){
                			
             }else{
               
             }
        
          }
         });
		
		
	},
	
	
	init: function() {

		// Double Click
        if(ZOOM_DOUBLE_CLICK_ENABLED=="true"){
		$('#fb5-book').dblclick(function(e) {
			           
            if(Book_v5.checkScrollBook()==false){ //zoom
                 
								var offset=$('#fb5-container-book').offset();
								var mouse_x=e.pageX-offset.left;
								var mouse_y=e.pageY-offset.top;
								Book_v5.setPointZoom(mouse_x,mouse_y);
														
								var new_zoom=ZOOM_DOUBLE_CLICK+Book_v5.zoom
								if( new_zoom > 1 ){
									new_zoom=1; 
								}
								Book_v5.zoomTo(new_zoom)
            }else{
				 Book_v5.setPointZoomDefault();	 
						   Book_v5.zoomAuto();
						   Book_v5.book_position();
						   $('#fb5-container-book').css('cursor', 'default');
            }
		});
        }
		
		
	//focus for page manager
	var page_manager=$('#fb5-page-number');
	page_manager.focus(function(e) {
		var target=$(e.currentTarget);
		target.data('current',target.val());
		target.val('')
		target.addClass('focus_input');
		
        
    });
	page_manager.focusout(function(e) {
		var target=$(e.currentTarget);
		var old=target.data('current');
		target.removeClass('focus_input');
		if( target.val() ==''){
		  target.val(old);	
		}
    });	
		


    //full screen
    $('.fb5-fullscreen').on('click', function() {
		
     			
     $('.fb5-tooltip').hide();
   
     Navigation_v5.full_screen();
     
   
     //e.preventDefault();
            
	  });
         
		 
		//download
		
		 
		 
		 $('.fb5-download').on('click', function(event) {
     	 
		 
		  
		 
		 
		  //$.address.update();
		 // event.preventDefault();
		  
		}); 

	    // Home 
	    $('.fb5-home').on('click', function() {     	  
		  setPageTurn(1);
	      //setAddress('book5-1');		  
		});
	
		// Zoom Original
		$('.fb5-zoom-original').click(function() {
			

            Book_v5.zoomOriginal();
      
			
		});
	
		// Zoom Auto
		$('.fb5-zoom-auto').on('click', function() {
			Book_v5.zoomAuto();
			Book_v5.book_position();
		});

		// Zoom In
		$('.fb5-zoom-in').on('click', function() {
			
				Book_v5.zoomIn();
				
							
		});
	
		// Zoom Out
		$('.fb5-zoom-out').on('click', function() {
			
				Book_v5.zoomOut();
				
		});

		// All Pages
		$('.fb5-show-all').on('click', function() {
			$('#fb5-all-pages').
				addClass('active').
				css('opacity', 0).
				animate({ opacity: 1 }, 1000);
			Book_v5.all_pages();
			return false;
		})
		
		// Goto Page
		$('#fb5-page-number').keydown(function(e) {
			if (e.keyCode == 13) {
               setPage( $('#fb5-page-number').val() );
            }
		});
		
		$('.fb5-goto button').click(function(e) {
            setPage( $('#fb5-page-number').val() );
		});


		// Contact
		$('.contact').click(function() {
			$('#fb5-contact').addClass('active').animate({ opacity: 1 }, 1000);
			contact_form();
			clear_on_focus();
			return false;
		})
		
		//change z-index in about
		$('#fb5-book').bind('mousedown',this.book_mouse_down);
		$('#fb5-book').bind('mouseup',this.book_mouse_up);
		if (Book_v5.isiPhone()) {//for IPhone		
		$('#fb5-book').bind('touchstart',this.book_mouse_down);
		$('#fb5-book').bind('touchend',this.book_mouse_up);
		}

		//show tooltip for icon
		if ( !Book_v5.isiPhone() && TOOL_TIP_VISIBLE=="true" ) {
			this.tooltip();
		}
	}
}

 
/* = CONTACT FORM
--------------------------*/

function clear_on_focus() {
	$('input[type="text"], input[type="password"], textarea').each( function() {
		var startValue = $(this).val();
		$.data(this, "startValue", startValue);	
        this.value=startValue;
	})

	$('input[type="text"], input[type="password"], textarea').focus(function() {
		var startValue = $.data(this, "startValue");		
		if ( this.value == startValue ) {
			this.value = '';
		}
	});
	$('input[type="text"], input[type="password"], textarea').blur(function() {
        var startValue = $.data(this, "startValue");
		if ( this.value == '' ) {
			this.value = startValue;
		}
	})
}


function close_overlay() {
	$('.fb5-overlay').removeClass('active');
	setTimeout(function(){
	Book_v5.corner_change(false);
	},1000);
}


function contact_form() {

	$('#fb5-contact .req').each(function() {
		var startValue = $(this).val();
		$.data(this, "startValue", startValue);
	});

	$('#fb5-contact button[type="submit"]').click(function() {

		$('#fb5-contact .req').removeClass('fb5-error');
		$('#fb5-contact button').fadeOut('fast');

		var isError = 0;

		// Get the data from the form
		var name	= $('#fb5-contact #fb5-form-name').val();
		var email	= $('#fb5-contact #fb5-form-email').val();
		var message	= $('#fb5-contact #fb5-form-message').val();

		// Validate the data
		$('#fb5-contact .req').each(function() {
			var startValue = jQuery.data(this, "startValue");
			if ( ($(this).val() == '') || (this.value == startValue) ) {
				$(this).addClass('fb5-error');
				isError = 1;
			}
		});

		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if (reg.test(email)==false) {
			$('#fb5-contact #fb5-form-email').addClass('fb5-error');
			isError=1;
		}

		// Terminate the script if an error is found
		if (isError == 1) {
			$('#fb5-contact button').fadeIn('fast');
			return false;
		}

		$.ajaxSetup ({
			cache: false
		});

        var _email=Book_v5.getConfig('email_form'); 
		var dataString = 'name='+ name + '&email=' + email + '&message=' + message+'&_email='+_email;  
		
		
		var url="php/submit-form-ajax.php"
		
		
		$.ajax({
			type: "POST",
			url: url,
			data: dataString,
			success: function(msg) {
				
				// Check to see if the mail was successfully sent
				if (msg == 'Mail sent') {
					$("#fb5-contact fieldset").hide();
					$("#fb5-contact fieldset.fb5-thanks").show();
					
					setTimeout(function() {
						close_overlay();
					}, 5000);
					
				} else {
					$('#fb5-contact button').fadeIn('fast');
					alert('The problem with sending it, please try again!');
				}
			},

			error: function(ob,errStr) {
				alert('The problem with sending it, please try again.');
			}
		});
		return false;
	});

	$('#fb5-contact .fb5-close').click(function() {
		close_overlay();
	})
}



/*
 * $ Easing v1.3 - http://gsgd.co.uk/sandbox/$/easing/
 *
 * Uses the built in easing capabilities added In $ 1.1
 * to offer multiple easing options
*/

$.easing["jswing"]=$.easing["swing"];$.extend($.easing,{def:"easeOutQuad",swing:function(a,b,c,d,e){return $.easing[$.easing.def](a,b,c,d,e)},easeInQuad:function(a,b,c,d,e){return d*(b/=e)*b+c},easeOutQuad:function(a,b,c,d,e){return-d*(b/=e)*(b-2)+c},easeInOutQuad:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b+c;return-d/2*(--b*(b-2)-1)+c},easeInCubic:function(a,b,c,d,e){return d*(b/=e)*b*b+c},easeOutCubic:function(a,b,c,d,e){return d*((b=b/e-1)*b*b+1)+c},easeInOutCubic:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b+c;return d/2*((b-=2)*b*b+2)+c},easeInQuart:function(a,b,c,d,e){return d*(b/=e)*b*b*b+c},easeOutQuart:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c},easeInOutQuart:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b*b+c;return-d/2*((b-=2)*b*b*b-2)+c},easeInQuint:function(a,b,c,d,e){return d*(b/=e)*b*b*b*b+c},easeOutQuint:function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c},easeInOutQuint:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b*b*b+c;return d/2*((b-=2)*b*b*b*b+2)+c},easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeOutSine:function(a,b,c,d,e){return d*Math.sin(b/e*(Math.PI/2))+c},easeInOutSine:function(a,b,c,d,e){return-d/2*(Math.cos(Math.PI*b/e)-1)+c},easeInExpo:function(a,b,c,d,e){return b==0?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b==e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c},easeInOutExpo:function(a,b,c,d,e){if(b==0)return c;if(b==e)return c+d;if((b/=e/2)<1)return d/2*Math.pow(2,10*(b-1))+c;return d/2*(-Math.pow(2,-10*--b)+2)+c},easeInCirc:function(a,b,c,d,e){return-d*(Math.sqrt(1-(b/=e)*b)-1)+c},easeOutCirc:function(a,b,c,d,e){return d*Math.sqrt(1-(b=b/e-1)*b)+c},easeInOutCirc:function(a,b,c,d,e){if((b/=e/2)<1)return-d/2*(Math.sqrt(1-b*b)-1)+c;return d/2*(Math.sqrt(1-(b-=2)*b)+1)+c},easeInElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e)==1)return c+d;if(!g)g=e*.3;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return-(h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g))+c},easeOutElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e)==1)return c+d;if(!g)g=e*.3;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*b)*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInOutElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e/2)==2)return c+d;if(!g)g=e*.3*1.5;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);if(b<1)return-.5*h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+c;return h*Math.pow(2,-10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)*.5+d+c},easeInBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;return d*(b/=e)*b*((f+1)*b-f)+c},easeOutBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;return d*((b=b/e-1)*b*((f+1)*b+f)+1)+c},easeInOutBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;if((b/=e/2)<1)return d/2*b*b*(((f*=1.525)+1)*b-f)+c;return d/2*((b-=2)*b*(((f*=1.525)+1)*b+f)+2)+c},easeInBounce:function(a,b,c,d,e){return d-$.easing.easeOutBounce(a,e-b,0,d,e)+c},easeOutBounce:function(a,b,c,d,e){if((b/=e)<1/2.75){return d*7.5625*b*b+c}else if(b<2/2.75){return d*(7.5625*(b-=1.5/2.75)*b+.75)+c}else if(b<2.5/2.75){return d*(7.5625*(b-=2.25/2.75)*b+.9375)+c}else{return d*(7.5625*(b-=2.625/2.75)*b+.984375)+c}},easeInOutBounce:function(a,b,c,d,e){if(b<e/2)return $.easing.easeInBounce(a,b*2,0,d,e)*.5+c;return $.easing.easeOutBounce(a,b*2-e,0,d,e)*.5+d*.5+c}})



})(jQuery)



 
