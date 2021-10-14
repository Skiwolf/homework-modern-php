<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-14
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
require_once ABS_PATH . 'src/comparators/AComparator.php';
require_once ABS_PATH . 'src/decorators/IDecorator.php';
require_once ABS_PATH . 'src/file_readers/TxtFileReader.php';
//---------------------------------------------------REQUIRES - END-----------------------------------------------------

/**
 * Controller for log streams.
 *
 * Reads input stream line by line and checks it with decorator. If the decorator extracts any result it is checked with the comparators.
 * If any of the comparators returns true, the result is filtered out.
 */
class LogController {
    //----------------------------------------------------CONSTANTS-----------------------------------------------------
    //-------------------------------------------------CONSTANTS - END--------------------------------------------------

    //----------------------------------------------------VARIABLES-----------------------------------------------------
    /**
     * Array of comparators used to filter out the unwanted results.
     * If atleast one comparator returns true the result is filtered out.
     *
     * @var array<AComparator>
     */
    private array $m_comparators = [];

    /**
     * File reader for log input stream.
     *
     * @var TxtFileReader
     */
    private TxtFileReader $m_file_reader;

    /**
     * Decorator used to extract results.
     *
     * @var IDecorator
     */
    private IDecorator $m_decorator;

    /**
     * Array with extracted results.
     *
     * @var array<string, int>
     */
    private array $m_results = [];
    //-------------------------------------------------VARIABLES - END--------------------------------------------------

    //--------------------------------------------------CONSTRUCTORS----------------------------------------------------
    public function __construct(TxtFileReader $file_reader, IDecorator $decorator) {
        $this->m_file_reader = $file_reader;
        $this->m_decorator = $decorator;
    }
    //-----------------------------------------------CONSTRUCTORS - END-------------------------------------------------

    //------------------------------------------------PRIVATE FUNCTIONS-------------------------------------------------
    /**
     * Adds result to the $this->m_results array.
     *
     * @param string $key
     */
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
    /**
     * Adds comparator for filtering out.
     *
     * @param AComparator $comparator
     */
    public function addComparator(AComparator $comparator) : void {
        $this->m_comparators[] = $comparator;
    }

    /**
     * Returns results in readable form.
     *
     * @return string
     */
    public function getResultsAsString() : string {
        $result = '';

        foreach ($this->m_results as $key => $value) {
            $result .= $key . ': ' . $value . PHP_EOL;
        }

        return $result;
    }

    /**
     * Runs the LogController logic.
     * Reads input stream line by line and checks it with decorator. If the decorator extracts any result it is checked with the comparators.
     * If any of the comparators returns true, the result is filtered out.
     *
     * @param callable $print_callable      function to call after every print request, no parameters are passed to the callable
     * @param int|null $print_after_lines   if not null the $print_callable is called after every numer of lines.
     *                                      if null it is called only at the end of the function.
     */
    public function run(callable $print_callable, ?int $print_after_lines = null) : void {
        $this->m_results = [];

        $lines_read = 0;
        while (($line = $this->m_file_reader->readLine()) !== null) {
            if ($print_after_lines !== null && $lines_read !== 0 && $lines_read % $print_after_lines === 0) {
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
