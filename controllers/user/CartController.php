<?php

namespace app\controllers\user;

use app\models\CartForm;
use app\models\Invoice;
use app\models\OrderForm;
use app\models\Template;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yz\shoppingcart\ShoppingCart;

/**
 * Class CartController
 * @package app\controllers\user
 */
class CartController extends UserCommonController
{
    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionAdd()
    {
        $template = Template::findOne(\Yii::$app->request->post('CartForm')['templateId' ?? null]);
        if (!$template) {
            throw new NotFoundHttpException();
        }

        $model = new CartForm();
        $model->load(\Yii::$app->request->post());

        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->validate()) {
            return [
                'status' => true,
                'cartItemsCount' => $model->addToCart(),
                'message' => 'Шаблон успешно добавлен в корзину.',
            ];
        }

        return ['status' => false];
    }

    /**
     * @return array|string|Response
     */
    public function actionIndex()
    {
        $model = new OrderForm();
        $model->load(\Yii::$app->request->post());

        if (\Yii::$app->request->isAjax && !isset($_GET['_pjax'])) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (\Yii::$app->request->isPost) {
            if ($invoice = $model->execute()) {
                return $this->redirect([
                    '/payment/send',
                    'id' => $invoice->id,
                    'type' => $model->paymentType
                ]);
            }
        }

        /** @var ShoppingCart $cart */
        $cart = \Yii::$app->cart;
        return $this->render('index', compact('cart', 'model'));
    }

    /**
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {
        /** @var ShoppingCart $cart */
        $cart = \Yii::$app->cart;
        $cart->removeById($id);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => true,
            'count' => $cart->count,
        ];
    }

//    /**
//     * @param $token
//     * @return string
//     */
//    public function actionOrder($token)
//    {
//        $invoice = Invoice::findOne(23);
//        return $this->render('order', compact('invoice'));
//    }
}
