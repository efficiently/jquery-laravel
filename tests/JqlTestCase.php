<?php

use Mockery as m;

abstract class JqlTestCase extends Orchestra\Testbench\TestCase
{
    protected $app;
    protected $router;

    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    protected function createSession()
    {
        // Mock session
        $setSessionMethod = method_exists(app('request'), 'setLaravelSession') ? 'setLaravelSession' : 'setSession';
        app('request')->$setSessionMethod(
            new Illuminate\Session\Store(
                'name',
                m::mock('SessionHandlerInterface'),
                'aaaa'
            )
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            'Collective\Html\HtmlServiceProvider',
            'Former\FormerServiceProvider',
            'Efficiently\JqueryLaravel\JqueryLaravelServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form'      => 'Collective\Html\FormFacade',
            'HTML'      => 'Collective\Html\HtmlFacade',
            'Former'    => 'Former\Facades\Former',
        ];
    }
}
