# Azure File Storage Filesystem Driver for Laravel 5

Still under development, but fundtional.

## Installation

TODO: Laravel 5.5+ and earlier versions.

## Configuration in `config/filesystems.php`:

```php
[
    ...
    'disks' => [
        ...
        // Name this disk for your application to reference.
        'azure-file-storage' => [
            // The driver provided by this package.
            'driver' => 'azure-file-storage',

            // Account credentials.
            'storageAccount' => env('AZURE_FLE_STORAGE_ACCOUNT'),
            'storageAccessKey' => env('AZURE_FLE_STORAGE_ACCESS_KEY'),

            // The file share.
            // This driver supports one file share at a time (you cannot
            // copy or move files between shares natively).
            'fileShareName' => env('AZURE_FLE_STORAGE_SHARE_NAME'),

            // Optional settings
            'disableRecursiveDelete' => false,
            'driverOptions' => [],
        ],
    ]
];
```

## Usage

See [the Laravel documentation](https://laravel.com/docs/5.5/filesystem)
for general usage of a file system in Laravel.
A simple example follows:

```
use Storage;

// List all files recursively from the root of the Azure share:

$files = Storage::disk('azure-file-storage')->listAll();

// Example:
// array:25 [▼
//   0 => "file1.txt"
//   1 => "foo/file2.txt"
//   2 => "foo/dee/dar/bigfile.txt"
// ]
```

