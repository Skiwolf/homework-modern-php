<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-13
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * Abstract file reader utilizing filesystem function (fopen, fclose, ftell...).
 * WARNING: May be problematic for files larger than 2GB.
 */
abstract class AFileReader {

    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    /**
     * @var string|null
     */
    protected ?string $t_file_path = null;
    /**
     * file handler from fopen
     *
     * @var mixed
     */
    protected mixed $t_handler = null;
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    public function __construct(string $file_path) {
        $this->t_file_path = $file_path;
        $this->t_handler   = null;
    }
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    /**
     * Reads one line from the opened file.
     *
     * @return  mixed   Null on end, or non-opened handler. Returns whatever is considered appropriate for the AFileReader descendant.
     */
    public abstract function readLine() : mixed;

    /**
     * Reads full file. May be problematic for large files.
     *
     * @return array|null   Array of lines from $this->readLine().
     *                      Null if handler is not opened.
     *                      May return empty array for empty file.
     */
    public function readFile() : ?array {
        if ($this->t_handler === null) {
            return null;
        }

        $result = [];
        while (($line = $this->readLine()) !== null) {
            $result[] = $line;
        }

        return $result;
    }

    /**
     * Reads N lines from file. May be problematic for large files.
     *
     * @param  int          $lines_number   Number of lines read.
     * @return array|null                   Array of lines from $this->readLine().
     *                                      Null if handler is not opened.
     *                                      May return empty array for empty file.
     *                                      Number of returned lines may not equal to number of requested lines.
     */
    public function readNLines(int $lines_number) : ?array {
        if ($this->t_handler === null) {
            return null;
        }

        $result = [];
        for ($i = 0; $i < $lines_number; $i++) {
            $line = $this->readLine();
            if ($line === null) {
                break;
            }

            $result[] = $line;
        }

        return $result;
    }

    /**
     * Opens file handler. Needs to be done before reading.
     *
     * @return bool True if handler was opened successfuly. False on error.
     */
    public function openHandler() : bool {
        $this->t_handler = fopen($this->t_file_path, 'r');

        if (!$this->t_handler) {
            $this->t_handler = null;
            return false;
        }

        return true;
    }

    /**
     * Closes previously opened file handler.
     *
     * @return bool True if handler is not opened, or if closed successfuly. False on error.
     */
    public function closeHandler() : bool {
        if ($this->t_handler === null) {
            return true;
        }

        return fclose($this->t_handler);
    }

    /**
     * Rewinds current handler to start of file
     *
     * @return bool success, false when no handler present
     */
    public function rewindHandler() : bool {
        if ($this->t_handler === null) {
            return false;
        }

        return rewind($this->t_handler);
    }
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
