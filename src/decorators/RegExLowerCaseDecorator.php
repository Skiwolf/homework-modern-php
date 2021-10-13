<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-13
 *
 * TODO: variable comments
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
require_once 'IDecorator.php';
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * Decorator that extract data with use of RegEx and changes the extracted content to lower case.
 */
final class RegExLowerCaseDecorator implements IDecorator {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    private string $m_pattern;
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    public function __construct(string $pattern) {
        $this->m_pattern = $pattern;
    }
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    /**
     * Tries to extract the relevant part of string to decorate.
     *
     * @param  string       $line   string to extract
     *
     * @return string|null          Null if the decorator condition is not met. String to decorate otherwise.
     */
    public function extract(string $line) : ?string {
        $matches = [];

        $preg_result = preg_match($this->m_pattern, $line, $matches, PREG_UNMATCHED_AS_NULL);
        if ($preg_result === 1 && $matches[1] !== null) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Tries to extract the relevant parts (allows for multiple subpatterns) of string to decorate.
     *
     * @param  string               $line   string to be extracted from
     *
     * @return array[string]|null           Null if the decorator condition is not met. Array of strings to decorate otherwise.
     */
    public function extractAll(string $line) : ?array {
        $matches = [];

        $preg_result = preg_match($this->m_pattern, $line, $matches, PREG_UNMATCHED_AS_NULL);
        if ($preg_result !== 1) {
            return null;
        }

        $results = [];
        $matches_length = count($matches);

        for ($i = 1; $i < $matches_length; $i++) {
            if ($matches[$i] === null) {
                continue;
            }

            $results[] = $matches[$i];
        }

        return $results;
    }

    /**
     * Applies the decorator unto the passed string.
     *
     * @param  string $line string to decorate
     *
     * @return string       decorated string
     */
    public function apply(string $line) : string {
        return strtolower($line);
    }
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
