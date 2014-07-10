<?php namespace Efficiently\JqueryLaravel;

class EloquentHtmlHelper
{
    /**
     * The DOM id convention is to use the singular form of an object or class with the id following an underscore.
     * If no id is found, prefix with “create_” instead.
     *
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @param  string  $prefix
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    public function domId($record, $prefix = null, $fallbackPrefix = 'create')
    {
        if ($recordId = $this->recordKeyForDomId($record)) {
            return $this->domClass($record, $prefix, $fallbackPrefix).'_'.$recordId;
        } else {
            $prefix = $prefix ?: $fallbackPrefix;
            return $this->domClass($record, $prefix, $fallbackPrefix);
        }
    }

    /**
     * The Form id convention is to use the singular form of an object or class with the id following an underscore.
     * If id is found, prefix with “edit_”.
     * If no id is found, prefix with “create_” instead.
     *
     * @param  object|\Illuminate\Database\Eloquent\Model $record
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    public function formId($record, $fallbackPrefix = 'create')
    {
        if ($recordId = $this->recordKeyForDomId($record)) {
            return $this->domClass($record, 'edit', $fallbackPrefix).'_'.$recordId;
        } else {
            return $this->domClass($record, $fallbackPrefix);
        }
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
     * @param  string  $fallbackPrefix By default it's 'create'
     * @return string
     */
    public function domClass($recordOrClass, $prefix = null, $fallbackPrefix = 'create')
    {
        $singular = snake_case(camel_case(preg_replace('/\\\\/',' ', $this->modelNameFromRecordOrClassname($recordOrClass))));

        return $prefix ? $prefix.'_'.$singular : $singular;
    }

    /**
     * @param  string|object|\Illuminate\Database\Eloquent\Model $recordOrClass
     * @return string
     */
    protected function modelNameFromRecordOrClassname($recordOrClass)
    {
        return is_string($recordOrClass) ? $recordOrClass : get_classname($recordOrClass);
    }
}
