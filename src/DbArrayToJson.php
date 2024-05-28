<?php

namespace Bierrysept\MegagroupTestProject;

class DbArrayToJson
{

    /**
     * Конвертирует массив определенного вида в json
     *
     * @param array $dbArray
     * @return string
     */
    public static function convert(array $dbArray): string
    {
        $array = [];

        unset ($dbArray[0]);

        foreach ($dbArray as $key => $dbLine) {
            if ($dbLine[1] == "0") {
                $array [$dbLine[0]] = [
                    "name" => $dbLine[2]
                ];
                unset($dbArray[$key]);
            }
        }

        while (count($dbArray)>0) {
            foreach ($dbArray as $key => $line) {
                $wasPushed = false;
                $array = static::pushDaughter($array, $line, $wasPushed);
                if ($wasPushed) {
                    unset($dbArray[$key]);
                }
            }
        }

        $preJson = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return static::getPhpStormStyledFromDefaultPretty($preJson);
    }

    /**
     * Ожидает строчку из массива определенного вида и помещает её по её parent_id в нужный объект
     *
     * @param array $base основное дерево
     * @param array $input строчка определенного вида
     * @param bool $wasPushed
     * @return array
     */
    public static function pushDaughter(array $base, array $input, bool &$wasPushed=false): array
    {
        if (isset($base[$input[1]]["children"])) {
            $base[$input[1]]["children"][$input[0]] = [
                "name" => $input[2]
            ];

            $wasPushed = true;
            return $base;
        }

        if (isset($base[$input[1]])) {
            $base[$input[1]]["children"] = [
                $input[0] => [
                    "name" => $input[2]
                ]
            ];

            $wasPushed = true;
            return $base;
        }

        foreach ($base as &$value) {
            if (isset($value["children"])) {
                $value["children"] = static::pushDaughter($value["children"], $input, $wasPushed);
            }
        }

        return $base;
    }

    /**
     * Переводит стиль обычного JSON из PHP в стиль из PhpStorm
     *
     * @param bool|string $preJson
     * @return string
     */
    private static function getPhpStormStyledFromDefaultPretty(bool|string $preJson): string
    {
        return str_replace(["    ", "\n"], ["  ", "\r\n"], $preJson);
    }
}