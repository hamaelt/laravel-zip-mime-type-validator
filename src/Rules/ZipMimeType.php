<?php

namespace hamaelt\ZipValidator\Rules;

use Illuminate\Contracts\Validation\Rule;
use hamaelt\ZipValidator\Validator;

class ZipContent implements Rule
{

    private const ZIP = 'application/zip';

    private $validate;

    /**
     * Create a new rule instance.
     *
     * @param array|string $files
     * @param bool|string $allowEmpty
     */
    public function __construct(string $rule)
    {
        $this->validator = new Validator($rule);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param \Illuminate\Http\UploadedFile $zipFile
     * @return bool
     */
    public function passes($attribute, $file): bool
    {
        if($file->getMimeType() !== self::ZIP) {
            return true;
        }
       
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $zip = new \ZipArchive();
        $zip->open($file->getPathname());
        for($i = 0;$i <$zip->count(); $i++) {
            if(!in_array($finfo->buffer($zip->getFromIndex($i)), ['applicataion/pdf'])){
                $this->mimeType = $finfo->buffer($zip->getFromIndex($i));
                $zip->close();
                return false;
            }
        }
        return true;
   
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('zipValidator::messages.failed', [
            'files' => $this->failedFiles->implode(', '),
        ]);
    }
}
