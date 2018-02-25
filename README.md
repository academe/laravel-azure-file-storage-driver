
## Configuration in `config/filesystems.php`:

```php
[
    ...
    'disks' => [
        ...
        // Call this disk what you like.
        'azure-file-storage' => [
            // This driver.
            'driver' => 'azure-file-storage',

            // Account credentials.
            'storageAccount' => env('AZURE_FLE_STORAGE_ACCOUNT'),
            'storageAccessKey' => env('AZURE_FLE_STORAGE_ACCESS_KEY'),

            // The file share.
            // This driver supports one file share at a time (you cannot
            // copy or move files between shares natively).
            'fileShareName' => env('AZURE_FLE_STORAGE_HARE_NAME'),

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

