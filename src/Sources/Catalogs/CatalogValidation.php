<?php

namespace Marcosorozco\Catalogs\Sources\Catalogs;

use Marcosorozco\Catalogs\Exceptions\ValidationException;

class CatalogValidation
{

    public function validate(CatalogTO $catalogTO)
    {
        $catalogRepository = resolve(CatalogRepositoryInterface::class);
        if ($catalogRepository instanceof CatalogRepositoryInterface) {
            $catalog = $catalogRepository->searchCatalogByCode($catalogTO);
            $validator = validator($catalogTO->getArrayData(), $catalog->class::getRules($catalogTO->getTableId()), $catalog->class::getMessages());
        }
        if ($validator->fails()) {
            throw new ValidationException('Error: Check Fields', $validator);
        }
    }
}