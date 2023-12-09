<?php
/**
 *  The template for displaying the Features on Home page.
 *
 * @package    WordPress
 * @subpackage regina-lite
 */
?>
<?php
// Get Theme Mod for Features Panel
$top_box_show                  = 1; //get_theme_mod( 'regina_lite_top_box_show', 1 );
$top_box_title                 = get_theme_mod( 'regina_lite_top_box_title', __( 'We help people, like you.', 'regina-lite' ) );
$top_box_description           = get_theme_mod( 'regina_lite_top_box_description', __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'regina-lite' ) );
$top_box_bookappointmenturl    = get_theme_mod( 'regina_lite_top_box_bookappointmenturl', '#' );
$features_general_title        = get_theme_mod( 'regina_lite_features_general_title', __( 'Our Services', 'regina-lite' ) );
$features_general_description  = get_theme_mod( 'regina_lite_features_general_description', __( 'We offer various services lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'regina-lite' ) );
$features_general_button_text  = get_theme_mod( 'regina_lite_features_general_button_text', __( 'Our Services', 'regina-lite' ) );
$features_general_button_url   = get_theme_mod( 'regina_lite_features_general_button_url', esc_url( '#' ) );
$features_feature1_title       = get_theme_mod( 'regina_lite_features_feature1_title', __( 'Free Support', 'regina-lite' ) );
$features_feature1_description = get_theme_mod( 'regina_lite_features_feature1_description', __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'regina-lite' ) );
$features_feature1_buttonurl   = get_theme_mod( 'regina_lite_features_feature1_buttonurl', '#' );
$features_open_hour_weekdays   = get_theme_mod( 'regina_lite_features_open_hour_weekdays', '#' );
$features_close_hour_weekdays  = get_theme_mod( 'regina_lite_features_close_hour_weekdays', '#' );
$features_open_hour_saturday   = get_theme_mod( 'regina_lite_features_open_hour_saturday', '#' );
$features_close_hour_saturday  = get_theme_mod( 'regina_lite_features_close_hour_saturday', '#' );
$features_feature2_title       = get_theme_mod( 'regina_lite_features_feature2_title', __( 'Medical Care', 'regina-lite' ) );
$features_feature2_description = get_theme_mod( 'regina_lite_features_feature2_description', __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'regina-lite' ) );
$features_feature2_buttonurl   = get_theme_mod( 'regina_lite_features_feature2_buttonurl', '#' );
$features_feature3_title       = get_theme_mod( 'regina_lite_features_feature3_title', __( 'Life Care', 'regina-lite' ) );
$features_feature3_description = get_theme_mod( 'regina_lite_features_feature3_description', __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'regina-lite' ) );
$features_feature3_buttonurl   = get_theme_mod( 'regina_lite_features_feature3_buttonurl', '#' );
$features_feature4_title       = get_theme_mod( 'regina_lite_features_feature4_title', __( 'Nervous System', 'regina-lite' ) );
$features_feature4_description = get_theme_mod( 'regina_lite_features_feature4_description', __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.', 'regina-lite' ) );
$features_feature4_buttonurl   = get_theme_mod( 'regina_lite_features_feature4_buttonurl', '#' );
$book_appointment_button_label = get_theme_mod( 'regina_lite_book_appointment_button_label', __( 'Book Appointment', 'regina-lite' ) );

?>

<div class="container">

	<?php  avviso('Il laboratorio rimarrà chiuso per ferie dal 9 al 27 agosto 2023', '2023-08-28'); ?> 

	<div class="row">
		<?php if (false &&  $top_box_show == 1 ): ?>
			<div class="col-lg-10 col-md-12 col-lg-offset-1">
				<div id="call-out" class="clear">
					<?php if ( $top_box_title ): ?>
						<h1><?php echo esc_html( $top_box_title ); ?></h1>
					<?php endif; ?>
					<?php if ( $top_box_description ): ?>
						<p><?=$top_box_description?></p>
					<?php endif; ?>
					<br />
					<?php if ( $top_box_bookappointmenturl ): ?>
						<a href="<?php echo esc_url( $top_box_bookappointmenturl ); ?>" class="button white outline" title="<?php echo esc_attr( $book_appointment_button_label ) ?>"><?php echo esc_attr( $book_appointment_button_label ); ?>
							<span class="nc-icon-glyph arrows-1_bold-right"></span></a>
					<?php endif; ?>
				</div><!--#call-out-->
			</div><!--.col-md-8-->
		<?php endif; ?>

	</div>
	
	<?php /*
	<div class="row">
		<div class="col-lg-2 col-xs-12"></div>	
		<div class="col-lg-8 col-xs-12 covid">
			<div class="covid">
				<h2>INFORMAZIONI COVID</h2>
				<p>TAMPONE RAPIDO ANTIGENICO<br>
				INDAGINE EPIDEMIOLOGICA REGIONE LAZIO</p>
				<p>
					Determinazione G11083 del 29/09/2020<br>
					<img src="https://static.wixstatic.com/media/ce86cf_109acb7b9a2942f5ace0c9978c65eef1~mv2.png/v1/fill/w_115,h_58,al_c,q_85,usm_0.66_1.00_0.01/logo-REGIONE-LAZIO.webp">
				</p>
				
				<h2>Come effettuare il test</h2>
				<p>Le prenotazioni per effettuare il test saranno effettuate <span style="text-decoration:undeline"><strong>ESCLUSIVAMENTE</strong></span> dalle ore 12 alle ore 13 tutti i giorni e dalle ore 15:00 alle ore 16:00 martedì e giovedì</p>
				<p>Non è necessario presentare la prescrizione medica (ricetta)</p>

				<h2>Costo del test : 22,00 €</h2>

				<p>(come da delibera della Regione Lazio)</p>

				<h2>Ritiro del referto:<br>IN GIORNATA MA SOLO  ONLINE</h2>
				<p>Sarà richiesta l'email del paziente al momento della prenotazione</p>


			</div>
		</div>
		<style>
			.covid {
				background-color:red;
				color:white;
				text-align:center;				
				min-height:250px;
				margin:20px auto;
				padding:20px;
				border-radius: 5px;
			}

			.covid h2{
				background-color:red;
				color:white;
				
			}
		</style>
		<div class="col-lg-2 col-xs-12"></div>	
	</div>
	*/?>
		
<div class="row">
    
    
    


<?php if(true) : ?>
		<div id="services-title-block" class="col-xs-12" style="<?php if ( $top_box_show != 1 ) : echo 'margin-top: 100px;'; endif; ?>">
			<a id="orari"></a>
			<div class="section-info">
				<?php if ( $features_general_title ): ?>
					<h2><?php echo esc_html( $features_general_title ); ?></h2>
					<hr>
				<?php endif; ?>
				<?php if ( $features_general_description ): ?>
					<p><?=$features_general_description?></p>
				<?php endif; ?>
			</div><!--.section-info-->
		</div><!--.col-xs-12-->
<?php endif; ?>



<?php 
    $dec_12h = strtotime('2022-12-12');
    
    $now = strtotime('now');
    
    if( $now < $dec_12h) {
       $features_feature2_description = <<<HTML
        Le risposte si possono ritirare dal lunedì al venerdì dalle ore 16:00 alle 18:00
        <br>
        
        <h3 style="color:red; font-weight:bold">[ ! ] Avviso</h3>
        <p>A partire dal 12 dicembre 2022, il ritiro delle analisi sarà possibile <strong>sempre dal lunedì al venerdì</strong> secondo il seguente orario:</p>
	   
HTML;
    }
    
    $features_feature2_description .= <<<HTML
     <table class="orari">
			<thead>
				<tr>
					<th></th><th>Apertura</th><th>Chiusura</th>
				</tr>
			</thead>
			</thead>
			<tbody>
				<tr>
					<th>Mattina</th>
					<td>10:00</td><td>14:00</td>
				</tr>
				<tr>
					<th>Pomeriggio</th>
					<td>15:00</td><td>17:00</td>
				</tr>
			</tbody>
		</table>
    
HTML;


?>


<?php 
    $end_date = strtotime('2023-08-31');
    
    $now = strtotime('now');
    
    if( $now < $end_date) {
		// $features_feature2_title = 'Attenzione';
       $features_feature2_description = <<<HTML
        
        <h3 style="color:red; font-weight:bold">[ ! ] Avviso - Orario estivo</h3>

        <p>Per la refertazione dal <strong>24/07/2023</strong> al <strong>31/08/2023</strong>, <strong>sempre dal lunedì al venerdì</strong> secondo il seguente orario:</p>
	   
HTML;
    }
    
    $features_feature2_description .= <<<HTML
     <table class="orari" id="orari">
			<thead>
				<tr>
					<th></th><th>Apertura</th><th>Chiusura</th>
				</tr>
			</thead>
			</thead>
			<tbody>
				<tr>
					<th>Mattina</th>
					<td>08:00</td><td>13:00</td>
				</tr>
				<tr>
					<th>Pomeriggio</th>
					<td><b style="color:red">Chiuso</b></td><td></td>
				</tr>
			</tbody>
		</table>
    
HTML;


?>




<?php /* FEATURE 1-2 */ if(true) : ?>
		<section id="services-block" class="home content-block">

			<div class="spacer-5x visible-sm visible-xs"></div>
			<div class="col-lg-4 col-sm-6 col-lg-offset-2">
				<div class="service">
					<div class="icon">
						<span class="nc-icon-outline health_syringe"></span><!-- health_nurse  health_doctor creare icon font-->
					</div>
					<?php if ( $features_feature1_title ): ?>
						<h3><?php echo esc_html( $features_feature1_title ); ?></h3>
					<?php endif; ?>
					<table class="orari">
						<thead>
							<tr>
								<th></th><th>Apertura</th><th>Chiusura</th>
							</tr>
						</thead>
						</thead>
						<tbody>
							<tr>
								<th>Lun - Ven</th>
								<td><?php echo esc_html($features_open_hour_weekdays); ?></td><td><?php echo esc_html( $features_close_hour_weekdays ); ?></td>
							</tr>
							<tr>
								<th>Sabato</th>
								<td><?php echo esc_html( $features_open_hour_saturday ); ?></td><td><?php echo esc_html( $features_close_hour_saturday ); ?></td>
							</tr>
						</tbody>
					</table>
					<?php if ( $features_feature1_description ): ?>
						<p><?php echo esc_html( $features_feature1_description ); ?></p>
					<?php endif; ?>
					<br>
					<?php if ( $features_feature1_buttonurl ): ?>
						<a href="<?php echo esc_url( $features_feature1_buttonurl ); ?>" class="link small"><?php _e( 'Read more', 'regina-lite' ); ?>
							<span class="nc-icon-glyph arrows-1_bold-right"></span></a>
					<?php endif; ?>
				</div><!--.service-->
			</div><!--.col-lg-3-->

			<div class="col-lg-4 col-sm-6 ">
				<div class="service">
					<div class="icon">
						<span class="nc-icon-outline health_pulse-phone"></span> <!-- health_flask -->
					</div>
					<?php if ( $features_feature2_title ): ?>
						<h3><?php echo esc_html( $features_feature2_title ); ?></h3>
					<?php endif; ?>

					<?php if ( $features_feature2_description ): ?>
						<p><?=$features_feature2_description?></p>
					<?php endif; ?>
					<br>
					<?php if ( $features_feature2_buttonurl ): ?>
						<a href="<?php echo esc_url( $features_feature2_buttonurl ); ?>" class="link small"><?php _e( 'Read more', 'regina-lite' ); ?>
							<span class="nc-icon-glyph arrows-1_bold-right"></span></a>
					<?php endif; ?>
				</div><!--.service-->
			</div><!--.col-lg-3-->
<?php endif; ?>


<?php /* FEATURE 3-4 */ if(false) : ?>
			<div class="col-lg-3 col-sm-6">
				<div class="service">
					<div class="icon">
						<span class="nc-icon-outline health_hospital-32"></span>
					</div>
					<?php if ( $features_feature3_title ): ?>
						<h3><?php echo esc_html( $features_feature3_title ); ?></h3>
					<?php endif; ?>
					<?php if ( $features_feature3_description ): ?>
						<p><?php echo esc_html( $features_feature3_description ); ?></p>
					<?php endif; ?>
					<br>
					<?php if ( $features_feature3_buttonurl ): ?>
						<a href="<?php echo esc_url( $features_feature3_buttonurl ); ?>" class="link small"><?php _e( 'Read more', 'regina-lite' ); ?>
							<span class="nc-icon-glyph arrows-1_bold-right"></span></a>
					<?php endif; ?>
				</div><!--.service-->
			</div><!--.col-lg-3-->
			<div class="col-lg-3 col-sm-6">
				<div class="service">
					<div class="icon">
						<span class="nc-icon-outline health_brain"></span>
					</div>
					<?php if ( $features_feature4_title ): ?>
						<h3><?php echo esc_html( $features_feature4_title ); ?></h3>
					<?php endif; ?>
					<?php if ( $features_feature4_description ): ?>
						<p><?php echo esc_html( $features_feature4_description ); ?></p>
					<?php endif; ?>
					<br>
					<?php if ( $features_feature4_buttonurl ): ?>
						<a href="<?php echo esc_url( $features_feature4_buttonurl ); ?>" class="link small"><?php _e( 'Read more', 'regina-lite' ); ?>
							<span class="nc-icon-glyph arrows-1_bold-right"></span></a>
					<?php endif; ?>
				</div><!--.service-->
			</div><!--.col-lg-3-->
			<?php if ( false && $features_general_button_text && $features_general_button_url ): ?>
				<div class="col-xs-12 text-center">
					<a href="<?php echo esc_url( $features_general_button_url ); ?>" class="button dark outline" title="<?php echo esc_attr( $features_general_button_text ); ?>"><?php echo esc_html( $features_general_button_text ); ?>
						<span class="nc-icon-glyph arrows-1_bold-right"></span></a>
				</div>
			<?php endif; ?>
			<div class="clear"></div>
		</section><!--#services-block-->
<?php endif; ?>
	</div><!--.row-->
</div><!--.container-->