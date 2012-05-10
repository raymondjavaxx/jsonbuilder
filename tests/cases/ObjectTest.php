<?php

use jsonbuilder\Object;

/**
 * Test case for \jsonbuilder\JSONBuilder
 *
 * @package tests
 */
class ObjectTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithNoParams() {
		$obj = new Object();
		$expected = '{}';
		$this->assertEquals($expected, (string)$obj);
	}

	public function testConstructorWithClosure() {
		$obj = new Object(function($json) {
			$json->id = 1;
			$json->name = "John";
		});

		$result = (string)$obj;
		$expected = '{"id":1,"name":"John"}';

		$this->assertEquals($expected, $result);
	}

	public function testConstructorWithAssociativeArray() {
		$obj = new Object(array('id' => 1, 'name' => 'John'));

		$result = (string)$obj;
		$expected = '{"id":1,"name":"John"}';

		$this->assertEquals($expected, $result);
	}

	public function testConstructorWithAssociativeArrayAndPropertyMap() {
		$obj = new Object(array('id' => 1, 'name' => 'John'), array('id'));

		$result = (string)$obj;
		$expected = '{"id":1}';

		$this->assertEquals($expected, $result);
	}

	public function testConstructorWithAssociativeArrayAndClosureMap() {
		$obj = new Object(array('id' => 1, 'name' => 'John'), function($json, $item) {
			$json->id = $item['id'];
		});

		$result = (string)$obj;
		$expected = '{"id":1}';

		$this->assertEquals($expected, $result);
	}
}
