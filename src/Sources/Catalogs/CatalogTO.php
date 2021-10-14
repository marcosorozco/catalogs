<?php

namespace Marcosorozco\Catalogs\Sources\Catalogs;

class CatalogTO
{
    private $id;
    private $code;
    private $title;
    private $description;
    private $class;
    private $user_id;
    private $pagination;
    private $table_id;
    private $arrayData;
    private $filter_search;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class): void
    {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param mixed $pagination
     */
    public function setPagination($pagination): void
    {
        $this->pagination = $pagination;
    }

    /**
     * @return mixed
     */
    public function getTableId()
    {
        return $this->table_id;
    }

    /**
     * @param mixed $table_id
     */
    public function setTableId($table_id): void
    {
        $this->table_id = $table_id;
    }

    /**
     * @return mixed
     */
    public function getArrayData()
    {
        return $this->arrayData;
    }

    /**
     * @param mixed $arrayData
     */
    public function setArrayData($arrayData): void
    {
        $this->arrayData = $arrayData;
    }

    /**
     * @return mixed
     */
    public function getFilterSearch()
    {
        return $this->filter_search;
    }

    /**
     * @param mixed $filter_search
     */
    public function setFilterSearch($filter_search): void
    {
        $this->filter_search = $filter_search;
    }
}