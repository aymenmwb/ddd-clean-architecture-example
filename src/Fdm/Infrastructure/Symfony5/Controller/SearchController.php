<?php

namespace Symfony5\Controller;

use Fdm\Domain\Product\UseCase\SearchProducts;
use Fdm\Presentation\Product\ListProductsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony5\View\ListProductsView;

class SearchController extends AbstractController
{
    /**
     * @param Request               $request
     * @param SearchProducts        $searchProducts
     * @param ListProductsPresenter $presenter
     * @param ListProductsView      $view
     *
     * @return Response
     */
    public function search(Request $request, SearchProducts $searchProducts, ListProductsPresenter $presenter, ListProductsView $view)
    {
        $searchProducts->execute($request, $presenter);

        return $view->generateView($request, $presenter->viewModel());
    }
}