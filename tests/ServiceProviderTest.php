<?php

namespace Academe\Laravel\AzureFileStorageDriver;

use Orchestra\Testbench\TestCase;
use Storage;

class ServiceProviderTest extends TestCase
{
    /**
     * Get an array of directories from the API.
     * Array may be empty, but will not be null.
     */
    public function testDirectories()
    {
        $this->assertNotNull(
            Storage::disk('azure-files')->directories()
        );
    }

    /**
     * Attempt to get a file that doesn't exist.
     * This is actually testing the Flysystem driver more than
     * anything, but I kind of need to know this is working.
     *
     * @expectedException League\Flysystem\FileNotFoundException
     */
    public function testMissingFile()
    {
        $this->assertNotNull(
            Storage::disk('azure-files')->read(md5(rand(100000, 999999)))
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Use .env.example to create and configure .env
     */
    protected function getEnvironmentSetUp($app)
    {
        if (file_exists(__DIR__ . '/../.env')) {
            (new \Dotenv\Dotenv(__DIR__ . '/..'))->load();
        }

        $app['config']->set('filesystems.disks.azure-files', [
            'driver' => ServiceProvider::DRIVER_NAME,
            'storageAccount' => env('AZURE_FILE_STORAGE_ACCOUNT'),
            'storageAccessKey' => env('AZURE_FILE_STORAGE_ACCESS_KEY'),
            'fileShareName' => env('AZURE_FILE_STORAGE_SHARE_NAME'),
            'disableRecursiveDelete' => false,
            'driverOptions' => [],
        ]);
    }
}
