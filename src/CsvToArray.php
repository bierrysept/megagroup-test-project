<?php

namespace Bierrysept\MegagroupTestProject;

class CsvToArray
{
    public static function convert(bool|string $file)
    {
        $lines = static::getLines($file);
        $outLines = [];

        foreach ($lines as $key => $line) {
            $outLine = explode(",", $line);
            foreach ($outLine as &$element) {
                $element = static::trimQuotesOneTime($element);
            }
            $outLines[$key] = $outLine;
        }

        return $outLines;
    }

    public static function getLines(string $input)
    {
        return explode("\r\n", trim($input,"\r\n"));
    }

    public static function trimQuotesOneTime(string $input)
    {
        $string = $input;
        if (str_starts_with($string, "\"")) {
            $string = substr($string, 1);
        }
        if (str_ends_with($string, "\"")) {
            $string = substr($string, 0, -1);
        }
        return $string;
    }


}