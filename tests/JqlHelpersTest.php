<?php

use Mockery as m;

class JqlHelpersTest extends JqlTestCase
{
    public function testdomId()
    {
        // New Project
        $project = new Jql\Project;

        $domId = dom_id($project);
        $expect = 'create_project';
        $this->assertEquals($expect, $domId);

        $expect2 = 'project_2';
        $this->assertNotEquals($expect2, $domId);

        // Existing Project
        $project2 = clone $project;
        $project2->id = 2;
        $project2->exists = true;

        $domId2 = dom_id($project2);
        $this->assertEquals($expect2, $domId2);
    }

    public function testFormId()
    {
        // New Project
        $project = new Jql\Project;

        $formId = form_id($project);
        $expect = 'create_project';
        $this->assertEquals($expect, $formId);

        $expect2 = 'edit_project_3';
        $this->assertNotEquals($expect2, $formId);

        // Existing Project
        $project2 = clone $project;
        $project2->id = 3;
        $project2->exists = true;

        $formId2 = form_id($project2);
        $this->assertEquals($expect2, $formId2);
    }

    public function testFormFor()
    {
        Route::resource('projects', 'ProjectsController');

        // New Project
        $project = new Jql\Project;

        $form = form_for($project);
        $expect = '<form method="POST" action="http://localhost/projects" accept-charset="UTF-8" id="create_project" class="create_project">'.
            '<input name="_token" type="hidden">';
        $this->assertEquals($expect, $form);

        $expect2 = '<form method="POST" action="http://localhost/projects/3" accept-charset="UTF-8" id="edit_project_3" class="edit_project">'.
            '<input name="_method" type="hidden" value="PATCH"><input name="_token" type="hidden">';
        $this->assertNotEquals($expect2, $form);

        // Existing Project
        $project2 = clone $project;
        $project2->id = 3;
        $project2->exists = true;

        $form2 = form_for($project2);
        $this->assertEquals($expect2, $form2);
    }

    public function testFormerFor()
    {
        Route::resource('projects', 'ProjectsController');
        $this->createSession();

        // New Project
        $project = new Jql\Project;

        $former = former_for($project);
        $expect = '<form accept-charset="utf-8" class="form-horizontal create_project" id="create_project" method="POST" action="http://localhost/projects">';
        $this->assertEquals($expect, $former);

        $expect2 = '<form accept-charset="utf-8" class="form-horizontal edit_project" id="edit_project_3" method="POST" action="http://localhost/projects/3">'.
            '<input class="form-control" type="hidden" name="_method" value="PATCH">';
        $this->assertNotEquals($expect2, $former);

        // Existing Project
        $project2 = clone $project;
        $project2->id = 3;
        $project2->exists = true;

        $former2 = (string) former_for($project2);
        $this->assertEquals($expect2, $former2);
    }

    public function testButtonTo()
    {
        Route::resource('projects', 'ProjectsController');

        // Create button
        $form = button_to('Create', ['action' => 'ProjectsController@create']);
        $expect = '<form method="POST" action="http://localhost/projects/create" accept-charset="UTF-8" class="button_to">'.
            '<input name="_token" type="hidden">'.
            '<div><input type="submit" value="Create"></div></form>';
        $this->assertEquals($expect, $form);

        $expect2 = '<form method="POST" action="http://www.example.com" accept-charset="UTF-8" class="button_to" data-remote="true"><input name="_method" type="hidden" value="DELETE">'.
            '<input name="_token" type="hidden">'.
            '<div><input data-confirm="Are you sure?" data-disable-with="loading..." type="submit" value="Destroy"></div></form>';
        $this->assertNotEquals($expect2, $form);

        // Destroy Button
        $form2 = button_to(
            'Destroy',
            [
                'url' => 'http://www.example.com',
                'method' => 'delete',
                'data-remote' => 'true',
                'data-confirm' => 'Are you sure?',
                'data-disable-with' => 'loading...'
            ]
        );
        $this->assertEquals($expect2, $form2);
    }
}
