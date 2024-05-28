<?php

use Bierrysept\MegagroupTestProject\CsvToJsonConverter;
use PHPUnit\Framework\TestCase;

class CsvToJsonTest extends TestCase
{
    public function testEmptyJson() {
        $lines = file(__DIR__."/csvs/empty.csv");
        $this->assertIsArray($lines);

        $cleanLines = CsvToJsonConverter::getCleanLines($lines);
        $this->assertEquals("id,parent_id,name", $cleanLines[0]);
        $this->assertEquals("", $cleanLines[1]);

        $json = CsvToJsonConverter::convert($cleanLines);
        $this->assertEquals("[]", $json);
    }

    public function testOneItemJson() {
        $lines = file(__DIR__."/csvs/oneItem.csv");
        $this->assertIsArray($lines);

        $cleanLines = CsvToJsonConverter::getCleanLines($lines);
        $this->assertEquals("id,parent_id,name", $cleanLines[0]);
        $this->assertEquals("1,0,Электроника", $cleanLines[1]);

        $expectedJson = file_get_contents(__DIR__."/jsons/oneItem.json");
        $actualJson = CsvToJsonConverter::convert($cleanLines);
        $this->assertEquals($expectedJson, $actualJson);
    }
}