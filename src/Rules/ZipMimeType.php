<?php

namespace Hamaelt\ZipValidator\Rules;

use Hamaelt\ZipValidator\Exception\InvalidFileTypeException;
use Illuminate\Contracts\Validation\Rule;
use Hamaelt\ZipValidator\Validator;
use Illuminate\Http\UploadedFile;

class ZipMimeType implements Rule
{
    const ZIP = 'application/zip';

    private Validator $validator;

    private string $message;

    private string $rules;

    /**
     * Create a new rule instance.
     * @param string $rules
     * @throws InvalidFileTypeException
     */
    public function __construct(string $rules)
    {
        $this->rules = $rules;
        $this->validator = new Validator($rules);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  $attribute
     * @param  $file
     * @return bool
     */
    public function passes($attribute, $file): bool
    {
        if (!$file instanceof UploadedFile || $file->getMimeType() !== self::ZIP) {
            $this->message = "Uploaded file must be a Zip file.";
            return false;
        }
        $this->message = "Zip contains invalid files. File must be one of {$this->rules}";

        return $this->validator->validateZipFile($file);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
