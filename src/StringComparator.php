<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-13
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
require_once 'AComparator.php';
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * String comparator.
 */
final class StringComparator {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    protected static string $t_type = 'string';
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    /**
     * Does the real comparison of the input with the $this->t_compare_to.
     *
     * @param  string $input
     *
     * @return bool
     */
    protected abstract function doCompare(string $input) : bool {
        return $this->t_compare_to === $input;
    }
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
