<?php namespace Jql\Http\Controllers;

use Jql\Project;
use Response;

class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param \Jql\Project        $projectModel
     * @param string|null|boolean $layout Default to null.
     * @param string              $format Default to 'html'.
     * @return Response
     */
    public function index(Project $projectModel, $layout = null, $format = 'html')
    {
        $projects = $projectModel->all();

        switch ($format) {
            case 'js':
                $render = $this->render(['js' => 'projects.index'], compact('projects'));
                break;
            case 'html':
            default:
                // No js fallback
                if (is_null($layout)) {
                    // default layout
                    $render = $this->render('projects.index', compact('projects'));
                } elseif ($layout === false) {
                    // no layout
                    $render = $this->render('projects.index_standalone', compact('projects'), $layout);
                } else {
                    // custom layout
                    $render = $this->render('projects.index', compact('projects'), $layout);
                }
                break;
        }

        return $render;
    }
}
