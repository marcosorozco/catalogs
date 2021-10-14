<?php

namespace Marcosorozco\Catalogs\Sources\Catalogs;

use Illuminate\Database\QueryException;
use Marcosorozco\Catalogs\Models\Catalogs\Catalog;

class CatalogRepository implements CatalogRepositoryInterface
{

    public function searchCatalogByCode(CatalogTO $catalogTO)
    {
        return Catalog::where('code', $catalogTO->getCode())->first();
    }

    public function searchDataByCatalogoCode(CatalogTO $catalogTO)
    {
        $catalog = $this->searchCatalogByCode($catalogTO);
        $model = $catalog->class::query();
        if ($catalogTO->getFilterSearch()) {
            $model->filterSearch();
        }
        if ($catalogTO->getPagination()) {
            return  $model->paginate($catalogTO->getPagination());
        }
        return $model->get();
    }

    public function findRow(CatalogTO $catalogTO, Catalog $catalog = null)
    {
        if (is_null($catalog))
            $catalog = $this->searchCatalogByCode($catalogTO);
        return $catalog->class::find($catalogTO->getTableId());
    }

    public function deleteRow(CatalogTO $catalogTO)
    {
        $catalog = $this->searchCatalogByCode($catalogTO);
        $data = $this->findRow($catalogTO, $catalog);
        try {
            $data->forceDelete();
        } catch (QueryException $error) {
            $errorCode = $error->errorInfo[1];
            if($errorCode != 1454){
                throw $error;
            }
            $catalog->class::destroy($catalogTO->getTableId());
        }
    }

    public function saveRow(CatalogTO $catalogTO)
    {
        $catalog = $this->searchCatalogByCode($catalogTO);
        $data = $catalog->class::create($catalogTO->getArrayData());
        $catalogTO->setTableId($data->id);
    }

    public function updateRow(CatalogTO $catalogTO)
    {
        $catalog = $this->searchCatalogByCode($catalogTO);
        $catalog->class::where('id', $catalogTO->getTableId())->update($catalogTO->getArrayData());
    }

    public function restoreRow(CatalogTO $catalogTO)
    {
        $data = $this->findRow($catalogTO);
        $data->restore();
    }
}