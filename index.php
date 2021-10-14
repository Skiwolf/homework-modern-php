<?php

/**
 * AUTHOR:  Richard Bohac [rici.bohac@gmail.com]
 * DATE:    2021-10-14
 */

//------------------------------------------------------REQUIRES--------------------------------------------------------
require_once __DIR__ . '/configs/config.php';

require_once ABS_PATH . 'src/decorators/RegExLowerCaseDecorator.php';
require_once ABS_PATH . 'src/comparators/StringComparator.php';
require_once ABS_PATH . 'src/LogController.php';
//---------------------------------------------------REQUIRES - END-----------------------------------------------------


//------------------------------------------------------BODY--------------------------------------------------------
$file_reader = new TxtFileReader(INPUT_FILE_PATH);
if (!$file_reader->openHandler(INPUT_FILE_PATH !== 'php://stdin')) {
    echo 'Could not open input file: ' . INPUT_FILE_PATH;
    exit;
}

$decorator = new RegExLowerCaseDecorator(DECORATOR_REGEX);
$log_controller = new LogController($file_reader, $decorator);

try {
    foreach (COMPARATOR_STRINGS as $comparator_string) {
        $log_controller->addComparator(new StringComparator($comparator_string));
    }
} catch (DataTypeException $e) {
    echo $e;
    exit;
}

$log_controller->run(
    function() use ($log_controller) {
        $result = $log_controller->getResultsAsString();
        echo str_replace(PHP_EOL, OUTPUT_LINES_SEPARATOR, $result);
        echo OUTPUT_LINES_SEPARATOR;
        echo OUTPUT_LINES_SEPARATOR;
    },
    PRINT_AFTER_LINES
);


$file_reader->closeHandler();
//---------------------------------------------------BODY - END-----------------------------------------------------

?>
