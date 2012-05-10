<?php

namespace jsonbuilder;
	
class JSONBuilder {

	public static function object(\Closure $callback = null) {
		$obj = new Object;

		if ($callback) {
			$callback->__invoke($obj);
		}

		return json_encode($obj);
	}

	public static function arr($items, $map) {
		$data = new Object;
		$data->items($items, $map);
		return json_encode($data->items);
	}
}
