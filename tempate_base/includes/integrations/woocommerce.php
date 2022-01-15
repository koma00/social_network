<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( class_exists('WooCommerce') ) {

	class Matebook_WooCommerce_Config {

		public static function form_fields( $base, $checkout ) {

			$fields = $checkout->get_checkout_fields( $base );

			if ( empty( $fields ) ) return;

			$sort_fields = array();

			foreach ( $fields as $key => $field ) {

				unset($field['class']);
				$field['label_class'] = isset( $field['required'] ) && !empty( $field['required'] ) ? ' *' : '';

				if ( 'order_comments' !== $key ) {
					$field['placeholder'] = $field['label'] . $field['label_class'];
				}

				switch($key) {
					case $base.'_first_name':
						$field['class'] = ['col6'];
						$field['label'] = '';
						break;
					case $base.'_last_name':
						$field['class'] = ['col6'];
						$field['label'] = '';
						break;
					case $base.'_country':
					case $base.'_state':
					break;
					case $base.'_postcode':
						$field['class'] = ['col6'];
						$field['label'] = '';
						break;
					case $base.'_phone':
						$field['class'] = ['col6'];
						$field['label'] = '';
						break;
					case $base.'_email':
						$field['class'] = ['col6'];
						$field['label'] = '';
						break;
					case 'order_comments':
						$field['label'] = '';
						break;
					default:
						$field['label'] = '';
						break;
				}

				$sort_fields[$key] = $field;
			}

			return $sort_fields;

		}

		public static function form_edit_address_fields( $fields ) {

			if ( empty( $fields ) ) return;

			$sort_fields = array();

			foreach ( $fields as $key => $field ) {

				unset($field['class']);

				switch($key) {
					case 'shipping_country':
					case 'shipping_address_1':
					case 'shipping_address_2':
						break;
					default:
						$field['label_class'] = isset( $field['required'] ) && !empty( $field['required'] ) ? ' *' : '';
						$field['placeholder'] = $field['label'] . $field['label_class'];
						$field['label'] = '';
						break;
				}

				$sort_fields[$key] = $field;
			}

			return $sort_fields;

		}

	}

}