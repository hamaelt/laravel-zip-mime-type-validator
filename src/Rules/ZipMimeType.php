<?php

namespace Hamaelt\ZipValidator\Rules;

use Hamaelt\ZipValidator\Exception\InvalidMimeTypeException;
use Illuminate\Contracts\Validation\Rule;
use Hamaelt\ZipValidator\Validator;

class ZipMimeType implements Rule
{
    const ZIP = 'application/zip';

    private Validator $validator;

    /**
     * Create a new rule instance.
     * @param string $rule
     * @throws InvalidMimeTypeException
     */
    public function __construct(string $rule)
    {
        $this->validator = new Validator($rule);
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
        if ($file->getMimeType() !== self::ZIP) {
            return true;
        }
        return $this->validator->validateZipFile($file);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Zip contains invalid files';
    }
}
