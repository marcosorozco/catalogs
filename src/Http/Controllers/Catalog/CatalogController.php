<?php

namespace Marcosorozco\Catalogs\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Marcosorozco\Catalogs\Exceptions\ValidationException;
use Marcosorozco\Catalogs\Http\Controllers\Controller;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogRepositoryInterface;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogTO;

class CatalogController extends Controller
{
    /**
     * @var CatalogRepositoryInterface
     */
    private $catalogRepository;

    /**
     * @param CatalogRepositoryInterface $catalogRepository
     */
    public function __construct(
        CatalogRepositoryInterface $catalogRepository
    ) {
        $this->middleware(array_merge(['catalog-code-valid', 'web'], Config::get('catalog.middleware', [])));
        $this->catalogRepository = $catalogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $catalog_code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($catalog_code)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setCode($catalog_code);
        $catalogTO->setFilterSearch(true);
        $catalog = $this->catalogRepository->searchCatalogByCode($catalogTO);
        $catalogTO->setPagination($catalog->class::getPaginationEloquest());
        $dataRows = $this->catalogRepository->searchDataByCatalogoCode($catalogTO);

        return view(
            'catalogs.index',
            compact(
                'catalog',
                'dataRows'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $catalog_code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($catalog_code)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setCode($catalog_code);
        $catalog = $this->catalogRepository->searchCatalogByCode($catalogTO);
        return view(
            'catalogs.create',
            compact(
                'catalog'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $catalog_code
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($catalog_code, Request $request)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setCode($catalog_code);
        $catalog = $this->catalogRepository->searchCatalogByCode($catalogTO);
        $catalogTO->setArrayData(
            array_merge(
                $request->only(
                    array_keys(
                        array_filter(
                            $catalog->class::getFieldsForm(),
                            function ($elemento) {
                                return !isset($elemento['save']) || $elemento['save'] != false;
                            }
                        )
                    )
                ),
                $catalog->class::getDefaultValuesCreate()
            )
        );
        try {
            $this->catalogRepository->saveRow($catalogTO);
        } catch (ValidationException $error) {
            return redirect()
                ->back()
                ->with('message', $error->getMessage())
                ->withErrors($error->getErrors());
        }
        return redirect()
            ->route('catalogs.index', ['catalog_code'=> $catalog_code])
            ->with('message', 'Elemento guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($catalog_code, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $catalog_code
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($catalog_code, $id)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setTableId($id);
        $catalogTO->setCode($catalog_code);
        $catalog = $this->catalogRepository->searchCatalogByCode($catalogTO);
        $data = $this->catalogRepository->findRow($catalogTO, $catalog);
        return view(
            'catalogs.edit',
            compact(
                'catalog',
                'data'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $catalog_code
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($catalog_code, Request $request, $id)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setCode($catalog_code);
        $catalogTO->setTableId($id);
        $catalog = $this->catalogRepository->searchCatalogByCode($catalogTO);
        $catalogTO->setArrayData(
            array_merge(
                $request->only(
                    array_keys(
                        array_filter(
                            $catalog->class::getFieldsForm(),
                            function ($elemento) {
                                return !isset($elemento['save']) || $elemento['save'] != false;
                            }
                        )
                    )
                ),
                $catalog->class::getDefaultValuesUpdate()
            )
        );
        try {
            $this->catalogRepository->updateRow($catalogTO);
        } catch (ValidationException $error) {
            return redirect()
                ->back()
                ->with('message', $error->getMessage())
                ->withErrors($error->getErrors());
        }
        return redirect()
            ->route('catalogs.index', ['catalog_code'=> $catalog_code])
            ->with('message', 'Elemento actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $catalog_code
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($catalog_code, $id)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setTableId($id);
        $catalogTO->setCode($catalog_code);
        try {
            $this->catalogRepository->deleteRow($catalogTO);
        } catch (ValidationException $error) {
            return redirect()
                ->back()
                ->with('message', $error->getMessage())
                ->withErrors($error->getErrors());
        }
        return redirect()
            ->route('catalogs.index', ['catalog_code'=> $catalog_code])
            ->with('message', 'Elemento eliminado');
    }

    /**
     * Restore the specified row.
     * @param $catalog_code
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($catalog_code, $id)
    {
        $catalogTO = new CatalogTO();
        $catalogTO->setTableId($id);
        $catalogTO->setCode($catalog_code);
        try {
            $this->catalogRepository->restoreRow($catalogTO);
        } catch (ValidationException $error) {
            return redirect()
                ->back()
                ->with('message', $error->getMessage())
                ->withErrors($error->getErrors());
        }
        return redirect()
            ->route('catalogs.index', ['catalog_code'=> $catalog_code])
            ->with('message', 'Elemento restaurado');
    }
}