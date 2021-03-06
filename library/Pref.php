<?php

/**
 * Copyright 2012, openTracker. (http://opentracker.nu)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @link          http://opentracker.nu openTracker Project
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * filename library/Pref.php
 * 
 * @author Wuild
 * @package openTracker.Pref
 */
class Pref {

    /**
     * Pref target
     * @var string
     */
    private $target;

    /**
     * Pref returned data
     * @var array
     */
    public $_vars = array();

    /**
     * Construct the pref class with a pref target.
     * @param string $target 
     */
    function __construct($target) {
        $this->target = $target;
        $db = new DB("pref");
        $db->select("pref_target = '" . $db->escape($target) . "'");
        while ($db->nextRecord()) {

            if (is_int($db->pref_value)) {
                $value = (int) $db->pref_value;
            } else {
                $value = $db->pref_value;
            }
            $this->__set($db->pref_name, $value);
        }
    }

    /**
     * Store a variable in the class
     * @param string $name
     * @param string $value 
     */
    function __set($name, $value) {
        $this->_vars[$name] = $value;
    }

    /**
     * Return a stored variable.
     * @param string $name
     * @return string
     */
    function __get($name) {
        if (isset($this->_vars[$name]))
            return $this->_vars[$name];
    }

    /**
     * Update the pref values on the selected target. 
     */
    function update() {
        $db = new DB("pref");
        $db->setColPrefix("pref_");
        foreach ($this->_vars as $name => $value) {
            $db->select("pref_name = '" . $name . "' AND pref_target = '" . $db->escape($this->target) . "'");
            if ($db->numRows()) {
                $db->value = $value;
                $db->update("pref_name = '" . $name . "' AND pref_target = '" . $db->escape($this->target) . "'");
            } else {
                $db->name = $name;
                $db->value = $value;
                $db->target = $this->target;
                $db->insert();
            }
        }
    }

}

?>
