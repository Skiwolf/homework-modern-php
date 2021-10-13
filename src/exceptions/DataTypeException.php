<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-14
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * Custom data type exception.
 */
final class DataTypeException extends Exception {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    public function __construct($message, $code = 1, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    /**
     * Returns readable stack trace.
     *
     * @return string   Stack trace in readable form
     */
    private function getReadableTrace() : string {
        $result = '';

        $traceIteration = 1;
        $argsDelimeter  = ', ';

        $trace = $this->getTrace();
        foreach ($trace as $part) {
            $file     = array_key_exists('file', $part) ? $part['file'] : '';
            $line     = array_key_exists('line', $part) ? $part['line'] : '';
            $function = array_key_exists('function', $part) ? $part['function'] : '';
            $args     = array_key_exists('args', $part) && is_array($part['args']) ? print_r($part['args'], true) : '';

            $result .= ' #' . $traceIteration++ . ' ' . $file . '(' . $line . '): ' . $function . '(' . $args . ')';
        }
        $result = ltrim($result, ' ');

        return $result;
    }
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    public function __toString() {
        return __CLASS__ . ': [' . $this->code . ']: ' . $this->message . ' Trace: ' . $this->getReadableTrace();
    }
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
