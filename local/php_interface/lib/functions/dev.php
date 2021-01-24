<?php
/**
 * @param $data
 * @param string $class
 * @param string $display
 */
function printData($data, $class = 'testData', $display = 'block')
{
    global $USER;

    if ($USER->isAdmin() && $USER->getId() == 2) {
        echo "<pre class='$class' style='display:" . $display . "'>";
        print_r($data);
        echo '</pre>';
    }
}

function lock()
{
    global $USER;

    if ($USER->getId() != 2) {
        die();
    }
}