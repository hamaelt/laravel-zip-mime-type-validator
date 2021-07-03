# laravel-zip-mime-type-validator
A validation rule for validating MIME type of zip files for Laravel to validate that the zip file only contains the allowed file types.


# Installation

```bash
$ composer require hamaelt/zip-mime-type-validator
```

# Requirement

- PHP **7.4** or higher

# Usage

In your custom request class use `ZipMimeType` rule with passing the required file types as a string.

``` php
use Hamaelt\ZipValidator\Rules\ZipMimeType;;

public function rules()
{
    return [
        'zip_file' => [ 'required',new ZipMimeType('pdf,jpg,png')],
    ];
}
```
