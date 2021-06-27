<?php

namespace Hamaelt\ZipValidator\Tests;

use Hamaelt\ZipValidator\Rules\ZipMimeType;
use Illuminate\Http\UploadedFile;

class ValidatorTest extends TestCase
{

    /** @test */
    public function validation_should_not_fail_if_zip_file_contains_valid_files()
    {
        $validator = new ZipMimeType('pdf|png|jpg');
        $result = $validator->passes('file', $this->getFile('file.zip'));
        $this->assertTrue($result);
    }

    /** @test */
    public function validation_should_fail_if_zip_file_contains_invalid_files()
    {
        $validator = new ZipMimeType('pdf|png|jpg');
        $result = $validator->passes('file', $this->getFile('file-sql.zip'));

        $this->assertFalse($result);
    }

    /** @test */
    public function it_should_through_exception_when_invalid_mime_type_is_given()
    {
        $this->expectException(\Exception::class);
        $validator = new ZipMimeType('jpgg');
        $validator->passes('file', $this->getFile('file.zip'));
    }

    public function getFile(string $fileName)
    {
        return new UploadedFile(__DIR__ . '/_data/'. $fileName, $fileName);
    }
}