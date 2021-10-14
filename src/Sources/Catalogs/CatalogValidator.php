<?php

namespace Marcosorozco\Catalogs\Sources\Catalogs;

use Marcosorozco\Catalogs\Models\Catalogs\Catalog;

class CatalogValidator implements CatalogRepositoryInterface
{
    /**
     * @var CatalogRepository
     */
    private $catalogRepository;
    /**
     * @var CatalogValidation
     */
    private $catalogValidation;

    public function __construct(
        CatalogRepository $catalogRepository,
        CatalogValidation $catalogValidation
    ) {
        $this->catalogRepository = $catalogRepository;
        $this->catalogValidation = $catalogValidation;
    }

    public function searchCatalogByCode(CatalogTO $catalogTO)
    {
        return $this->catalogRepository->searchCatalogByCode($catalogTO);
    }

    public function searchDataByCatalogoCode(CatalogTO $catalogTO)
    {
        return $this->catalogRepository->searchDataByCatalogoCode($catalogTO);
    }

    public function deleteRow(CatalogTO $catalogTO)
    {
        $this->catalogRepository->deleteRow($catalogTO);
    }

    public function findRow(CatalogTO $catalogTO, Catalog $catalog = null)
    {
        return $this->catalogRepository->findRow($catalogTO, $catalog);
    }

    public function saveRow(CatalogTO $catalogTO)
    {
        $this->catalogValidation->validate($catalogTO);
        $this->catalogRepository->saveRow($catalogTO);
    }

    public function updateRow(CatalogTO $catalogTO)
    {
        $this->catalogValidation->validate($catalogTO);
        $this->catalogRepository->updateRow($catalogTO);
    }

    public function restoreRow(CatalogTO $catalogTO)
    {
        $this->catalogRepository->restoreRow($catalogTO);
    }
}