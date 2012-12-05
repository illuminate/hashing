<?php namespace Illuminate\Hashing;

use KevinGH\Bcrypt\Bcrypt;

class BcryptHasher implements HasherInterface {

	/**
	 * Hash the given value.
	 *
	 * @param  string  $value
	 * @return array   $options
	 * @return string
	 */
	public function make($value, array $options = array())
	{
		$rounds  = isset($options['rounds']) ? $options['rounds'] : 10;
		$version = isset($options['version']) ? $options['version'] : null;
		$salt 	 = isset($options['salt']) ? $options['salt'] : null;

		// Ensure round value is within the minimum and maximum boundaries.
		if ($rounds < 4) {
			$rounds = 4;
		} elseif ($rounds > 31) {
			$rounds = 31;
		}

		// Setup the BCrypt object.
		$bcrypt = Bcrypt::create($version === '2a');

		if (! is_null($rounds)) {
			$bcrypt->setCost($rounds);
		}

		if (is_null($salt)) {
			$bcrypt->setSalt($bcrypt->generateSalt());
		} elseif (0 === strpos($salt, '$')) {
			$bcrypt->setEncoded($salt);
		} else {
			$bcrypt->setSalt($salt);
		}

		return $bcrypt($value);
	}

	/**
	 * Check the given plain value against a hash.
	 *
	 * @param  string  $value
	 * @param  string  $hashedPassword
	 * @param  array   $options
	 * @return bool
	 */
	public function check($value, $hash, array $options = array())
	{
		$options = array_merge($options, array('salt' => $hash));
		return ($hash === $this->make($value, $options));
	}

}