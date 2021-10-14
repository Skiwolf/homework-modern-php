<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-14
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
     * File path to open.
     *
     * @var string
     */
    protected string $t_file_path;

    /**
     * File handler from fopen
     *
     * @var resource|null
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
     * @return array<mixed>|null    Array of lines from $this->readLine().
     *                              Null if handler is not opened.
     *                              May return empty array for empty file.
     */
    public function readFile() : ?array {
        if (!$this->isHandlerOpen()) {
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
     * @param  int                  $lines_number   Number of lines read.
     * @return array<mixed>|null                    Array of lines from $this->readLine().
     *                                              Null if handler is not opened.
     *                                              May return empty array for empty file.
     *                                              Number of returned lines may not equal to number of requested lines.
     */
    public function readNLines(int $lines_number) : ?array {
        if (!$this->isHandlerOpen()) {
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
     * @param  boolean $check_file_exists   True to check the if the file exists on file system.
     *                                      Should be disabled only for special cases like standard input or so.
     *
     * @return bool                         True if handler was opened successfuly.
     *                                      False on error, if the handler is already opened, or the file does not exist.
     */
    public function openHandler(bool $check_file_exists = true) : bool {
        if ($this->isHandlerOpen()) {
            return false;
        }
        if ($check_file_exists && !file_exists($this->t_file_path)) {
            return false;
        }

        $handler = fopen($this->t_file_path, 'r');

        if (!$handler) {
            $this->t_handler = null;
            return false;
        }
        $this->t_handler = $handler;

        return true;
    }

    /**
     * Closes previously opened file handler.
     *
     * @return bool True if handler is not opened, or if closed successfuly. False on error.
     */
    public function closeHandler() : bool {
        if (!$this->isHandlerOpen()) {
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
        if (!$this->isHandlerOpen()) {
            return false;
        }

        return rewind($this->t_handler);
    }

    /**
     * Check whether the file handler is open.
     *
     * @return bool
     */
    public function isHandlerOpen() : bool {
        return $this->t_handler !== null;
    }
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
