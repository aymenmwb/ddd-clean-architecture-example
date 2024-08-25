<?php

namespace Symfony5\Controller;

use Fdm\Domain\Product\UseCase\ListProducts;
use Fdm\Presentation\Product\ListProductsPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony5\View\ListProductsView;

class HomepageController extends AbstractController
{
    /**
     * @param Request               $request
     * @param ListProducts          $listProducts
     * @param ListProductsPresenter $presenter
     * @param ListProductsView      $view
     *
     * @return Response
     */
    public function list(Request $request, ListProducts $listProducts, ListProductsPresenter $presenter, ListProductsView $view)
    {
        $listProducts->execute($request, $presenter);

        return $view->generateView($request, $presenter->viewModel());
    }
}