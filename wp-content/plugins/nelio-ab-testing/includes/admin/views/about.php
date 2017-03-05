<?php
// ------------------------------------------------
// FILL THIS VARS FOR AN UPDATE
// ------------------------------------------------

$welcome_message = __( '%s Nelio A/B Testing %s is faster than ever!', 'nelio-ab-testing' );


/** @var string|boolean $minor_update */
$minor_update = false;


$main_update_title = '';
$main_update_summary = __( 'Experiments and their results are now cached in your WordPress server so that you don\'t have to wait.', 'nelio-ab-testing' );
$main_update_details = array(
	array(
		'title' => __( 'Speed Improvements', 'nelio-ab-testing' ),
		'text'  => __( 'We\'ve redesigned from scratch the plugin\'s architecture to offer a smoother and more satisfying user experience.', 'nelio-ab-testing' )
	),
	array(
		'title' => __( 'Same Workload, better UX', 'nelio-ab-testing' ),
		'text'  => __( 'Our cloud servers take care of all your visitors\' raw data. We collect and process their actions and digest the results you need.', 'nelio-ab-testing' )
	),
	array(
		'title' => __( 'Minor improvements', 'nelio-ab-testing' ),
		'text'  => __( 'This version also improves a few details in the user interface, such a colorized available quota or a new design of experiment creation steps.', 'nelio-ab-testing' )
	),
);


$secondary_update_details = array();
//	array(
//		'title' => __( 'New Results Page', 'nelio-ab-testing' ),
//		'text'  => __( 'We\'ve completely redesigned the results page. Now, the results are organized in three different sections: (a) general information about the experiment and its status, (b) details of the alternatives, and (c) a more visual list of conversion actions.', 'nelio-ab-testing' )
//	),
//	array(
//		'title' => __( 'New UI for Conversion Actions', 'nelio-ab-testing' ),
//		'text'  => __( 'The set of conversion actions are no longer presented using texts. Now, when you define the goals of your experiments, conversion actions use descriptive icons.', 'nelio-ab-testing' )
//	),
//	array(
//		'title' => __( 'Drag and Drop Conversion Actions', 'nelio-ab-testing' ),
//		'text'  => __( 'Conversion Actions are one of the key pieces of an A/B Testing platform. You can now sort the conversion actions within a goal just by dragging and dropping them.', 'nelio-ab-testing' )
//	)
//);


$tweets = array(
	__( 'Are you a WordPress publisher? #Nelio A/B Testing makes it super easy to split test your headlines!', 'nelio-ab-testing' ),
	__( '#Nelio A/B Testing is the best #abtest service for #WordPress. Check it out (it\'s free to test).', 'nelio-ab-testing' ),
	__( 'Collecting #heatmaps and #clickmaps in #WordPress, and then running split tests, is easy with Nelio.', 'nelio-ab-testing' ),
	__( 'Want more income? More subscribers? #Nelio A/B Testing is the best plugin for doing so in #WordPress.', 'nelio-ab-testing' )
);


