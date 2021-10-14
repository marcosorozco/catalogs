<?php

namespace Marcosorozco\Catalogs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogAbstract;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogRepositoryInterface;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogTO;

class CatalogCodeValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $catalog_code = $request->catalog_code;
        $catalogTO = new CatalogTO();
        $catalogTO->setCode($catalog_code);
        $catalogRepository = resolve(CatalogRepositoryInterface::class);
        $catalogRepository->searchCatalogByCode($catalogTO);
        $catalog = $catalogRepository->searchCatalogByCode($catalogTO);
        if (is_null($catalog))
            throw new \Exception('Error: The code not exists on catalogs table');
        if (!((new $catalog->class()) instanceof CatalogAbstract))
            throw new \Exception("Error: The class {$catalog->class} not implement ".CatalogAbstract::class);
        return $next($request);
    }
}