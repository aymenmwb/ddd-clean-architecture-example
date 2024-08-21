<?php

namespace Symfony\View;

use Fdm\Presentation\Product\ProductsHtmlViewModel;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListProductsView
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param ProductsHtmlViewModel$viewModel
     *
     * @return Response
     */
    public function generateView($viewModel)
    {
        return new Response(
            $this->twig->render('product/list.html.twig', array(
                    'products' => $viewModel->products,
                    'total' => $viewModel->total
                )
            )
        );
    }
}