<?php
class TestSource extends DataSource {

	function describe(&$model) {
		return compact('model');
	}

	function listSources($data = NULL) {
		return array('test_source');
	}

	function create(&$model, $fields = NULL, $values = NULL) {
	    $fields = array();
	    $values = array();
		return compact('model', 'fields', 'values');
	}

	function read(&$model, $queryData = array()) {
		return compact('model', 'queryData');
	}

	function update(&$model, $fields = null, $values = null) {
        $fields = array();
        $values = array();
		return compact('model', 'fields', 'values');
	}

	function delete(&$model, $conditions = NULL) {
	    $id = $conditions;
		return compact('model', 'id');
	}
}
