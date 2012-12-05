<?php namespace Illuminate\Hashing;

interface HasherInterface {

	/**
	 * Hash the given value.
	 *
	 * @param  string  $value
	 * @return array   $options
	 * @return string
	 */
	public function make($value, array $options = array());

	/**
	 * Check the given plain value against a hash.
	 *
	 * @param  string  $value
	 * @param  string  $hash
	 * @param  array   $options
	 * @return bool
	 */
	public function check($value, $hash, array $options = array());

}