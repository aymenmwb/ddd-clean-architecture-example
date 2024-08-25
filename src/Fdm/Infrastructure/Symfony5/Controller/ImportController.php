<?php

namespace Symfony5\Controller;

use Fdm\Domain\Product\UseCase\ImportProducts;
use Fdm\Domain\Product\UseCase\ImportProductsRequest;
use Fdm\Presentation\Product\ImportProductsPresenter;
use Fdm\SharedUtils\Infrastructure\Request\FileInputConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony5\View\ImportProductsView;

class ImportController extends AbstractController
{
    /**
     * @param Request                 $baseRequest
     * @param ImportProducts          $importProducts
     * @param ImportProductsPresenter $presenter
     * @param ImportProductsView      $view
     *
     * @return RedirectResponse|Response
     */
    public function import(Request $baseRequest, ImportProducts $importProducts, ImportProductsPresenter $presenter, ImportProductsView $view)
    {
        $request = null;

        if ($baseRequest->isMethod('POST')) {
            $fileRequest = $baseRequest->files->get('import_file');
            $file = FileInputConverter::convert($fileRequest);
            $postData = array_merge($baseRequest->request->all(), $file);
            $request = ImportProductsRequest::fromPost($postData);
        }

        $importProducts->execute($request, $presenter);

        return $view->generateView($presenter->viewModel());
    }
}