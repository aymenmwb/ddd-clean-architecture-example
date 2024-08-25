<?php
namespace Fdm\SharedUtils;

use Symfony\Component\HttpFoundation\Request;

class Pagination
{
    public static function computeCurrentPage(Request $request)
    {
        $page = $request->query->get('page');

        return ($page !== null) ? $page : 1;
    }

    public static function computePageTotal($total)
    {
        return ceil($total / 30);
    }
}