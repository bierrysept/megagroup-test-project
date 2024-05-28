<?php

namespace Bierrysept\MegagroupTestProject;

/**
 * Получает из CS массив определенного вида
 */
class CsvToArray
{
    /**
     * Перевод строк к виду DbArray
     *
     * @param string $file
     * @return array
     */
    public static function convert(string $file): array
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

    /**
     * Получение строк разбитых по символу перевода строки
     *
     * @param string $input
     * @return string[]
     */
    public static function getLines(string $input): array
    {
        return explode("\r\n", trim($input,"\r\n"));
    }

    /**
     * Убирает только 1 кавычки
     *
     * @param string $input
     * @return string
     */
    public static function trimQuotesOneTime(string $input): string
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