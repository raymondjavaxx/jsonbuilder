<?php
/**
 * JSONBuilder
 *
 * Copyright (c) 2012 Ramon Torres
 *
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012 Ramon Torres
 * @license The MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace jsonbuilder;

class Object {

	public function __construct($data = null, $map = null) {
		if ($data !== null) {
			if (!is_object($data) && !is_array($data)) {
				throw new Exception("Data must be an object or array");
			}

			if (is_object($data) && is_a($data, '\Closure')) {
				$this->_initializeWithCallback($data);
			} else {
				$this->_initializeWithMap($data, $map);
			}
		}
	}

	protected function _initializeWithCallback(\Closure $callback) {
		$callback->__invoke($this);
	}

	public function _initializeWithMap($data, $map) {
		$callback = $map;

		if ($map === null || is_array($map)) {
			if (is_array($map)) {
				$attributes = $map;
			} else if (is_object($data)) {
				$attributes = get_object_vars($data);
			} else {
				$attributes = array_keys($data);
			}

			$callback = function ($json, $data) use ($attributes) {
				if (is_array($data)) {
					foreach ($attributes as $k) {
						$json->{$k} = $data[$k];
					}
				} else {
					foreach ($attributes as $k) {
						$this->{$k} = $data->{$k};
					}
				}
			};
		}

		$callback->__invoke($this, $data);
	}

	public function __call($name, $args) {
		if (count($args) < 1) {
			throw new Exception("Invalid number of arguments");
		}

		if (!in_array(gettype($args[0]), array('object', 'array'))) {
			throw new Exception("Expected first argument to be an object or array");
		}

		if (is_array($args[0]) || is_a($args[0], '\Traversable')) {
			$collection = $args[0];
			$attributes = isset($args[1]) ? $args[1] : null;

			$this->{$name} = array();
			foreach ($collection as $data) {
				$this->{$name}[] = new Object($data, $attributes);
			}
		} else if (is_a($args[0], '\Closure')) {
			$obj = new Object;
			$args[0]->__invoke($obj);
			$this->{$name} = $obj;
		}
	}

	public function __toString() {
		return json_encode($this);
	}
}
