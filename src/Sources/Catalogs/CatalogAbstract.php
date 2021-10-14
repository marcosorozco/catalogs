<?php

namespace Marcosorozco\Catalogs\Sources\Catalogs;

use Illuminate\Database\Eloquent\Model;

abstract class CatalogAbstract extends Model
{
    static public function getPaginationEloquest()
    {
        return 5;
    }

    public function scopeFilterSearch($query)
    {
        foreach(static::getFieldsForm() as $name=>$field) {
            if(!($field['hidden'] ?? false)) {
                $query->when(
                    request($name.'_search'),
                    function ($query) use ($name) {
                        $query->where($name, 'like', '%'.request($name.'_search').'%');
                    }
                );
            }
        }
        return $query;
    }

    public static function getRules($id) : array
    {
        return [];
    }

    public function getMessages(): array
    {
        return [];
    }

    /**
     * example
     *
     * 'name' => ['name'=>'Name', 'type' => 'string'],
     * 'email' => ['name'=>'Email', 'type' => 'email'],
     * 'password' => ['name'=>'Password', 'type' => 'password', 'hidden' => true, 'value' => false],
     * 'password_confirmation' => ['name'=>'Password', 'type' => 'password', 'hidden' => true, 'value' => false, 'save' => false],
     * 'user_id' => ['name'=>'User', 'save'=> false, 'relation'=>'user', 'relation_field'=>'name', 'type' => ['collection', 'model' => User::class, 'key' => 'id', 'value'=>'name']]
     * 'user' => ['name'=>'Usuario','type' => 'show', 'value'=> function ($product) {return $product->user->name;}]
     *
     * Name of properti
     * 'user_id' => [
     *      'name'=>'Usuario',                  --> Name to show on input
     *      'relation'=>'user',                 --> Name to show relation on table
     *      'relation_field'=>'name',           --> property of relation
     *      'save' => false,                    --> No save value
     *      'hidden' => true,                   --> Not show variable on index
     *      'value' => false                    --> Not show value on form
     *      'type' => [                         --> The type of field (string|input or array|select)
     *          'collection' => collect(),      --> data rows
     *          'model' => User::class,         --> class to extrac data
     *          'key' => 'id', 'value'=>'name'  --> values of select
     *      ]
     * ]
     * Describe fields of form
     * @return mixed
     */
    abstract public static function getFields() : array ;

    /**
     * [
     *      'user_id' => auth()->id(),
     *      'updated_user_id' => auth()->id()
     * ]
     * @return array
     */
    public static function getDefaultValuesCreate() : array
    {
        return [];
    }

    /**
     * [
     *      'updated_user_id' => auth()->id()
     * ]
     * @return array
     */
    public static function getDefaultValuesUpdate() : array
    {
        return [];
    }

    public static function getFieldsForm() : array
    {
        return array_filter(
            static::getFields(),
            function ($elemento) {
                return $elemento['type'] != 'show';
            }
        );
    }

    public static function getActionsLink(CatalogAbstract $data = null) : array
    {
        return [];
    }
}
