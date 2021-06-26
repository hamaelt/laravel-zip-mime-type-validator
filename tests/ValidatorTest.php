<?php

namespace Hamaelt\ZipValidator\Tests;

use Hamaelt\ZipValidator\Rules\ZipMimeType;
use Illuminate\Http\UploadedFile;

class ValidatorTest extends TestCase
{
   private UploadedFile $file;

//    /** @test */
//    public function test_validates_with_string_and_array_list_of_files()
//    {
//        $validator = new ZipMimeType('pdf|png|jpg');
//        $result = $validator->passes('file', $this->getFile('file.zip'));
//        $this->assertTrue($result);
//    }
//
//    /** @test */
//    public function test_invalidates_with_string_and_array_list_of_file()
//    {
//        $validator = new ZipMimeType('pdf|png|jpg');
//        $result = $validator->passes('file', $this->getFile('file-sql.zip'));
//
//        $this->assertFalse($result);
//    }

    /** @test */
    public function test_invalidates_with_string_and_array_list_of()
    {
        $validator = new ZipMimeType('pdf|png|jpg');
        $result = $validator->passes('file', $this->getFile('file-sql.zip'));

        $this->assertFalse($result);
    }

    public function getFile(string $fileName)
    {
        return new UploadedFile(__DIR__ . '/_data/'. $fileName, $fileName);
    }
}