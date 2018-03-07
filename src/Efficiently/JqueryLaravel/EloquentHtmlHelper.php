<?php

namespace Efficiently\JqueryLaravel;

class EloquentHtmlHelper
{
    /**
     * The DOM id convention is to use the singular form of an object or class with the id following an underscore.
     * If no id is found, prefix with "create_" instead.
     *
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @param  string  $prefix
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    public function domId($record, $prefix = null, $fallbackPrefix = 'create')
    {
        if ($recordId = $this->recordKeyForDomId($record)) {
            return $this->domClass($record, $prefix).'_'.$recordId;
        } else {
            $prefix = $prefix ?: $fallbackPrefix;
            return $this->domClass($record, $prefix);
        }
    }

    /**
     * The Form id convention is to use the singular form of an object or class with the id following an underscore.
     * If id is found, prefix with "edit_".
     * If no id is found, prefix with "create_" instead.
     *
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    public function formId($record, $fallbackPrefix = 'create')
    {
        if ($recordId = $this->recordKeyForDomId($record)) {
            return $this->domClass($record, 'edit').'_'.$recordId;
        }

        return $this->domClass($record, $fallbackPrefix);
    }

    /**
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @return string
     */
    public function recordKeyForDomId($record)
    {
        $key = is_a($record, '\Illuminate\Database\Eloquent\Model') ? $record->getKey() : null;

        return $key ? implode('_', (array) $key) : $key;
    }

    /**
     * The DOM class convention is to use the singular form of an object or class.
     *
     * @param  string|object|\Illuminate\Database\Eloquent\Model $recordOrClass
     * @param  string  $prefix
     * @return string
     */
    public function domClass($recordOrClass, $prefix = null)
    {
        $singular = snake_case(camel_case(preg_replace('/\\\\/', ' ', $this->modelNameFromRecordOrClassname($recordOrClass))));
        return $prefix ? $prefix.'_'.$singular : $singular;
    }

    /**
     * @param  string|object|\Illuminate\Database\Eloquent\Model $recordOrClass
     * @return string
     */
    protected function modelNameFromRecordOrClassname($recordOrClass)
    {
        $modelName = is_string($recordOrClass) ? $recordOrClass : get_class($recordOrClass);
        $modelName = $this->removeRootNamespace($modelName);

        return $modelName;
    }

    /**
     * Remove Root namespace. E.G 'App\Message' -> 'Message'
     * @param string $classname
     */
    protected function removeRootNamespace($classname)
    {
        $namespaces = $this->splitNamespaces($classname);
        if (count($namespaces) > 1) {
            $classname = implode('\\', array_slice($namespaces, 1));
        }

        return $classname;
    }

    /**
     * @param string $classname
     * @return array
     */
    protected function splitNamespaces($classname)
    {
        return preg_split("/\\\\|\//", $classname);
    }
}
