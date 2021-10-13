<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-14
 *
 * TODO: comments
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
require_once 'comparators/AComparator.php';
require_once 'decorators/IDecorator.php';
require_once 'file_readers/TxtFileReader.php';
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 *
 */
class LogController {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    private array $m_comparators = [];
    private TxtFileReader $m_file_reader;
    private IDecorator $m_decorator;

    private array $m_results = [];
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    public function __construct(TxtFileReader $file_reader, IDecorator $decorator) {
        $this->m_file_reader = $file_reader;
        $this->m_decorator = $decorator;
    }
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    private function addResult(string $key) : void {
        if (!isset($this->m_results[$key])) {
            $this->m_results[$key] = 0;
        }

        $this->m_results[$key]++;
    }
    //---------------------------------------------PRIVATE FUNCTIONS - END----------------------------------------------

    //-----------------------------------------------PROTECTED FUNCTIONS------------------------------------------------
    //--------------------------------------------PROTECTED FUNCTIONS - END---------------------------------------------

    //------------------------------------------------PUBLIC FUNCTIONS--------------------------------------------------
    public function addComparator(AComparator $comparator) : void {
        $this->m_comparators[] = $comparator;
    }

    public function setPrintAfterLines(?int $print_after_lines) : void {
        $this->m_print_after_lines = $print_after_lines;
    }

    public function getResultsAsString() : string {
        $result = '';

        foreach ($this->m_results as $key => $value) {
            $result .= $key . ': ' . $value . PHP_EOL;
        }

        return $result;
    }

    public function run(?callable $print_callable = null, ?int $print_after_lines = null) : void {
        $this->m_results = [];

        $lines_read = 0;
        while (($line = $this->m_file_reader->readLine()) !== null) {
            if ($print_after_lines !== null && $print_callable !== null && $lines_read !== 0 && $lines_read % $print_after_lines === 0) {
                $print_callable();
            }

            if (($extracted = $this->m_decorator->extract($line)) !== null) {
                $decorated = $this->m_decorator->apply($extracted);

                $do_skip = false;
                foreach ($this->m_comparators as $comparator) {
                    if ($comparator->compare($decorated)) {
                        $do_skip = true;
                        break;
                    }
                }

                if (!$do_skip) {
                    $this->addResult($decorated);
                }
            }

            $lines_read++;
        }

        $print_callable();
    }
    //---------------------------------------------PUBLIC FUNCTIONS - END-----------------------------------------------
}

?>
