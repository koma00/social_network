<?php

namespace Matebook\Ext\Peepso;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Peepso {

	use \Matebook\Src\Traits\Instantiatable;

	public function __construct() {

		if ( ! class_exists( 'PeepSo' ) ) {
			return;
		}

		$this->layout = Layout::instance();

	}

}
