<?php

use Bierrysept\MegagroupTestProject\CsvToArray;
use Bierrysept\MegagroupTestProject\DbArrayToJson;
use PHPUnit\Framework\TestCase;

class DbArrayToJsonTest extends TestCase
{
    public function testConvertFromDbArray() {
        $fileContents = file_get_contents(__DIR__."/csvs/empty.csv");
        $dbArray = CsvToArray::convert($fileContents);

        $expected = "[]";
        $actual = DbArrayToJson::convert($dbArray);
        $this->assertEquals($expected, $actual);
    }

    public function testConvertOneItem() {
        $fileContents = file_get_contents(__DIR__."/csvs/oneItem.csv");
        $dbArray = CsvToArray::convert($fileContents);

        $expected = file_get_contents(__DIR__."/jsons/oneItem.json");
        $actual = DbArrayToJson::convert($dbArray);
        $this->assertEquals($expected, $actual);
    }

    public function testConvertTwoItem() {
        $fileContents = file_get_contents(__DIR__."/csvs/twoItem.csv");
        $dbArray = CsvToArray::convert($fileContents);

        $expected = file_get_contents(__DIR__."/jsons/twoItem.json");
        $actual = DbArrayToJson::convert($dbArray);
        $this->assertEquals($expected, $actual);
    }

    public function testConvertDaughterItem() {
        $fileContents = file_get_contents(__DIR__."/csvs/daughterItem.csv");
        $dbArray = CsvToArray::convert($fileContents);

        $expected = file_get_contents(__DIR__."/jsons/daughterItem.json");
        $actual = DbArrayToJson::convert($dbArray);
        $this->assertEquals($expected, $actual);
    }

    public function testConvertEarlyDaughterItem() {
        $fileContents = file_get_contents(__DIR__ . "/csvs/earlyDaughterItem.csv");
        $dbArray = CsvToArray::convert($fileContents);

        $expected = file_get_contents(__DIR__."/jsons/daughterItem.json");
        $actual = DbArrayToJson::convert($dbArray);
        $this->assertEquals($expected, $actual);
    }

    public function testPushDaughter() {
        $input1 = [
            "1" => [
                "name" => "Электроника"
            ]
        ];
        $input2 = [
            "2", "1", "Мобильные"
        ];
        $expected = [
            "1" => [
                "name" => "Электроника",
                "children" => [
                    "2" => [
                        "name" => "Мобильные"
                    ]
                ]
            ]
        ];
        $actual = DbArrayToJson::pushDaughter($input1, $input2);
        $this->assertEquals($expected, $actual);

        $input1 = $actual;
        $input2 = [
            "3", "1", "Планшетные"
        ];
        $expected = [
            "1" => [
                "name" => "Электроника",
                "children" => [
                    "2" => [
                        "name" => "Мобильные"
                    ],
                    "3" => [
                        "name" => "Планшетные"
                    ]
                ]
            ]
        ];
        $actual = DbArrayToJson::pushDaughter($input1, $input2);
        $this->assertEquals($expected, $actual);

        $input1 = $actual;
        $input2 = [
            "4", "2", "Xiaomi"
        ];
        $expected = [
            "1" => [
                "name" => "Электроника",
                "children" => [
                    "2" => [
                        "name" => "Мобильные",
                        "children" => [
                            "4" => [
                                "name" => "Xiaomi"
                            ]
                        ]
                    ],
                    "3" => [
                        "name" => "Планшетные"
                    ]
                ]
            ]
        ];
        $actual = DbArrayToJson::pushDaughter($input1, $input2);
        $this->assertEquals($expected, $actual);
    }

    public function testBased() {
        $fileContents = file_get_contents(__DIR__."/csvs/test.csv");
        $dbArray = CsvToArray::convert($fileContents);

        $expected = file_get_contents(__DIR__."/jsons/test.json");
        $actual = DbArrayToJson::convert($dbArray);
        $this->assertEquals($expected, $actual);
    }
}