<?php

namespace Bierrysept\MegagroupTestProject;

use Ds\Queue;

class DbArrayToJson
{

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

        return str_replace(["    ", "\n"], ["  ","\r\n"], $preJson);
    }

    public static function pushDaughter(array $base, array $input, bool &$wasPushed=false)
    {
        if ($wasPushed) {
            return $base;
        }

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
}