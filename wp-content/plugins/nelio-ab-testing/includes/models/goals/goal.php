<?php
/**
 * Copyright 2015 Nelio Software S.L.
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


if( !class_exists( 'NelioABGoal' ) ) {

	/**
	 * Abstract class representing a Goal.
	 *
	 * In order to create an instance of this class, one must use of its
	 * concrete subclasses.
	 *
	 * @package \NelioABTesting\Models\Goals
	 * @since PHPDOC
	 */
	abstract class NelioABGoal {

		/**
		 * Constant PHPDOC
		 *
		 * @since PHPDOC
		 * @var int
		 */
		const UNDEFINED_GOAL_TYPE = 0;


		/**
		 * Constant PHPDOC
		 *
		 * @since PHPDOC
		 * @var int
		 */
		const ALTERNATIVE_EXPERIMENT_GOAL = 1;


		/**
		 * Constant PHPDOC
		 *
		 * @since PHPDOC
		 * @var string
		 */
		const UNDEFINED_GOAL_TYPE_STR = 'UndefinedGoalKind';


		/**
		 * Constant PHPDOC
		 *
		 * @since PHPDOC
		 * @var string
		 */
		const ALTERNATIVE_EXPERIMENT_GOAL_STR = 'AlternativeExperimentGoal';


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var NelioABExperiment
		 */
		private $exp;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var int
		 */
		private $id;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var int
		 */
		private $kind;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var string
		 */
		private $name;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var boolean
		 */
		private $is_main_goal;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var int
		 */
		private $benefit;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var boolean
		 */
		private $has_to_be_deleted;


		/**
		 * PHPDOC
		 *
		 * @since PHPDOC
		 * @var int
		 */
		private $order;


		/**
		 * PHPDOC
		 *
		 * @param NelioABExperiment $exp PHPDOC
		 * @param int               $id  PHPDOC
		 *
		 * @return NelioABGoal PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function __construct( $exp, $id = -1 ) {
			$this->kind = self::UNDEFINED_GOAL_TYPE;
			$this->name = __( 'Undefined', 'nelio-ab-testing' );
			$this->id   = $id;
			$this->exp  = $exp;
			$this->is_main_goal = false;
			$this->has_to_be_deleted = false;
		}


		/**
		 * Returns PHPDOC
		 *
		 * @param int $last_check TODO
		 *
		 * @return boolean PHPDOC
		 *
		 * @since PHPDOC
		 */
		private function get_interval_for_valid_results() {

			include_once( NELIOAB_MODELS_DIR . '/account-settings.php' );
			$plan = NelioABAccountSettings::get_nelioab_option( 'subscription_plan',
				NelioABAccountSettings::BASIC_SUBSCRIPTION_PLAN );

			if ( NelioABAccountSettings::ENTERPRISE_SUBSCRIPTION_PLAN === $plan ) {
				return 300;
			} else {
				return 1200;
			}//end if

		}//end get_interval_for_valid_results()

		/**
		 * Returns PHPDOC
		 *
		 * @param int $last_check TODO
		 *
		 * @return boolean PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function is_new_enough( $last_check ) {

			$now = time();
			$interval = $this->get_interval_for_valid_results();
			if ( ( $now - $last_check ) > $interval ) {
				return false;
			} else {
				return true;
			}//end if

		}//end is_new_enough()


		/**
		 * Returns PHPDOC
		 *
		 * @return boolean PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_time_for_recheck_in_five_minutes() {

			$now = time();
			$interval = $this->get_interval_for_valid_results();
			return $now - $interval + 300;

		}//end get_time_for_recheck_in_five_minutes()

		/**
		 * Returns PHPDOC
		 *
		 * @return NelioABExperiment PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_experiment() {
			return $this->exp;
		}


		/**
		 * Returns PHPDOC
		 *
		 * @return int PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_id() {
			return $this->id;
		}


		/**
		 * PHPDOC
		 *
		 * @param int $id
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_id( $id ) {
			$this->id = $id;
		}


		/**
		 * Returns PHPDOC
		 *
		 * @return int PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_kind() {
			return $this->kind;
		}


		/**
		 * PHPDOC
		 *
		 * @param int $kind
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_kind( $kind ) {
			$this->kind = $kind;
		}


		/**
		 * PHPDOC
		 *
		 * @param int $benefit
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_benefit( $benefit ) {
			try {
				$benefit = intval( $benefit );
				if ( $benefit > 0 )
					$this->benefit = $benefit;
				else
					$this->benefit = NelioABSettings::get_def_conv_value();
			}
			catch ( Exception $e ) {
				$this->benefit = NelioABSettings::get_def_conv_value();
			}
		}


		/**
		 * Returns PHPDOC
		 *
		 * @return int PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_benefit() {
			return $this->benefit;
		}


		/**
		 * PHPDOC
		 *
		 * @param int $kind
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_kind_using_text( $kind ) {
			switch( $kind ) {

				case self::ALTERNATIVE_EXPERIMENT_GOAL_STR:
					$this->set_kind( self::ALTERNATIVE_EXPERIMENT_GOAL );
					return;

				case self::UNDEFINED_GOAL_TYPE_STR:
				default:
					$this->set_kind( self::UNDEFINED_GOAL_TYPE );
					return;

			}
		}


		/**
		 * Returns PHPDOC
		 *
		 * @return string PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_textual_kind() {
			switch( $this->get_kind() ) {
				case self::ALTERNATIVE_EXPERIMENT_GOAL:
					return self::ALTERNATIVE_EXPERIMENT_GOAL_STR;
				case self::UNDEFINED_GOAL_TYPE:
				default:
					return self::UNDEFINED_GOAL_TYPE_STR;
			}

		}


		/**
		 * Returns PHPDOC
		 *
		 * @return string PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_name() {
			return $this->name;
		}


		/**
		 * PHPDOC
		 *
		 * @param string $name
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_name( $name ) {
			$this->name = $name;
		}


		/**
		 * Returns PHPDOC
		 *
		 * @return boolean PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function is_main_goal() {
			return $this->is_main_goal;
		}


		/**
		 * PHPDOC
		 *
		 * @param boolean $is_main_goal
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_as_main_goal( $is_main_goal ) {
			$this->is_main_goal = $is_main_goal;
		}


		/**
		 * PHPDOC
		 *
		 * @param boolean $delete
		 *                Default: true.
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 */
		public function set_to_be_deleted( $delete = true ) {
			$this->has_to_be_deleted = $delete;
		}


		/**
		 * Returns PHPDOC
		 *
		 * @return boolean PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function has_to_be_deleted() {
			return $this->has_to_be_deleted;
		}


		/**
		 * PHPDOC
		 *
		 * @return array PHPDOC
		 *
		 * @since PHPDOC
		 */
		public abstract function json4js();


		/**
		 * Returns PHPDOC
		 *
		 * @return NelioABGoalResult PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_local_results() {
			$results    = new NelioABAltExpGoalResult();
			/** @var NelioABAlternativeExperiment $experiment */
			$experiment = $this->get_experiment();

			$goal_results = false;
			$goal_result_set = get_post_meta( $experiment->get_id(), 'nelioab_goal_results', true );

			if ( ! empty( $goal_result_set ) ) {
				foreach ( $goal_result_set as $res ) {
					if ( $res['id'] === $this->get_id() ) {
						$goal_results = $res;
						break;
					}//end if
				}//end foreach
			}//end if

			return $goal_results;

		}//end get_local_results()


		/**
		 * Returns PHPDOC
		 *
		 * @return NelioABGoalResult PHPDOC
		 *
		 * @since PHPDOC
		 */
		public abstract function get_results();


		/**
		 * Returns PHPDOC
		 *
		 * @return NelioABGoalResult PHPDOC
		 *
		 * @since PHPDOC
		 */
		public abstract function sync();


		/**
		 * Returns PHPDOC
		 *
		 * @return boolean PHPDOC
		 *
		 * @since PHPDOC
		 */
		public abstract function is_ready();


		/**
		 * Returns PHPDOC
		 *
		 * @return array PHPDOC
		 *
		 * @since PHPDOC
		 */
		public abstract function encode_for_appengine();


		/**
		 * Returns PHPDOC
		 *
		 * @param int $order PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function set_order( $order ) {
			$this->order = $order;
		}//end set_order()


		/**
		 * Returns PHPDOC
		 *
		 * @return int PHPDOC
		 *
		 * @since PHPDOC
		 */
		public function get_order() {
			return $this->order;
		}//end get_order()


		/**
		 * Returns PHPDOC
		 *
		 * @param NelioABExperiment $exp  PHPDOC
		 * @param object            $json PHPDOC
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 *
		 * @abstract
		 */
		public static function decode_from_appengine( /** @noinspection PhpUnusedParameterInspection */ $exp, $json ) {
			throw new RuntimeException( 'Not Implemented Method' );
		}


		/**
		 * Returns PHPDOC
		 *
		 * @param object            $json_goal PHPDOC
		 * @param NelioABExperiment $exp       PHPDOC
		 *
		 * @return void
		 *
		 * @since PHPDOC
		 *
		 * @abstract
		 */
		public static function build_goal_using_json4js( /** @noinspection PhpUnusedParameterInspection */ $json_goal, $exp ) {
			throw new RuntimeException( 'Not Implemented Method' );
		}

	}//NelioABGoal

}

