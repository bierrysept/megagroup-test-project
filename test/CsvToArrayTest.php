<?php

use Bierrysept\MegagroupTestProject\CsvToArray;
use PHPUnit\Framework\TestCase;

class CsvToArrayTest extends TestCase
{
    public function testEmptyCsv() {
        $file = file_get_contents(__DIR__."/csvs/empty.csv");
        $this->assertIsString($file);

        $expectedArray = [
            [
                "id", "parent_id", "name"
            ]
        ];
        $actualArray = CsvToArray::convert($file);
        $this->assertEqualsCanonicalizing($expectedArray, $actualArray);
    }

    public function testOneItem() {
        $file = file_get_contents(__DIR__."/csvs/oneItem.csv");
        $this->assertIsString($file);

        $expectedArray = [
            [
                "id", "parent_id", "name"
            ],
            [
                "1", "0", "Электроника"
            ]
        ];
        $actualArray = CsvToArray::convert($file);
        $this->assertEqualsCanonicalizing($expectedArray, $actualArray);
    }

    public function testTwoItem() {
        $file = file_get_contents(__DIR__."/csvs/twoItem.csv");
        $this->assertIsString($file);

        $expectedArray = [
            [
                "id", "parent_id", "name"
            ],
            [
                "1", "0", "Электроника"
            ],
            [
                "2", "0", "Мобильные"
            ],
        ];
        $actualArray = CsvToArray::convert($file);
        $this->assertEqualsCanonicalizing($expectedArray, $actualArray);
    }

    public function testQuotesItem() {
        $file = file_get_contents(__DIR__."/csvs/quotesItem.csv");
        $this->assertIsString($file);

        $expectedArray = [
            [
                "id", "parent_id", "name"
            ],
            [
                "1", "0", "Мобильные телефоны"
            ]
        ];
        $actualArray = CsvToArray::convert($file);
        $this->assertEqualsCanonicalizing($expectedArray, $actualArray);
    }

    public function testGetLines() {
        $input = "a";
        $expected = ["a"];
        $actual = CsvToArray::getLines($input);
        $this->assertEqualsCanonicalizing($expected, $actual);

        $input = "a\r\n";
        $actual = CsvToArray::getLines($input);
        $this->assertEqualsCanonicalizing($expected, $actual);

        $input = "a\r\nb";
        $expected = ["a","b"];
        $actual = CsvToArray::getLines($input);
        $this->assertEqualsCanonicalizing($expected, $actual);

        $input = "a\r\nb\r\n";
        $actual = CsvToArray::getLines($input);
        $this->assertEqualsCanonicalizing($expected, $actual);

        $input = "a\r\nb\r\nc";
        $expected = ["a","b","c"];
        $actual = CsvToArray::getLines($input);
        $this->assertEqualsCanonicalizing($expected, $actual);

    }

    public function testExplode() {
        $input = "id,parent_id,name";
        $expected = [
            "id", "parent_id", "name"
        ];
        $this->assertEquals($expected, explode(",", $input));
    }

    public function testQuotesTrimOneTime() {
        $input = "\"test\"";
        $expected = "test";
        $actual = CsvToArray::trimQuotesOneTime($input);
        $this->assertEquals($expected, $actual);

        $input = "test";
        $expected = "test";
        $actual = CsvToArray::trimQuotesOneTime($input);
        $this->assertEquals($expected, $actual);

        $input = "\"\"test\" test\"";
        $expected = "\"test\" test";
        $actual = CsvToArray::trimQuotesOneTime($input);
        $this->assertEquals($expected, $actual);
    }
}