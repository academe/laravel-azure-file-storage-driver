<?php

namespace Academe\Laravel\AzureFileStorageDriver;

use Storage;
use League\Flysystem\Filesystem;

use Consilience\Flysystem\Azure\AzureFileAdapter;
use MicrosoftAzure\Storage\File\FileRestProxy;
use Illuminate\Support\ServiceProvider as ServiceProviderContract;

class ServiceProvider extends ServiceProviderContract
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Storage::extend('azure-file-storage', function ($app, $config) {
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

            $driverOptions = !empty($config['driverOptions'])
                ? $config['driverOptions']
                : null;

            return new Filesystem(
                new AzureFileAdapter(
                    $fileService,
                    $driverConfig,
                    $driverOptions
                )
            );
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
