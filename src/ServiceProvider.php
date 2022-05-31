<?php

namespace Academe\Laravel\AzureFileStorageDriver;

/**
 * laravel Service Provider.
 */

use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Consilience\Flysystem\Azure\AzureFileAdapter;
use Illuminate\Support\Facades\Storage;
use MicrosoftAzure\Storage\File\FileRestProxy;
use Illuminate\Support\ServiceProvider as AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string The name of the driver.
     */
    const DRIVER_NAME = 'azure-file-storage';

    /**
     * Bootstrap the application services.
     * Extend the storage filesystem with the new driver.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend(self::DRIVER_NAME, function ($app, $config) {
            $connectionString = sprintf(
                'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
                $config['storageAccount'],
                $config['storageAccessKey']
            );

            $driverConfig = [
                'endpoint' => $connectionString,
                'container' => $config['fileShareName'],
                'disableRecursiveDelete' => !empty($config['disableRecursiveDelete']),
            ];

            $fileService = FileRestProxy::createFileService(
                $connectionString,
                [] // $optionsWithMiddlewares
            );

            $directoryPrefix = '';

            if (! empty($config['driverOptions'])) {
                // If a string, then treat it like a prefix for legacy support.

                if (is_string($config['driverOptions'])) {
                    $directoryPrefix = $config['driverOptions'];
                }

                if (is_array($config['driverOptions'])) {
                    $driverConfig = array_merge($driverConfig, $config['driverOptions']);
                }
            }

            if (! empty($config['root']) && is_string($config['root'])) {
                $directoryPrefix = $config['root'];
            }

            $adapter = new AzureFileAdapter(
                $fileService,
                $config['fileShareName'],
                $driverConfig,
                $directoryPrefix,
            );

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config,
            );
        });
    }
}
