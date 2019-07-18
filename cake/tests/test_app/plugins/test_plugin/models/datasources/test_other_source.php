<?php
class TestOtherSource extends DataSource {

	function describe(&$model) {
		return compact('model');
	}

	function listSources($data = null) {
		return array('test_source');
	}

	function create(&$model, $fields = array(), $values = array()) {
		return compact('model', 'fields', 'values');
	}

	function read(&$model, $queryData = array()) {
		return compact('model', 'queryData');
	}

	function update(&$model, $fields = array(), $values = array()) {
		return compact('model', 'fields', 'values');
	}

	function delete(&$model, $id = null) {
		return compact('model', 'id');
	}
}
