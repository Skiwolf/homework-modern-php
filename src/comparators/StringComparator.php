<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-13
 *
 * TODO: variable comments
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
require_once ABS_PATH . 'src/comparators/AComparator.php';
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * String comparator.
 */
final class StringComparator extends AComparator {
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
    protected function doCompare(mixed $input) : bool {
        return $this->t_compare_to === $input;
    }

    /**
     * Validates the comparator input data type.
     *
     * @param  mixed $input
     *
     * @return bool
     */
    protected function validateType(mixed $input) : bool {
        return is_string($input);
    }
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
