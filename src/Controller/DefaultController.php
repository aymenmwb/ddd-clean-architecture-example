<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DefaultController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function list(Request $request)
    {
        $response =  $this->twig->render('import/import.html.twig', array());

        if ($request->isMethod('POST')) {
            $postData = array_merge($request->request->all(), $request->files->all());

            $tmp_file = $postData['import_file']->getPathName();
            $rows = $this->get_array_from_file($tmp_file);
            dump($rows);exit;
        }

        return new Response($response);
    }

    private function get_array_from_file($file_path): array
    {
        return $this->get_array_from_csv_file($file_path);
    }

    /**
     * @param string $file_path
     *
     * @return array
     */
    private function get_array_from_csv_file($file_path): array
    {
        $handle = fopen($file_path, 'r');

        if ($handle == true):
            $first_row = fgetcsv($handle, 0, ',');
            rewind($handle);

            if (empty($first_row) == true):
                throw new \Exception('Empty file (' . basename($file_path) . ')');
            endif;
        else:
            throw new \Exception('Invalid file (' . basename($file_path) . ')');
        endif;

        $file_content = fread($handle, 8192);
        $file_is_utf8 = $this->get_string_is_utf8($file_content);
        rewind($handle);

        $array = array();

        $i = 0;
        while (($row = fgetcsv($handle, 0, ',')) !== false):
            $array[$i] = $row;

            if ($file_is_utf8 == false):
                foreach ($array[$i] as $k => $v):
                    if ($v != ''):
                        $array[$i][$k] = utf8_encode($v);
                    endif;
                endforeach;
            endif;

            if ($i > 40000):
                throw new \Exception('Too many rows (max. 40000)');
            endif;

            $i++;
        endwhile;

        fclose($handle);

        return $array;
    }

    function get_string_is_utf8($s): bool
    {
        return (bool)(@iconv('utf-8', 'utf-8//IGNORE', $s) == $s);
    }
}