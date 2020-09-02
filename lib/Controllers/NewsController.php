<?php

namespace IndicoPlus\CaritasApp\Controllers;

use IndicoPlus\CaritasApp\Controllers\Controller;
use IndicoPlus\CaritasApp\Core\Plugin;
use IndicoPlus\CaritasApp\Core\Router;
use IndicoPlus\CaritasApp\Models\News;
use IndicoPlus\CaritasApp\Models\NewsList;

class NewsController extends Controller
{
    const BASE_PATH = Router::NEWS_PATH;

    public function index()
    {
        $plugin = Plugin::instance();
        $query = [
            'page' => 1,
        ];
        if (!empty($_GET['page'])) {
            $query['page'] = $_GET['page'];
        }
        $NewsList = new NewsList();
        $division = $plugin->getSelectedDivision();
        if (!$division) {
            return $this->renderTemplate('news', [
                'NewsList' => $NewsList,
            ]);
        }

        $res = $this->api->get('/divisions/' . $division . '/news', $query);
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
