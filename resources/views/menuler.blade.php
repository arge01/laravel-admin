

<html>

        <head>

          <meta content="text/html; charset=utf-8" http-equiv="Content-Type">

         

          <!-- viewport -->

          <meta content="width=device-width,initial-scale=1" name="viewport">

          

          <!-- title -->

          <title>KAHVELAND | MENÜLER</title> 

              

          <!-- add css style -->

          <link type="text/css" href="{{config('app.url').'jquery_newspaper_flipbook/'}}css/style.css" rel="stylesheet">

          <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Play:400,700">

          <link type="text/css" href="{{config('app.url').'jquery_newspaper_flipbook/'}}css/font-awesome.min.css" rel="stylesheet">

          

          <!-- add js code -->

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/jquery.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/jquery_no_conflict.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/turn.js"></script>              

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/wait.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/jquery.mousewheel.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/jquery.fullscreen.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/jquery.address-1.6.min.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/pdf.js"></script>

          <script src="{{config('app.url').'jquery_newspaper_flipbook/'}}js/onload.js"></script>

      

      

          <style>

          html, body {

              margin: 0;

              padding: 0;

              overflow:auto !important;

          }

          </style> 

            

        </head> 

      <body>

        

      

      

      <!-- begin flipbook  -->

      <div id="fb5-ajax" data-cat="your_book_name" data-template="true"> 			

      

          <!-- BACKGROUND FLIPBOOK -->

          <div class="fb5-bcg-book"></div>     

              

          <!-- BEGIN STRUCTURE HTML FLIPBOOK -->      

          <div class="fb5" id="fb5">      

              

              <!-- CONFIGURATION BOOK -->

              <section id="config">

                <ul>

                  <li key="page_width">918</li>               <!-- width for page -->

                  <li key="page_height">1298</li>             <!-- height for page -->

                  <li key="gotopage_width">25</li>            <!-- width for field input goto page -->

                  <li key="zoom_double_click">1</li>          <!-- value zoom after double click -->

                  <li key="zoom_step">0.1</li>				<!-- zoom step ( if click icon zoomIn or zoomOut -->

                  <li key="toolbar_visible">true</li>			<!-- enabled/disabled toolbar -->

                  <li key="tooltip_visible">true</li>			<!-- enabled/disabled tooltip for icon -->

                  <li key="deeplinking_enabled">true</li>   	<!-- enabled/disabled deeplinking -->  

                  <li key="lazy_loading_pages">false</li>		<!-- enabled/disabled lazy loading for pages in flipbook -->

                  <li key="lazy_loading_thumbs">false</li>	<!-- enabled/disabled lazdy loading for thumbs -->

                  <li key="double_click_enabled">true</li> 	<!-- enabled/disabled double click mouse for flipbook -->                 

                  <li key="rtl">false</li>					<!-- enabled/disabled 'right to left' for eastern countries -->

                  <li key="pdf_url"></li>		                <!-- pathway to a pdf file ( the file will be read live ) -->

                  <li key="pdf_scale">1</li>					<!-- to live a pdf file (if you want to have a strong zoom - increase the value) -->

                  <li key="page_mode">double</li>             <!-- value to 'single', 'double', or 'auto' -->

               </ul> 

              </section>

              

              <!-- BEGIN PRELOADER -->

              <div class="fb5-preloader"></div>

              <!-- END PRELOADER -->  

            

              <!-- BEGIN BACK BUTTON -->

              <a href="{{route('menuler')}}" id="fb5-button-back">Geri</a>

              <!-- END BACK BUTTON -->                        

            

              <!-- BEGIN CONTAINER BOOK -->

              <div id="fb5-container-book">

           

                  <!-- BEGIN deep linking -->  

                  <section id="fb5-deeplinking">

                    <ul>

                        @foreach ( $gelen->galerisi as $i => $gal )

                        <li data-address="page{{$i++}}" data-page="{{$i++}}"></li>

                        @endforeach

                    </ul>

                  </section>

                  <!-- END deep linking -->  

                      

                  <!-- BEGIN ABOUT -->

                  <section id="fb5-about">

                  </section>

                  <!-- END ABOUT -->

                  

                  

                  <!-- BEGIN LINKS -->

                  <section id="links">

                  

                          

                 

                 </section>     

                 <!-- END LINKS -->                         

                                            

          

                  <!-- BEGIN PAGES -->

                  <div id="fb5-book">                       

                                           

                    @foreach ( $gelen->galerisi as $i => $gal )          

                    <!-- begin page {{$i++}} -->          

                    <div data-name="{{$i++}}" data-background-image="{{config('app.url').'images/'.$gal->img}}">          

                            

                                <!-- container page book --> 

                                <div class="fb5-cont-page-book">

                                

                                        <!-- gradient for page -->

                                        <div class="fb5-gradient-page"></div>                

                                    

                                        <!-- PDF.js --> 

                                        <canvas id="canv{{$i++}}"></canvas>                                                               

                                        

                                        <!-- description for page --> 

                                        <div class="fb5-page-book">

                                                        

                                        </div> 

                                                

                                

                                </div>

                                <!-- end container page book --> 

                

            

                    </div>

                    <!-- end page {{$i++}} -->

                    @endforeach

                    

                  

                

                    

                  </div>

                  <!-- END PAGES -->

                  

              </div>

              <!-- END CONTAINER BOOK -->

          

              <!-- BEGIN FOOTER -->

              <div id="fb5-footer">

              

                  <div class="fb5-bcg-tools"></div>

                  

                  

                   

                  <a style="margin-top: 50px" id="fb5-logo" target="_blank" href="{{config('app.url')}}">

                      <img style="max-height: 90px" alt="" src="img/logo.png">

                  </a>

                  

                  <div class="fb5-menu" id="fb5-center">

                      <ul>

                      

                          <!-- icon_home -->

                          <li>

                              <a title="show home page" class="fb5-home"><i class="fa fa-home"></i></a>

                          </li>

                                          

                          

                          <!-- icon download -->

                          <li>

                              <a title="download pdf" class="fb5-download" href="images\pdf.pdf"><i class="fa fa-download"></i></a>

                          </li>

                                      

                                  

                          <!-- icon arrow left -->

                          <li>

                              <a title="prev page" class="fb5-arrow-left"><i class="fa fa-chevron-left"></i>

          </a>

                          </li>

                                          

                          

                            <!-- icon arrow right -->

                          <li>

                              <a title="next page" class="fb5-arrow-right"><i class="fa fa-chevron-right"></i>

          </a>

                          </li>

                                          

                          

                          <!-- icon_zoom_in -->                     

                          <li>

                              <a title="zoom in" class="fb5-zoom-in"><i class="fa fa-search-plus"></i></a>

                          </li>

                                                      

                                     

                          

                          <!-- icon_zoom_out -->                 

                          <li>

                              <a title="zoom out" class="fb5-zoom-out"><i class="fa fa-search-minus"></i></a>

                          </li>

                                          

                          

                           <!-- icon_zoom_auto -->

                          <li>

                              <a title="zoom auto" class="fb5-zoom-auto"><i class="fa fa-search"></i></a>

                          </li>

                                          

                                     

                          <!-- icon_allpages -->

                          <li>

                              <a title="show all pages" class="fb5-show-all"><i class="fa fa-list"></i></a>

                          </li>

                                                          

                          

                          <!-- icon fullscreen -->                 

                          <li>

                              <a title="full/normal screen" class="fb5-fullscreen"><i class="fa fa-expand"></i></a>

                          </li>

                                          

                        

                          

                      </ul>

                  </div>

                  

                  <div class="fb5-menu" id="fb5-right">

                      <ul>              

                          <!-- icon page manager -->                 

                          <li class="fb5-goto">

                              <label for="fb5-page-number" id="fb5-label-page-number"></label>

                              <input type="text" id="fb5-page-number" style="width: 25px;"> 

                              <span id="fb5-page-number-two"></span>

                              

                          </li>                

                      </ul>

                  </div>

                  

                  

              

              </div>

              <!-- END FOOTER -->

           

              <!-- BEGIN ALL PAGES -->

              <div id="fb5-all-pages" class="fb5-overlay">

          

                <section class="fb5-container-pages">

          

                  <div id="fb5-menu-holder">

          

                      <ul id="fb5-slider">       	 

                                                  

                            @foreach ( $gelen->galerisi as $i => $gal )    

                            <!-- thumb {{$i++}} -->

                            <li class="{{$i++}}">

                                <img alt="" data-src="{{config('app.url').'images/thump-'.$gal->img}}">

                            

                            </li>

                            @endforeach

          

                      </ul>

                  

                  </div>

          

              </section>

          

             </div>

              <!-- END ALL PAGES -->           

            

              <!-- BEGIN CLOSE LIGHTBOX  -->

              <div id="fb5-close-lightbox">

               <i class="fa fa-times pull-right"></i>

              </div>  

              <!-- END CLOSE LIGHTBOX -->

          

          

          </div>

          <!-- END STRUCTURE HTML FLIPBOOK -->

      

           

      </div>

      <!-- end flipbook -->                                                                                             

      

      <script>
        function detectmob() {
            if( navigator.userAgent.match(/Android/i)
                || navigator.userAgent.match(/webOS/i)
                || navigator.userAgent.match(/iPhone/i)
                || navigator.userAgent.match(/iPad/i)
                || navigator.userAgent.match(/iPod/i)
                || navigator.userAgent.match(/BlackBerry/i)
                || navigator.userAgent.match(/Windows Phone/i)
            ){
                return true;
            }
            else {
                return false;
            }
        }
        if ( detectmob() == true ) {
            window.location.href = "{{route('icerik', $gelen->slug)}}";
        }
      </script>

      

      

      

      

      </body>

      </html>