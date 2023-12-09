<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- HTML5 Shiv -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/layout/js/plugins/html5shiv/html5.js"></script>
	<![endif]-->
	<!-- Quantcast Choice. Consent Manager Tag v2.0 (for TCF 2.0) -->
    <script type="text/javascript" async=true>
    (function() {
      var host = 'analisidomusmedica.it';
      var element = document.createElement('script');
      var firstScript = document.getElementsByTagName('script')[0];
      var url = 'https://quantcast.mgr.consensu.org'
        .concat('/choice/', 'QSFebxDYrTUAS', '/', host, '/choice.js')
      var uspTries = 0;
      var uspTriesLimit = 3;
      element.async = true;
      element.type = 'text/javascript';
      element.src = url;
    
      firstScript.parentNode.insertBefore(element, firstScript);
    
      function makeStub() {
        var TCF_LOCATOR_NAME = '__tcfapiLocator';
        var queue = [];
        var win = window;
        var cmpFrame;
    
        function addFrame() {
          var doc = win.document;
          var otherCMP = !!(win.frames[TCF_LOCATOR_NAME]);
    
          if (!otherCMP) {
            if (doc.body) {
              var iframe = doc.createElement('iframe');
    
              iframe.style.cssText = 'display:none';
              iframe.name = TCF_LOCATOR_NAME;
              doc.body.appendChild(iframe);
            } else {
              setTimeout(addFrame, 5);
            }
          }
          return !otherCMP;
        }
    
        function tcfAPIHandler() {
          var gdprApplies;
          var args = arguments;
    
          if (!args.length) {
            return queue;
          } else if (args[0] === 'setGdprApplies') {
            if (
              args.length > 3 &&
              args[2] === 2 &&
              typeof args[3] === 'boolean'
            ) {
              gdprApplies = args[3];
              if (typeof args[2] === 'function') {
                args[2]('set', true);
              }
            }
          } else if (args[0] === 'ping') {
            var retr = {
              gdprApplies: gdprApplies,
              cmpLoaded: false,
              cmpStatus: 'stub'
            };
    
            if (typeof args[2] === 'function') {
              args[2](retr);
            }
          } else {
            queue.push(args);
          }
        }
    
        function postMessageEventHandler(event) {
          var msgIsString = typeof event.data === 'string';
          var json = {};
    
          try {
            if (msgIsString) {
              json = JSON.parse(event.data);
            } else {
              json = event.data;
            }
          } catch (ignore) {}
    
          var payload = json.__tcfapiCall;
    
          if (payload) {
            window.__tcfapi(
              payload.command,
              payload.version,
              function(retValue, success) {
                var returnMsg = {
                  __tcfapiReturn: {
                    returnValue: retValue,
                    success: success,
                    callId: payload.callId
                  }
                };
                if (msgIsString) {
                  returnMsg = JSON.stringify(returnMsg);
                }
                if (event && event.source && event.source.postMessage) {
                  event.source.postMessage(returnMsg, '*');
                }
              },
              payload.parameter
            );
          }
        }
    
        while (win) {
          try {
            if (win.frames[TCF_LOCATOR_NAME]) {
              cmpFrame = win;
              break;
            }
          } catch (ignore) {}
    
          if (win === window.top) {
            break;
          }
          win = win.parent;
        }
        if (!cmpFrame) {
          addFrame();
          win.__tcfapi = tcfAPIHandler;
          win.addEventListener('message', postMessageEventHandler, false);
        }
      };
    
      makeStub();
    
      var uspStubFunction = function() {
        var arg = arguments;
        if (typeof window.__uspapi !== uspStubFunction) {
          setTimeout(function() {
            if (typeof window.__uspapi !== 'undefined') {
              window.__uspapi.apply(window.__uspapi, arg);
            }
          }, 500);
        }
      };
    
      var checkIfUspIsReady = function() {
        uspTries++;
        if (window.__uspapi === uspStubFunction && uspTries < uspTriesLimit) {
          console.warn('USP is not accessible');
        } else {
          clearInterval(uspInterval);
        }
      };
    
      if (typeof window.__uspapi === 'undefined') {
        window.__uspapi = uspStubFunction;
        var uspInterval = setInterval(checkIfUspIsReady, 6000);
      }
    })();
    </script>
    <!-- End Quantcast Choice. Consent Manager Tag v2.0 (for TCF 2.0) -->
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2BV3ZEVRVM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-2BV3ZEVRVM');
    </script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'mtl_before_header' ); ?>
