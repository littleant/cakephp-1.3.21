<?php

/**
 * Article class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model
 */
class Article extends CakeTestModel {

    /**
     * name property
     *
     * @var string 'Article'
     * @access public
     */
    var $name = 'Article';

    /**
     * belongsTo property
     *
     * @var array
     * @access public
     */
    var $belongsTo = array('User');

    /**
     * hasMany property
     *
     * @var array
     * @access public
     */
    var $hasMany = array('Comment' => array('dependent' => true));

    /**
     * hasAndBelongsToMany property
     *
     * @var array
     * @access public
     */
    var $hasAndBelongsToMany = array('Tag');

    /**
     * validate property
     *
     * @var array
     * @access public
     */
    var $validate = array('user_id' => 'numeric', 'title' => array('allowEmpty' => false, 'rule' => 'notEmpty'), 'body' => 'notEmpty');

    /**
     * beforeSaveReturn property
     *
     * @var bool true
     * @access public
     */
    var $beforeSaveReturn = true;

    /**
     * beforeSave method
     *
     * @access public
     * @return void
     */
    function beforeSave() {
        return $this->beforeSaveReturn;
    }

    /**
     * titleDuplicate method
     *
     * @param mixed $title
     * @access public
     * @return void
     */
    function titleDuplicate ($title) {
        if ($title === 'My Article Title') {
            return false;
        }
        return true;
    }
}