?>
<div class="wrap about-wrap">
	<h1><?php printf( __( 'Welcome to Nelio A/B Testing %s', 'nelio-ab-testing' ), NELIOAB_PLUGIN_VERSION ); ?></h1>

	<div class="about-text nelioab-about-text">
		<?php
			if ( ! empty( $_GET['nelioab-installed'] ) ) {
				$message = __( 'Thanks, all done!', 'nelio-ab-testing' );
			} elseif ( ! empty( $_GET['nelioab-updated'] ) ) {
				$message = __( 'Thank you for updating to the latest version!', 'nelio-ab-testing' );
			} else {
				$message = __( 'Thanks for installing!', 'nelio-ab-testing' );
			}

			printf( $welcome_message, $message, NELIOAB_PLUGIN_VERSION );
		?>
	</div><!-- .about-text -->

	<div class="nelioab-badge"><div class="logo"></div><?php printf( __( 'Version %s', 'nelio-ab-testing' ), NELIOAB_PLUGIN_VERSION ); ?></div><!-- .nelioab-badge -->

	<?php
		// Random tweet - must be kept to 102 chars to "fit"
		shuffle( $tweets );
	?>

	<p class="nelioab-first-actions">
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://nelioabtesting.com" data-text="<?php echo esc_attr( $tweets[0] ); ?>" data-via="NelioSoft" data-size="large"><?php _e( 'Tweet', 'nelio-ab-testing' ); ?></a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</p>

	<?php
	if ( $minor_update ) {
		echo '<h2>' . __( 'Minor Update Notice', 'nelio-ab-testing' ). '</h2>';
		echo '<p>' . $minor_update . '</p>';
	}
	?>

	<?php
	// UPDATER TO 4.4.0
	$force_update = get_option( 'nelioab_local_exps_migration_status', 'pending' ) == 'pending';
	$force_update = $force_update || isset( $_GET['nab_force_update'] );
	if ( $force_update ) { ?>
		<div id="nelioab-updater-dialog">
			<h2><span class="spinner is-active" style="float:none;margin:0;margin-top:-5px;padding:0;"></span> <?php _e( 'Updating your local cache...', 'nelio-ab-testing' ); ?></h2>
			<p><?php _e( 'This new version of the plugin needs to retrieve your experiments from Nelio\'s cloud and save them locally. Please, wait until the process is completed...' ); ?></p>
		</div>
	<?php
	} ?>


	<h2><?php _e( 'What\'s New', 'nelio-ab-testing' ); ?></h2>

	<div class="changelog">
		<?php
		if ( ! empty( $main_update_title ) ) {
			echo "<h4>$main_update_title</h4>\n";
		} ?>
		<p><?php echo $main_update_summary; ?></p>

		<div class="changelog about-integrations">
			<div class="nelioab-feature feature-section col three-col">
				<div>
					<h4><?php echo $main_update_details[0]['title']; ?></h4>
					<p><?php echo $main_update_details[0]['text']; ?></p>
				</div>
				<div>
					<h4><?php echo $main_update_details[1]['title']; ?></h4>
					<p><?php echo $main_update_details[1]['text']; ?></p>
				</div>
				<div class="last-feature">
					<h4><?php echo $main_update_details[2]['title']; ?></h4>
					<p><?php echo $main_update_details[2]['text']; ?></p>
				</div>
			</div><!-- .nelioab-feature -->
		</div><!-- .about-integrations -->

	</div><!-- .changelog -->

	<?php
		$size = count( $secondary_update_details );
		if ( $size > 0 ) {
			echo "\n";
			echo '<div class="changelog">' . "\n";

			for ( $i = 0; $i < count( $secondary_update_details ); ++$i ) {
				$is_first_in_block = $i % 3 == 0;
				$is_last_in_block = $i % 3 == 2 || $i == $size - 1;

				if ( $is_first_in_block ) {
					echo '  <div class="feature-section col three-col">' . "\n";
				}

				if ( $is_last_in_block ) {
					echo '    <div class="last-feature">' . "\n";
				} else {
					echo '    <div>' . "\n";
				}

				$details = $secondary_update_details[$i];
				echo '      <h4>' . $details['title'] . '</h4>' . "\n";
				echo '      <p>' . $details['text'] . '</p>' . "\n";

				echo '    </div>' . "\n";

				if ( $is_last_in_block ) {
					echo '  </div><!-- .feature-section -->' . "\n";
				}
			}

			echo '</div><!-- .changelog -->' . "\n";
		}

	?>

	<p class="nelioab-last-actions">
		<a href="<?php echo admin_url('admin.php?page=nelioab-dashboard'); ?>" class="button button-primary<?php if ( $force_update ) echo ' disabled'; ?>"><?php _e( 'Dashboard', 'nelio-ab-testing' ); ?></a>
		<a href="<?php echo esc_url( 'http://support.nelioabtesting.com/support/home' ); ?>" class="button<?php if ( $force_update ) echo ' disabled'; ?>"><?php _e( 'Docs', 'nelio-ab-testing' ); ?></a>
	</p>

</div><!-- .wrap -->


<?php
// UPDATER TO 4.4.0
if ( $force_update ) { ?>
	<script type="text/javascript">
	(function( $ ) {
		$( '.nelioab-last-actions a' ).click( function() {
			if ( $( this ).hasClass( 'disabled' ) ) {
				return false;
			}//end if
		});

		function error( msg ) {
			$( '#nelioab-updater-dialog h2' ).html( <?php
				echo json_encode( __( 'Error!', 'nelio-ab-testing' ) );
			?> );
			$( '#nelioab-updater-dialog p' ).html( <?php
				echo json_encode( __( 'Something went wrong during the upgrade to version 4.4.0. Please, contact Nelio support.', 'nelio-ab-testing' ) );
			?> + '<br>' + msg );
		}//end error()

		setTimeout( function() {
			$.ajax({
				url: ajaxurl,
				data: {
					action: 'nelioab_migrate_cloud_exps_to_local'
				},
				success: function( data ) {
					console.log( data );
					if ( data === 'ok' ) {
						$( '#nelioab-updater-dialog h2' ).html( <?php
							echo json_encode( __( 'Ready!', 'nelio-ab-testing' ) );
						?> );
						$( '#nelioab-updater-dialog p' ).html( <?php
							echo json_encode( __( 'Nelio A/B Testing has been successfully updated.', 'nelio-ab-testing' ) );
						?> );
					} else if ( data.indexOf( 'Error: ' ) === 0 ) {
						error( data );
					} else {
						$( '#nelioab-updater-dialog' ).hide();
					}//end if
					$( '.nelioab-last-actions a' ).removeClass( 'disabled' );
				},//end success()
				error: function() {
					error( '' );
					$( '.nelioab-last-actions a' ).removeClass( 'disabled' );
				}//end error()
			});
		}, 1000 );

	})( jQuery );
	</script>
<?php
} ?>