<header id="header">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-sm-12">
				<div id="logo">
					<?php
					$img_logo  = get_theme_mod( 'regina_lite_img_logo' );
					$text_logo = get_theme_mod( 'regina_lite_text_logo', __( 'Regina Lite', 'regina-lite' ) );
					?>
					<a href="<?php echo esc_url( get_site_url() ); ?>" title="<?php echo esc_attr( $text_logo ); ?>">
						<?php if ( $img_logo ): ?>
							<img src="<?php echo esc_url( $img_logo ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" />
						<?php else: ?>
							<span class="logo-title"><?php echo esc_html( $text_logo ); ?></span>
						<?php endif; ?>
					</a>
				</div><!--#logo-->
				<button class="mobile-nav-btn hidden-lg"><span class="nc-icon-glyph ui-2_menu-bold"></span></button>
			</div><!--.col-lg-3-->
			<div class="col-lg-9 col-sm-12">
				<nav id="navigation">
					<ul class="main-menu">
						<?php
						wp_nav_menu( array(
							'theme_location'  => 'primary',
							'menu'            => '',
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => '',
							'menu_id'         => '',
							'items_wrap'      => '%3$s',
							'walker'          => new MTL_Extended_Menu_Walker(),
							'fallback_cb'     => 'MTL_Extended_Menu_Walker::fallback',
						) );
						?>
						<?php
						$book_appointment_button_label = get_theme_mod( 'regina_lite_book_appointment_button_label', __( 'Book Appointment', 'regina-lite' ) );
						$book_appointment_url          = get_theme_mod( 'regina_lite_contact_bar_bookappointmenturl', '#' );
						?>
						<?php if ( ! empty( $book_appointment_url ) ) { ?>
							<li class="hide-mobile">
								<a href="<?php echo $book_appointment_url; ?>" title="<?php echo esc_attr( $book_appointment_button_label ) ?>">
									<span class="nc-icon-glyph arrows-1_cloud-download-95" style="font-size:1.2em"></span>&nbsp;

									<?php
/*
nc-icon-glyph files_download
nc-icon-glyph arrows-1_cloud-download-95
nc-icon-glyph arrows-2_file-download-89
nc-icon-glyph arrows-2_square-download
nc-icon-outline arrows-1_cloud-download-95
nc-icon-outline arrows-2_file-download-89

nc-icon-glyph shopping_newsletter
nc-icon-glyph education_flask  // provetta
nc-icon-glyph education_microscope
nc-icon-glyph education_molecule
nc-icon-glyph shopping_receipt-list-42  // referto
nc-icon-glyph shopping_receipt-list-43
*/

									?>
									<?php echo esc_attr( $book_appointment_button_label ); ?>
								</a></li>
						<?php } ?>
					</ul>
					<div class="nav-search-box hidden-xs hidden-sm hidden-md hidden-lg">
						<input type="text" placeholder="<?php _e( 'Search', 'regina-lite' ); ?>">
						<button class="search-btn"><span class="nc-icon-outline ui-1_zoom"></span></button>
					</div>
				</nav><!--#navigation-->
			</div><!--.col-lg-9-->
		</div><!--.row-->
	</div><!--.container-->
</header><!--#header-->

<?php
global $wp_customize;
$preloader_enabled = get_theme_mod( 'regina_lite_enable_site_preloader', 1 );

if ( ! isset( $wp_customize ) && $preloader_enabled == 1 ) { ?>

	<!-- Site Preloader -->
	<div id="page-loader">
		<div class="page-loader-inner">
			<div class="loader"></div>
		</div>
	</div>
	<!-- END Site Preloader -->
<?php } ?>