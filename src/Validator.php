<?php


namespace Hamaelt\ZipValidator;

use finfo;
use Hamaelt\ZipValidator\Exception\InvalidFileTypeException;
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
     * @var finfo
     */
    private finfo $finfo;

    /**
     * @var ZipArchive
     */
    private ZipArchive $zip;

    /**
     * Validator constructor.
     *
     * @param string $fileTypes
     */
    public function __construct(string $fileTypes)
    {
        $this->finfo = new finfo(FILEINFO_MIME_TYPE);
        $this->zip = new ZipArchive();
        try {
            $this->allowedMimeTypes = $this->getMimeTypes($fileTypes);
        } catch (\Exception $exception) {
            throw new InvalidFileTypeException('Invalid File type provided.');
        }
    }


    /**
     * Reads ZIP file content and returns collection with result.
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function validateZipFile(UploadedFile $file): bool
    {
        $mimeTypes = $this->getUploadedFileMimeTypes($file);

        return $mimeTypes->every(fn (string $mimeType) => in_array($mimeType, $this->allowedMimeTypes));
    }

    private function getUploadedFileMimeTypes(UploadedFile $file): Collection
    {
        $mimeTypes = collect([]);
        $this->zip->open($file->getPathname());
        for ($i = 0; $i < $this->zip->count(); $i++) {
            $mimeTypes->push($this->finfo->buffer($this->zip->getFromIndex($i)));
        }

        return $mimeTypes->filter(fn (string $mimeType) => $mimeType !== 'application/octet-stream');
    }

    private function getMimeTypes(string $fileTypes): array
    {
        $types = explode(',', $fileTypes);
        foreach ($types as $type) {
            $this->allowedMimeTypes[] = MimeTypes::$mimeTypes[$type];
        }
        $this->allowedMimeTypes[] = 'application/octet-stream';

        return $this->allowedMimeTypes;
    }
}
