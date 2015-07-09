<?php

use Mockery as m;
use Jql\Project;
use Jql\Http\Controllers\ProjectsController;

class JqlControllerAdditionsTest extends JqlTestCase
{
    public function setUp()
    {
        parent::setUp();
        Route::resource('projects', 'ProjectsController');
        View::addLocation(__DIR__.'/fixtures/resources/views');

        $this->controller = new ProjectsController;
    }

    public function testRenderMethodWithDefaultLayout()
    {
        // New Project
        $project = new Project;
        $project->id = 2;
        $project->exists = true;
        $project->name = 'Project 2';
        $project->priority = 'low';

        $mock = $this->mockProject($project);
        $response = $this->controller->callAction('index', [$mock]);

        $expectDefaultLayout = '<title>jQuery-Laravel with default layout</title>';
        $expectProjectName = 'Project 2';

        $this->assertContains($expectDefaultLayout, $response->getContent());
        $this->assertNotContains($expectDefaultLayout.' foo', $response->getContent());
        $this->assertContains($expectProjectName, $response->getContent());
        $this->assertNotContains($expectProjectName.' foo', $response->getContent());
    }

    public function testRenderMethodWithCustomLayout()
    {
        // New Project
        $project = new Project;
        $project->id = 3;
        $project->exists = true;
        $project->name = 'Project 3';
        $project->priority = 'high';

        $mock = $this->mockProject($project);
        $response = $this->controller->callAction('index', [$mock, 'app2']);

        $expectDefaultLayout = '<title>jQuery-Laravel with custom layout</title>';
        $expectProjectName = 'Project 3';

        $this->assertContains($expectDefaultLayout, $response->getContent());
        $this->assertNotContains($expectDefaultLayout.' foo', $response->getContent());
        $this->assertContains($expectProjectName, $response->getContent());
        $this->assertNotContains($expectProjectName.' foo', $response->getContent());
    }

    public function testRenderMethodWithoutLayout()
    {
        // New Project
        $project = new Project;
        $project->id = 4;
        $project->exists = true;
        $project->name = 'Project 4';
        $project->priority = 'low';

        $mock = $this->mockProject($project);
        $response = $this->controller->callAction('index', [$mock, false]);

        $expectDefaultLayout = '<title>jQuery-Laravel without layout</title>';
        $expectProjectName = 'Project 4';

        $this->assertContains($expectDefaultLayout, $response->getContent());
        $this->assertContains($expectProjectName, $response->getContent());
        $this->assertNotContains($expectProjectName.' foo', $response->getContent());
    }

    public function testRenderMethodWithJSRequest()
    {
        // New Project
        $project = new Project;
        $project->id = 5;
        $project->exists = true;
        $project->name = 'Project 5';
        $project->priority = 'low';

        $mock = $this->mockProject($project);
        $response = $this->controller->callAction('index', [$mock, null, 'js']);

        $expectDefaultLayout = '<title>jQuery-Laravel tests</title>';
        $expectProjectJson = json_encode($project);

        $this->assertNotContains($expectDefaultLayout, $response->getContent());
        $this->assertContains($expectProjectJson, $response->getContent());
        $this->assertNotContains($expectProjectJson.' foo', $response->getContent());
    }

    protected function mockProject($project)
    {
        $mock = m::mock('Jql\Project');
        $mock->shouldReceive('all')->andReturn([$project]);

        return $mock;
    }
}
