<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-13
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * Decorator interface.
 */
interface IDecorator {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    /**
     * Tries to extract the relevant part of string to decorate.
     *
     * @param  string       $line   string to be extracted from
     *
     * @return string|null          Null if the decorator condition is not met. String to decorate otherwise.
     */
    public function extract(string $line) : ?string;

    /**
     * Tries to extract the relevant parts of string to decorate.
     *
     * @param  string               $line   string to be extracted from
     *
     * @return array<string>|null           Null if the decorator condition is not met. Array of strings to decorate otherwise.
     */
    public function extractAll(string $line) : ?array;

    /**
     * Applies the decorator unto the passed string.
     *
     * @param  string $line string to decorate
     *
     * @return string       decorated string
     */
    public function apply(string $line) : string;
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
