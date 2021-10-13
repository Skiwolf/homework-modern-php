<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-13
 *
 * TODO: variable comments
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * Abstract class for comparators.
 */
abstract class AComparator {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    protected static string $t_type;

    protected mixed $t_compare_to;
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    public function __construct(mixed $compare_to) {
        if (!$this->validateType($compare_to)) {
            throw new Exception('AComparator::__construct - Incorrect type');
        }

        $this->t_compare_to = $compare_to;
    }
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    /**
     * Does the real comparison of the input with the $this->t_compare_to.
     *
     * @param  mixed $input
     *
     * @return bool
     */
    protected abstract function doCompare(mixed $input) : bool;

    /**
     * Validates the comparator input data type.
     *
     * @param  mixed $input
     *
     * @return bool
     */
    protected abstract function validateType(mixed $input) : bool;
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    /**
     * Compares the input object for equality.
     *
     * @param  mixed $input
     *
     * @return bool
     */
    public function compare(mixed $input) : bool {
        if (!$this->validateType($input)) {
            throw new Exception('AComparator::compare - Incorrect type');
        }

        return $this->doCompare($input);
    }
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
