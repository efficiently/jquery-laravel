<?php

use Mockery as m;

abstract class JqlTestCase extends Orchestra\Testbench\TestCase
{
    protected $app;
    protected $router;

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    protected function mock($className)
    {
        $mock = m::mock($className);
        App::bind($className, function ($app, $parameters = []) use ($mock) {
            if (is_array($parameters) && is_array($attributes = array_get($parameters, 0, [])) && respond_to($mock, "fill")) {
                $mock = $this->fillMock($mock, $attributes);
            }

            return $mock;
        });

        return $mock;
    }

    protected function fillMock($mock, $attributes = [])
    {
        $instance = $mock->makePartial();
        foreach ($attributes as $key => $value) {
            $instance->$key = $value;
        }

        return $instance;
    }

    protected function createSession()
    {
        // Fake session
        app('request')->setSession(
            new \Illuminate\Session\Store(
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
            // 'HTMLEloquentHelper' => 'Efficiently\JqueryLaravel\Facades\HTMLEloquentHelper',
        ];
    }
}
