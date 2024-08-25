<?php

namespace Symfony5\View;

use Fdm\Presentation\Product\ProductsHtmlViewModel;
use Fdm\SharedUtils\Pagination;
use Symfony\Component\HttpFoundation\Request;
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
    public function generateView(Request $request, $viewModel)
    {
        $page = Pagination::computeCurrentPage($request);
        $totalPages = Pagination::computePageTotal($viewModel->total);

        return new Response(
            $this->twig->render('product/list.html.twig', array(
                    'products' => $viewModel->products,
                    'selected_page' => $page,
                    'pages_total' => $totalPages
                )
            )
        );
    }
}