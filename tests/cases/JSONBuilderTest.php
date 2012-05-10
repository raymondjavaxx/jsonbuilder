<?php

use jsonbuilder\JSONBuilder;

/**
 * Test case for \jsonbuilder\JSONBuilder
 *
 * @package tests
 */
class JSONBuilderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test for \jsonbuilder\JSONBuilder::object()
	 *
	 * @return void
	 */
	public function testObject() {
		$result = JSONBuilder::object(function($obj) {
			$obj->id = 1;
			$obj->name = "John";
		});

		$expected = '{"id":1,"name":"John"}';
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test for \jsonbuilder\JSONBuilder::arr()
	 *
	 * @return void
	 */
	public function testArr() {
		$items = array(
			array('id' => 1, 'name' => 'John'),
			array('id' => 2, 'name' => 'Dave')
		);

		$result = JSONBuilder::arr($items, function($json, $item) {
			$json->id = $item['id'];
			$json->name = $item['name'];
			$json->odd = ($item['id']%2 !== 0);
		});

		$expected = '[{"id":1,"name":"John","odd":true},{"id":2,"name":"Dave","odd":false}]';
		$this->assertEquals($expected, $result);
	}
}
