<?php
/**
 * Copyright 2013 Nelio Software S.L.
 * This script is distributed under the terms of the GNU General Public
 * License.
 *
 * This script is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program. If not, see <http://www.gnu.org/licenses/>.
 */


if ( !class_exists( 'NelioABPostAltExpEditionPage' ) ) {

	require_once( NELIOAB_MODELS_DIR . '/experiment.php' );

	require_once( NELIOAB_ADMIN_DIR . '/views/alternatives/alt-exp-page.php' );
	class NelioABPostAltExpEditionPage extends NelioABAltExpPage {

		protected $alt_type;
		protected $original_id;

		public function __construct( $title, $alt_type = NelioABExperiment::PAGE_ALT_EXP ) {
			parent::__construct( $title );
			$this->set_icon( 'icon-nelioab' );
			$this->set_form_name( 'nelioab_edit_ab_post_exp_form' );
			$this->alt_type        = $alt_type;
			if ( NelioABExperiment::PAGE_ALT_EXP == $this->alt_type )
				$this->tests_a_page = true;
			else
				$this->tests_a_page = false;
			$this->original_id     = -1;

			// Prepare tabs
			$this->add_tab( 'info', __( 'General', 'nelio-ab-testing' ), array( $this, 'print_basic_info' ) );
			$this->add_tab( 'alts', __( 'Alternatives', 'nelio-ab-testing' ), array( $this, 'print_alternatives' ) );
			$this->add_tab( 'goals', __( 'Goals', 'nelio-ab-testing' ), array( $this, 'print_goals' ) );
		}

		public function set_original_id( $id ) {
			$this->original_id = $id;
		}

		public function get_alt_exp_type() {
			if ( $this->alt_type == NelioABExperiment::PAGE_ALT_EXP )
				return NelioABExperiment::PAGE_ALT_EXP;
			else
				return NelioABExperiment::POST_ALT_EXP;
		}

		protected function get_save_experiment_name() {
			return _e( 'Save', 'nelio-ab-testing' );
		}

		protected function get_basic_info_elements() {
			$ori_label = __( 'Original Page', 'nelio-ab-testing' );
			if ( $this->alt_type == NelioABExperiment::POST_ALT_EXP )
				$ori_label = __( 'Original Post', 'nelio-ab-testing' );

			return array(
				array (
					'label'     => __( 'Name', 'nelio-ab-testing' ),
					'id'        => 'exp_name',
					'callback'  => array( &$this, 'print_name_field' ),
					'mandatory' => true ),
				array (
					'label'     => __( 'Description', 'nelio-ab-testing' ),
					'id'        => 'exp_descr',
					'callback'  => array( &$this, 'print_descr_field' ) ),
				array (
					'label'     => $ori_label,
					'id'        => 'exp_original',
					'callback'  => array ( &$this, 'print_ori_field' ),
					'mandatory' => true ),
				array (
					'label'     => __( 'Finalization Mode', 'nelio-ab-testing' ),
					'id'        => 'exp_finalization_mode',
					'callback'  => array( &$this, 'print_finalization_mode_field' ),
					'min_plan'  => NelioABAccountSettings::ENTERPRISE_SUBSCRIPTION_PLAN,
					'mandatory' => true ),
			);
		}

		protected function print_ori_field() {
			require_once( NELIOAB_UTILS_DIR . '/html-generator.php' );
			if ( $this->alt_type == NelioABExperiment::PAGE_ALT_EXP )
				NelioABHtmlGenerator::print_page_searcher( 'exp_original', $this->original_id, 'show-drafts' );
			else
				NelioABHtmlGenerator::print_post_searcher( 'exp_original', $this->original_id, 'show-drafts' );
			?>
			<a class="button" style="text-align:center;"
				href="javascript:NelioABEditExperiment.previewOriginal()"><?php _e( 'Preview', 'nelio-ab-testing' ); ?></a>
			<span class="description" style="display:block;"><?php
				if ( $this->alt_type == NelioABExperiment::POST_ALT_EXP )
					_e( 'This is the post for which alternatives will be created.', 'nelio-ab-testing' );
				else
					_e( 'This is the page for which alternatives will be created.', 'nelio-ab-testing' );
			?> <small><a href="http://support.nelioabtesting.com/support/solutions/articles/1000129193" target="_blank"><?php
				_e( 'Help', 'nelio-ab-testing' );
			?></a></small></span><?php
		}


		protected function print_alternatives() { ?>
			<h2><?php

				$explanation = __( 'based on an existing page', 'nelio-ab-testing' );
				if ( $this->alt_type == NelioABExperiment::POST_ALT_EXP )
					$explanation = __( 'based on an existing post', 'nelio-ab-testing' );

				printf( '<a onClick="javascript:%1$s" class="add-new-h2" href="javascript:;">%2$s</a>',
					'NelioABAltTable.showNewPageOrPostAltForm(jQuery(\'table#alt-table\'), false);',
					__( 'New Alternative <small>(empty)</small>', 'nelio-ab-testing' )
				);
				printf( '<a onClick="javascript:%1$s" class="add-new-h2" href="javascript:;">%2$s</a>',
					'NelioABAltTable.showNewPageOrPostAltForm(jQuery(\'table#alt-table\'), true);',
					sprintf( __( 'New Alternative <small>(%s)</small>', 'nelio-ab-testing' ), $explanation)
				);

			?></h2><?php

			$wp_list_table = new NelioABPostAlternativesTable(
				$this->alternatives,
				$this->alt_type );
			$wp_list_table->prepare_items();
			$wp_list_table->display();
		}

	}//NelioABPostAltExpEditionPage



	require_once( NELIOAB_ADMIN_DIR . '/views/alternatives/alternatives-table.php' );
	class NelioABPostAlternativesTable extends NelioABAlternativesTable {

		private $alt_type;

		function __construct( $items, $alt_type ) {
			parent::__construct( $items );
			$this->alt_type          = $alt_type;
		}

		public function column_name( $alt ){

			//Build row actions
			$actions = array(
				'rename'	=> $this->make_quickedit_button( __( 'Rename', 'nelio-ab-testing' ) ),

				'edit-content'	=> sprintf(
						'<a style="cursor:pointer;" onClick="javascript:' .
							'NelioABAltTable.editContent(jQuery(this).closest(\'tr\'));' .
							'">%s</a>',
						__( 'Save Experiment & Edit Content' ) ),

				'delete'	=> sprintf(
						'<a style="cursor:pointer;" onClick="javascript:' .
							'NelioABAltTable.remove(jQuery(this).closest(\'tr\'));' .
							'">%s</a>',
						__( 'Delete' ) ),
			);

			//Return the title contents
			return sprintf(
				'<span class="row-title alt-name">%1$s</span>%2$s',
				/*%1$s*/ $alt['name'],
				/*%2$s*/ $this->row_actions( $actions )
			);
		}

		public function extra_tablenav( $which ) {
			if ( 'top' == $which ){
				$text = __( 'Please, <b>add one or more</b> alternatives to the Original Page using the buttons above.', 'nelio-ab-testing' );
				if ( $this->alt_type == NelioABExperiment::POST_ALT_EXP )
					$text = __( 'Please, <b>add one or more</b> alternatives to the Original Post using the buttons above.', 'nelio-ab-testing' );
				echo $text;
			}
		}

		public function display_rows_or_placeholder() {
			$this->print_new_alt_form();

			$title = __( 'Original Page', 'nelio-ab-testing' );
			if ( $this->alt_type == NelioABExperiment::POST_ALT_EXP )
				$title = __( 'Original Post', 'nelio-ab-testing' );

			$expl = __( 'The original page can be considered an alternative that has to be tested.', 'nelio-ab-testing' );
			if ( $this->alt_type == NelioABExperiment::POST_ALT_EXP )
				$expl = __( 'The original post can be considered an alternative that has to be tested.', 'nelio-ab-testing' );
			?>
			<tr><td>
				<span class="row-title"><?php echo $title; ?></span>
				<div class="row-actions"><?php echo $expl; ?></div>
			</td></tr>
			<?php
			parent::display_rows();
		}

		protected function get_inline_edit_title() {
			return __( 'Rename Alternative', 'nelio-ab-testing' );
		}

		protected function get_inline_name_field_label() {
			return __( 'Name', 'nelio-ab-testing' );
		}

		protected function print_additional_info_for_new_alt_form() { ?>
			<label class="copying-content" style="padding-top:0.5em;">
				<span class="title"><?php _e( 'Source', 'nelio-ab-testing' ); ?> </span>
				<span class="input-text-wrap">
					<?php
					require_once( NELIOAB_UTILS_DIR . '/html-generator.php' );
					if ( $this->alt_type == NelioABExperiment::PAGE_ALT_EXP )
						NelioABHtmlGenerator::print_page_searcher( 'based_on', false, 'show-drafts' );
					else
						NelioABHtmlGenerator::print_post_searcher( 'based_on', false, 'show-drafts' );
					?>
					<span class="description" style="display:block;"><?php _e( 'The selected page\'s content will be duplicated and used by this alternative.', 'nelio-ab-testing' ); ?></span>
				</span>
			</label><?php
		}

	}

}

