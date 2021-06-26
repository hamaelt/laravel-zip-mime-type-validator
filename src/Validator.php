<?php

namespace Hamaelt\ZipValidator;

use finfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use ZipArchive;

class Validator
{
    /**
     * @var array
     */
    private array $allowedMimeTypes;

    /**
     * Validator constructor.
     *
     * @param string $fileTypes
     */
    public function __construct(string $fileTypes)
    {
        $this->allowedMimeTypes = $this->getMimeTypes($fileTypes);
        var_dump($this->allowedMimeTypes);
    }

    /**
     * Static function instantiate Validator class with given rules
     *
     * @param array|string $files
     *
     * @param bool $allowEmpty
     *
     * @return Validator
     */
    public static function rules($files, bool $allowEmpty = true): Validator
    {
        return new static($files, $allowEmpty);
    }

    /**
     * Validates ZIP content with given file path.
     *
     * @param string $filePath
     *
     * @return Collection
     */
    public function validate(string $filePath): Collection
    {
        $zipContent = $this->readContent($filePath);

        return $this->files
            ->reject(function ($value, $key) use ($zipContent) {
                return $this->checkFile($zipContent, $value, $key);
            })->map(function ($value, $key) {
                return is_int($key) ? $value : $key;
            });
    }

    /**
     * Checks if file name exists in ZIP file. Returns matching file name, null otherwise.
     *
     * @param Collection $names
     * @param string $search
     *
     * @return string|null
     */
    public function contains(Collection $names, string $search): ?string
    {
        $options = explode('|', $search);

        return $names->first(function ($name) use ($options) {
            return in_array($name, $options);
        });
    }

    /**
     * Reads ZIP file content and returns collection with result.
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function validateZipFile(UploadedFile $file): bool
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $zip = new ZipArchive();
        $zip->open($file->getPathname());
        for($i = 0;$i < $zip->count(); $i++) {
            var_dump($finfo->buffer($zip->getFromIndex($i)));
            if(!in_array($finfo->buffer($zip->getFromIndex($i)), ['application/pdf','application/octet-stream'])){
                $this->mimeType = $finfo->buffer($zip->getFromIndex($i));
                $zip->close();
                return false;
            }
            print_r('file_1 :: ');
            var_dump($finfo->buffer($zip->getFromIndex($i)));
        }
    }

    private function getMimeTypes(String $fileTypes): array
    {
        return explode('|',$fileTypes);
    }
}