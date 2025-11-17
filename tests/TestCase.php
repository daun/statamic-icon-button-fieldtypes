<?php

namespace Tests;

use Daun\StatamicIconButtons\ServiceProvider as AddonServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Addons\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;
use Tests\Concerns\PreventSavingStacheItemsToDisk;
use Tests\Concerns\ResolvesStatamicConfig;
use Wilderborn\Partyline\ServiceProvider as PartyLineServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    use PreventSavingStacheItemsToDisk;
    use ResolvesStatamicConfig;

    protected function getPackageProviders($app)
    {
        return [
            AddonServiceProvider::class,
            PartyLineServiceProvider::class,
            StatamicServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        // Custom view directory
        $app['config']->set('view.paths', [fixtures_path('views')]);

        // Pull in statamic default config
        $this->resolveStatamicConfiguration($app);

        // Rewrite content paths to use our test fixtures
        $this->resolveStacheStores($app);

        // Set user repository to default flat file system
        $app['config']->set('statamic.users.repository', 'file');

        // Assume pro edition for our tests
        $app['config']->set('statamic.editions.pro', true);
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $this->registerStatamicAddon($app);
    }

    protected function registerStatamicAddon($app)
    {
        $reflector = new \ReflectionClass(AddonServiceProvider::class);
        $directory = dirname($reflector->getFileName());

        $providerParts = explode('\\', AddonServiceProvider::class, -1);
        $namespace = implode('\\', $providerParts);

        $json = json_decode($app['files']->get($directory.'/../composer.json'), true);
        $statamic = $json['extra']['statamic'] ?? [];
        $autoload = $json['autoload']['psr-4'][$namespace.'\\'];

        $app->make(Manifest::class)->manifest = [
            $json['name'] => [
                'id' => $json['name'],
                'slug' => $statamic['slug'] ?? null,
                'version' => 'dev-main',
                'namespace' => $namespace,
                'autoload' => $autoload,
                'provider' => AddonServiceProvider::class,
            ],
        ];
    }
}
