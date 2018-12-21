<?php

namespace CaritasApp\Controllers;

use CaritasApp\Controllers\Controller;
use CaritasApp\Models\News;
use CaritasApp\Models\NewsList;

class NewsController extends Controller
{
    const BASE_PATH = '/aktualnosci';

    public function index()
    {
        $query = [
            'page' => 1,
        ];
        if (!empty($_GET['page'])) {
            $query['page'] = $_GET['page'];
        }
        $NewsList = new NewsList();

        $res = $this->api->get('/divisions/14/news', $query);
        if (!empty($res)) {
            $NewsList = new NewsList($res);
        }

        return $this->renderTemplate('news', [
            'NewsList' => $NewsList,
        ]);
    }

    public function show($path)
    {
        $id = $this->cleanPath($path);
        if (!is_numeric($id)) {
            $this->abort();
        }

        $News = new News;
        $res = $this->api->get('/news/' . $id);
        if (!empty($res)) {
            $News = new News($res);
        }
        return $this->renderTemplate('news-single', [
            'News' => $News,
        ]);
    }
}
