<?php

if (! function_exists('dom_id')) {

    /**
     * The DOM id convention is to use the singular form of an object or class with the id following an underscore.
     * If no id is found, prefix with “create_” instead.
     *
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @param  string  $prefix
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    function dom_id($record, $prefix = null, $fallbackPrefix = 'create')
    {
        return Efficiently\JqueryLaravel\Facades\HTMLEloquentHelper::domId($record, $prefix, $fallbackPrefix);
    }
}

if (! function_exists('form_id')) {

    /**
     * The Form id convention is to use the singular form of an object or class with the id following an underscore.
     * If id is found, prefix with “edit_”.
     * If no id is found, prefix with “create_” instead.
     *
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    function form_id($record, $fallbackPrefix = 'create')
    {
        return Efficiently\JqueryLaravel\Facades\HTMLEloquentHelper::formId($record, $fallbackPrefix);
    }
}

if (! function_exists('form_for')) {

    /**
     * Create a new model based form builder.
     * And adding a CSRF Token
     *
     * Based on \Form::model() with default 'id' and 'class' HTML attributes
     * get with form_id() and dom_class() helpers
     *
     * @param mixed   $model
     * @param array   $options 'fallbackPrefix' option is 'create' by default
     * @return string
     */
    function form_for($model, array $options = [])
    {
        $prefix = array_get($options, 'prefix');
        $fallbackPrefix = array_get($options, 'fallbackPrefix', 'create');
        
        if (! array_get($options, 'id')) {
            $options['id'] = form_id($model, $fallbackPrefix);
        }
        
        if (! array_get($options, 'class')) {
            $options['class'] = dom_class($model, $prefix, $fallbackPrefix);
        }
        
        return Form::model($model, $options);
    }
}

if (! function_exists('form_for_close')) {

    /**
     * Close the current form.
     *
     * Alias of \Form::close()
     *
     * @return string
     */
    function form_for_close()
    {
        return Form::close();
    }
}

if (! function_exists('former_for')) {

    /**
     * Create a new model based former builder.
     *
     * Based on \Former::open() with default 'id' and 'class' HTML attributes
     * get with form_id() and dom_class() helpers
     *
     * @param mixed  $model
     * @param array  $options 'fallbackPrefix' option is 'create' by default
     * @return \Former|string|null
     */
    function former_for($model, array $options = [])
    {
        if (class_exists("\Former")) {
            $prefix = array_get($options, 'prefix');
            $fallbackPrefix = array_get($options, 'fallbackPrefix', 'create');
            
            if (! array_get($options, 'id')) {
                $options['id'] = form_id($model, $fallbackPrefix);
            }
            
            if (! array_get($options, 'class')) {
                $options['class'] = dom_class($model, $prefix, $fallbackPrefix);
            }
            
            // $id = array_pull($options, 'id');
            $class = array_pull($options, 'class');
        
            return Former::open()/*->id($id)*/->addClass($class)->setAttributes($options);         
        }
    }
}

if (! function_exists('former_for_close'))  {

    /**
     * Adding a CSRF Token and close the current form.
     *
     * Alias of \Former::close()
     *
     * @return string|null
     */
    function former_for_close()
    {
        if (class_exists("\Former")) {
            return Former::close();
        }
    }
}



if (! function_exists('record_key_for_dom_id')) {

    /**
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @return string
     */
    function record_key_for_dom_id($record)
    {
        return Efficiently\JqueryLaravel\Facades\HTMLEloquentHelper::recordKeyForDomId($record);
    }
}

if (! function_exists('dom_class')) {

    /**
     * The DOM class convention is to use the singular form of an object or class.
     *
     * @param  string|object|\Illuminate\Database\Eloquent\Model $recordOrClass
     * @param  string  $prefix
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    function dom_class($recordOrClass, $prefix = null, $fallbackPrefix = 'create')
    {
        return Efficiently\JqueryLaravel\Facades\HTMLEloquentHelper::domClass($recordOrClass, $prefix, $fallbackPrefix);
    }
}


if (! function_exists('button_to')) {

    /**
     * Generates a form containing a single button that submits to the URL created by the set of options.
     *
     * Based on \Form::open(), \Form::submit() and \Form::close()
     * 
     * @param string $name
     * @param array  $options There are a few special options:
     * 'url' - open forms that point to named URL. E.G. ['url' => 'foo/bar']
     * 'route' - open forms that point to named routes. E.G. ['route' => 'route.name']
     * 'action' -  - open forms that point to controller actions. E.G. ['action' => 'Controller@method']
     * 'method' - HTTP verb. Supported verbs are 'post', 'get', 'delete', 'patch', and 'put'. By default it will be 'post'.
     * 'data-remote' - If set to true, will allow the Unobtrusive JavaScript drivers to control the submit behavior. By default this behavior is an ajax submit.
     * 'form' - This array will be form attributes
     * 'formClass' - This controls the class of the form within which the submit button will be placed. By default it will be 'button_to'.
     * @return string
     */
    function button_to($name, array $options = [])
    {
     
        $formOptions = [
            'method' => array_pull($options, 'method', 'post'),
            'class' => array_pull($options, 'formClass', 'button_to')
        ];
        if (array_get($options, 'url')) {
            $formOptions['url'] = array_pull($options, 'url');
        }
        if (array_get($options, 'route')) {
            $formOptions['route'] = array_pull($options, 'route');
        }
        if (array_get($options, 'action')) {
            $formOptions['action'] = array_pull($options, 'action');
        }
        if (array_get($options, 'data-remote')) {
            $formOptions['data-remote'] = array_pull($options, 'data-remote');
        }
        $formOptions = array_merge($formOptions, array_pull($options, 'form', []));

        return Form::open($formOptions).'<div>'.Form::submit($name, $options).'</div>'.Form::close();
    }
}

if (! function_exists('render_view')) {

    /**
     * Render a view, useful in your Blade templates
     *
     * {{ render_view('view.name') }}
     * {{ render_view('view.name', ['some'=>'data']) }}
     *
     * @param  string  $route Route name
     * @param  array   $parameters Optional array of data to the rendered view
     * @param  string  $section Section name to yield
     * @return string
     */
    function render_view($route, $parameters = [], $section = null)
    {
        $view =  View::make($route, $parameters, array_except(get_defined_vars(), ['__data', '__path']))->render();
        if ($section) {
            $view = $view.View::yieldContent($section);
        }
        
        return $view;
    }
}
