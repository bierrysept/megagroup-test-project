<?php

namespace Bierrysept\MegagroupTestProject;

class CsvToJsonConverter
{

    /**
     * Получает очищенные от мусора строки
     * @param array $lines
     * @return array
     */
    public static function getCleanLines(array $lines)
    {
        foreach ($lines as &$line) {
            $line = str_replace("\r\n", "", $line);
        }

        return $lines;
    }

    public static function convert(array $cleanLines)
    {
        if (count($cleanLines) == 1)
            return "[]";

        $explodeLine1 = explode(",",$cleanLines[1] );

        return "{
  \"{$explodeLine1[0]}\": {
    \"name\": \"{$explodeLine1[2]}\"
  }
}";
    }
}