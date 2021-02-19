<?php


namespace App\Tests\Traits;


Trait Printer
{
    public function printTestInfo() {
        $backtrace = debug_backtrace()[1];
        $function = str_replace("test", "",$backtrace['function']);
        $type     = $backtrace['class'];
        $class = explode("\\", $backtrace["class"]);
        $class = $class[count($class) - 1];
        $class = str_replace("Test", "", $class);

        if (strpos($type, "Entity") != false) {
            $type = "Entity";
        }
        else if (strpos($type, "Repository") != false)
            $type = "Repository";

        echo PHP_EOL,"[$type]: $class => $function";
    }
}