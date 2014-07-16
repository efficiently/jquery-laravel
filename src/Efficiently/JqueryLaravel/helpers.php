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
     *
     * Based on \Form::model() with default 'id' and 'class' HTML attributes
     * get with form_id() and dom_class() helpers
     *
     * @param mixed   $model
     * @param array   $options
     * @param  string $fallbackPrefix By default it's 'create'
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

// if (! function_exists('former_for')) {
//
//     function former_for()
//     {
//         // TODO
//     }
// }

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

if (! function_exists('render_view')) {

    /**
     * Render a view, useful in your Blade templates
     *
     * {{ render_view('view.name') }}
     * {{ render_view('view.name', ['some'=>'data']) }}
     *
     * @param  string  $route Route name
     * @param  array   $parameters Optional array of data to the rendered view
     * @return string
     */
    function render_view($route, $parameters = [])
    {
        return View::make($route, $parameters, array_except(get_defined_vars(), ['__data', '__path']))->render();
    }
}
