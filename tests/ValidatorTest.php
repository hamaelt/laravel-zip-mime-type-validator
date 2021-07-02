<?php

namespace Hamaelt\ZipValidator\Tests;

use Hamaelt\ZipValidator\Exception\InvalidFileTypeException;
use Hamaelt\ZipValidator\Rules\ZipMimeType;
use Illuminate\Http\UploadedFile;

class ValidatorTest extends TestCase
{

    /**
     * Validation should pass if zip file contains files with type specified in rule
     *
     * @test
     */
    public function validation_should_pass()
    {
        $validator = new ZipMimeType('pdf,png,jpg');
        $result = $validator->passes('file', $this->getFile('file.zip'));
        $this->assertTrue($result);
    }

    /**
     * Validation should fail if zip file does not contains files with type specified in rule
     *
     * @test
     */
    public function validation_should_fail()
    {
        $validator = new ZipMimeType('pdf,png,jpg');
        $result = $validator->passes('file', $this->getFile('file-sql.zip'));

        $this->assertFalse($result);
    }

    /** @test */
    public function it_should_through_exception_when_invalid_mime_type_is_given()
    {
        $this->expectException(InvalidFileTypeException::class);
        $validator = new ZipMimeType('pngppp');
        $validator->passes('file', $this->getFile('file.zip'));
    }

    /** @test */
    public function it_should_fail_when_invalid_file_is_passed()
    {
        $validator = new ZipMimeType('jpg,pdf');
        $result = $validator->passes('file', 'string');

        $this->assertFalse($result);
    }

    public function getFile(string $fileName)
    {
        return new UploadedFile(__DIR__ . '/_data/'. $fileName, $fileName);
    }
}
