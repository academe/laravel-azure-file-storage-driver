
[![Latest Stable Version](https://poser.pugx.org/academe/laravel-azure-file-storage-driver/v/stable)](https://packagist.org/packages/academe/laravel-azure-file-storage-driver)
[![Total Downloads](https://poser.pugx.org/academe/laravel-azure-file-storage-driver/downloads)](https://packagist.org/packages/academe/laravel-azure-file-storage-driver)
[![Latest Unstable Version](https://poser.pugx.org/academe/laravel-azure-file-storage-driver/v/unstable)](https://packagist.org/packages/academe/laravel-azure-file-storage-driver)
[![GitHub license](https://img.shields.io/github/license/academe/laravel-azure-file-storage-driver.svg)](https://github.com/academe/laravel-azure-file-storage-driver/blob/master/LICENCE)
[![GitHub issues](https://img.shields.io/github/issues/academe/laravel-azure-file-storage-driver.svg)](https://github.com/academe/laravel-azure-file-storage-driver/issues)

# Microsoft Azure File Storage Filesystem Driver for Laravel 6, 7 and 9

This package allows Microsoft Azure File Storage
to be used as a filesystem in laravel 5 and 6.

## Installation

    composer require academe/laravel-azure-file-storage-driver

This package just extends the filesystem driver, and provides no additional services.

## Configuration

Add the following to your `config/filesystems.php`:

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
            'storageAccount' => env('AZURE_FILE_STORAGE_ACCOUNT'),
            'storageAccessKey' => env('AZURE_FILE_STORAGE_ACCESS_KEY'),

            // The file share.
            // This driver supports one file share at a time (you cannot
            // copy or move files between shares natively).
            'fileShareName' => env('AZURE_FILE_STORAGE_SHARE_NAME'),

            // Optional settings
            'disableRecursiveDelete' => false,
            'driverOptions' => [],
            'root' => 'root/directory', // Without leading '/'
        ],
    ],
];
```

If you want to use multiple Azure file storage shares, then create additional
entries in the `disks` array with the appropriate settings for each share.

An example list of environment variable entries can be found in `.env.example`.
You can add that to your `.env` file and add your credentials there.

## Usage

See [the Laravel documentation](https://laravel.com/docs/5.5/filesystem)
for general usage of a file system in Laravel.
A simple example follows:

```
use Storage;

// List all files recursively from the root of the Azure share:

$files = Storage::disk('azure-file-storage')->listAll();
dump($files);

// Example:
// array:25 [▼
//   0 => "file1.txt"
//   1 => "foo/file2.txt"
//   2 => "foo/dee/dar/bigfile.txt"
// ]
```

## Testing

PHPunit tests will work against any file storage share given
criteria set in `.env` based on `.env.example`.

