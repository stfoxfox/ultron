<?php

namespace app\components;

use app\models\News;
use app\models\Page;
use app\models\Template;
use yii\base\Object;
use Yii;

class Sitemap extends Object
{

    public function getUrl ()
    {
        $urls = [];
//        echo Yii::$app->urlManager->createAbsoluteUrl([
//            "site/index",
//        ]);die;
        /////////////////////////// STATIC PAGES ///////////////////////////
        $siteActions = [
            'index',
            'seller',
//            'seller-reg',
        ];

        $staticPages = [
            'site' => $siteActions,
            'news' => ['index'],
            'template' => ['index']
        ];

        foreach ($staticPages as $key => $value) {
            foreach ($value as $action) {
                $urls[] = [
                    Yii::$app->urlManager->createAbsoluteUrl([
                        "$key/$action",
                    ]),
                ];
            }
        }

        /////////////////////////// TEMPLATES ///////////////////////////
        foreach (Template::find()->asArray()->each(100) as $template) {
            if ($template['alias'] != "" && $template['is_deleted'] == 0) {
                $urls[] = [
                    Yii::$app->urlManager->createAbsoluteUrl([
                        'template/view',
                        'id' => $template['id']
                    ]),
                    'daily',
                ];
            }
        }

        /////////////////////////// PAGES ///////////////////////////
        foreach (Page::find()->asArray()->each(100) as $page) {
            $urls[] = [
                Yii::$app->urlManager->createAbsoluteUrl([
                    'page/view',
                    'alias' => $page['alias']
                ]),
                'daily'
            ];
        }

        /////////////////////////// NEWS ///////////////////////////
        foreach (News::find()->asArray()->each(100) as $news) {
            $urls[] = [
                Yii::$app->urlManager->createAbsoluteUrl([
                    'news/view',
                    'id' => $news['id']
                ]),
                'daily'
            ];
        }

        return $urls;
    }

    public function getXml($urls)
    {
        $host = Yii::$app->params['siteName'];
        ob_start();
        echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <?php foreach ($urls as $url): ?><url>
        <loc><?= $host . $url[0] ?></loc>
        <?php if (isset($url['lastmod']) && $url['lastmod']) : ?><lastmod><?= $url['lastmod'] ?></lastmod><?php endif ?><?php if (isset($url[1]) && $url[1]) : ?>

        <changefreq><?= $url[1] ?></changefreq><?php endif ?>

    </url>
    <?php endforeach; ?>

</urlset>
        <?php $xmlString = ob_get_clean();
        file_put_contents(Yii::getAlias('@app') . "/web/sitemap.xml", $xmlString);
    }

}