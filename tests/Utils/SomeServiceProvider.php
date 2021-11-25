<?php

declare(strict_types=1);

namespace OJullienTest\Utils;

use League\Container\ServiceProvider\AbstractServiceProvider;

class SomeServiceProvider extends AbstractServiceProvider
{
    /**
     * The provides method is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     *
     * @param string $id
     * @return boolean
     */
    public function provides(string $id): bool
    {
        /**
         * @var array<array-key,mixed>
         */
        $services = [
            'service1',
            'service2'
        ];

        return in_array($id, $services, \true);
    }

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     *
     * @return void
     */
    public function register(): void
    {
        // Register
        $this->getContainer()->add('service1', 'I_am_service_01');
        $this->getContainer()->add('service2', 'I_am_service_02');
    }
}
