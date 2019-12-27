<?php
/**
 * Created by PhpStorm.
 * User: Ziyodulloxon
 * Date: 21.11.2017
 * Time: 15:34
 */

namespace app\commands;


use app\components\Sitemap;
use yii\console\Controller;

class SitemapController extends Controller
{

    public function actionIndex() {
        set_time_limit(0);
        $sitemap = new Sitemap();
        $urls = $sitemap->getUrl();
        $sitemap->getXml($urls);
    }

}