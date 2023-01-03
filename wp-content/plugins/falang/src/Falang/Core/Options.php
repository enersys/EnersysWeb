<?php
/**
 * Created by PhpStorm.
 * User: Stéphane
 * Date: 27/05/2019
 * Time: 17:20
 */

namespace Falang\Core;



class Options {
	var $model = null;
	/**
	 * @from 1.0
	 *
	 * @var array
	 */
	var $taxonomy_fields = array('name', 'slug', 'description');

	public function __construct(){
		$this->model = new Falang_Model();

	}
}