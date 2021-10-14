<?php

namespace Marcosorozco\Catalogs\Sources\Catalogs;

use Marcosorozco\Catalogs\Models\Catalogs\Catalog;

interface CatalogRepositoryInterface
{
    public function searchCatalogByCode(CatalogTO $catalogTO);

    public function searchDataByCatalogoCode(CatalogTO $catalogTO);

    public function deleteRow(CatalogTO $catalogTO);

    public function findRow(CatalogTO $catalogTO, Catalog $catalog = null);

    public function saveRow(CatalogTO $catalogTO);

    public function updateRow(CatalogTO $catalogTO);

    public function restoreRow(CatalogTO $catalogTO);
}