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

/**
 * Utility class for generating JSON
 *
 * @package jsonbuilder
 */	
class JSONBuilder {

	/**
	 * Builds a JSON object by invoking a callback function.
	 *
	 *     echo JSONBuilder::object(function($json) {
	 *         $json->hello = "world!";
	 *     });
	 *     // {"hello":"world!"}
	 *
	 * @param \Closure $callback
	 * @return string
	 */
	public static function object(\Closure $callback) {
		$obj = new Object;
		$callback->__invoke($obj);
		return json_encode($obj);
	}

	/**
	 * Maps $items to a JSON array. $items can be an array or anything that implements \Traversable.
	 *
	 *     $posts = Post::latest();
	 *
	 *     echo JSONBuilder::arr($posts, function($json, $post) {
	 *         $json->id = $post->id;
	 *         $json->body = \Markdown::parse($post->body);
	 *         $json->published = $post->published;
	 *
	 *         $json->comments($post->comments(), function($json, $comment) {
	 *             $json->id = $comment->id;
	 *             $json->comment = \Markdown::parse($comment->body);
	 *             $json->author($comment->author(), array('id', 'profile_img', 'username'));
	 *         });
	 *     });
	 *     // [{"id":1,"body":"...","published":"...","comments":["id":1,"comment":"...","author":{"id":1,"profile_image":"...","username":"johndoe"},...]}]
	 *
	 * $map can also be an array that contains the attributes to extract from the object.
	 *
	 *      $json->author($user, array('id', 'profile_img', 'username'));
	 *
	 * @param array|\Traversable $items 
	 * @param array|\Closure $map 
	 * @return string
	 */
	public static function arr($items, $map) {
		$data = new Object;
		$data->items($items, $map);
		return json_encode($data->items);
	}
}
