<?php
/**
 *  The template for displaying the Front Page.
 *
 * @package regina-lite
 */
?>
<?php get_header(); ?>
<?php 
function avviso( $messaggio, $expire_date, $start_date = 'now' ) {

	$messageMarkup = ' 
	
		<div class="row">
			<div class="col-lg-2 col-xs-12"></div>	
			<div class="col-lg-8 col-xs-12 covid avviso" style="text-align:center">{{ messaggio }}</div>
			<style>
				.covid {
					background-color:orange;
					color:white;
					text-align:center;				
					line-height:1em;
					margin:20px auto;
					padding:20px;
					border-radius: 5px;
					font-size: larger;
					font-weight: bold;
				}
			</style>
		</div>
	';

	if( strtotime('now') < strtotime($expire_date) && strtotime('now') >= strtotime($start_date) ) {
		echo str_replace( '{{ messaggio }}', $messaggio, $messageMarkup );
	}
}
?>
<?php
if ( 'page' == get_option( 'show_on_front' ) ):
	if ( is_page_template( 'page-templates/blog-template.php' ) ):
		get_template_part( 'page-templates/blog', 'template' );
	elseif ( is_page_template( 'page-templates/sidebar-left.php' ) ):
		get_template_part( 'page-templates/sidebar', 'left' );
	elseif ( is_page_template( 'page-templates/sidebar-right.php' ) ):
		get_template_part( 'page-templates/sidebar', 'right' );
	else:
		get_template_part( 'page' );
	endif;
else:
	// Get Theme Mod
	$subheader_features_show   = get_theme_mod( 'regina_lite_subheader_features_show', 1 );
	$ourteam_general_show      = get_theme_mod( 'regina_lite_ourteam_general_show', 1 );
	$testimonials_general_show = get_theme_mod( 'regina_lite_testimonials_general_show', 1 );
	$speak_general_show        = get_theme_mod( 'regina_lite_speak_general_show', 1 );
	$blog_news_general_show    = get_theme_mod( 'regina_lite_news_general_show', 1 );
	$blog_map_general_show     = get_theme_mod( 'regina_lite_map_general_show', 1 );


	get_template_part( 'sections/section', 'home-slider' );
	
	
	if ( $subheader_features_show == 1 ):		
		get_template_part( 'sections/section', 'home-features-top' );
	endif;
	
	if ( $blog_news_general_show == 1 ):
		get_template_part( 'sections/section', 'news' );
	endif;

	if ( $subheader_features_show == 1 ):		
		get_template_part( 'sections/section', 'home-features' );
	endif;

	if ( $speak_general_show == 1 ):
		//get_template_part( 'sections/section', 'home-speak' );
	endif;


	if ( $blog_map_general_show == 1 ):
		get_template_part( 'sections/section', 'home-map' );
	endif;
/*


	if ( $ourteam_general_show == 1 ):
		get_template_part( 'sections/section', 'home-our-team' );
	endif;

	if ( $testimonials_general_show == 1 ):
		get_template_part( 'sections/section', 'home-testimonials' );
	endif;
*/
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


<div id="texticons"  style="color:#f04;"></div>

<script src="<?php echo get_template_directory_uri() ?>/layout/js/testicons.js"></script>
<?php
*/
endif;
?>
<?php get_footer(); ?>
