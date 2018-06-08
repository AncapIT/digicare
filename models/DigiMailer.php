<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.04.18
 * Time: 22:21
 */

namespace app\models;


use app\components\DigiCareHelper;
use Yii;
use yii\helpers\Url;
use yii\widgets\DetailView;

class DigiMailer
{
    /**
     * @param $event
     *
     * event handler
     */
    public static function sendNewMessageAdded($event)
    {
        $message = $event->data ;
        //send mail if isn't read


        if (!$message->read_by_admin) {
            $textBody = '';
            $url = Url::base(true).Url::to(['messages/create','chat_group'=>$message->patient_id]);
            $provider = DigiCareHelper::getProvider();
            if(isset($provider->email_alerts_messages)){

            Yii::$app->mailer->compose()
                ->setFrom('noreply@digicareapp.com')
                ->setTo(explode(',', $provider->email_alerts_messages))
                ->setSubject('DigiCare - New message from ' . $message->user->first_name . ' ' . $message->user->last_name .
                    ' regarding ' . $message->patient->first_name . ' ' . $message->patient->last_name )
                ->setTextBody('Click here to view: ' . $url)
                ->setHtmlBody('<p><a href="' . $url . '">Click here to view</a></p><p>' . $url . '</p>')
                ->send();
            }

        }
    }

    /**
     * @param $event
     *
     * event handler
     */
    public static function sendNewOrderAdded($event)
    {
        $order = $event->data ;

        $provider = DigiCareHelper::getProvider();
        if(isset($provider->email_alerts_orders) && $order->product->module != 'food_menu') {

            $url = Url::base(true).Url::to(['orders/view','id'=>$order->order_id]);
            $html ='<b>'.$order->order_title.'</b> <ul></ul>';
            $txt = $order->order_title;
            foreach ($order->orderItems as $item){
                //$html .= '<li>'.$item->title.'</li>';
                $txt = ' '.$item->title.' ';
            }
            $orders_html = '';
            $order_items =  $order->getOrder_items_data();
            foreach ( $order_items as $oi ) {
                $orders_html .= $oi . '<br/>';
            }
           $html .= DetailView::widget([
               'model' => $order,
               'attributes' => [
                   'order_id',
                   'order_title',
                   [
                       'label' => 'User',
                       'value' => $order->getUser_name(   $order->user_id  ),
                   ],
                   [ 'label' => 'Patient',
                       'value' => $order->getUser_name(   $order->patient_id  ),
                   ],
                   // 'product_type',
                   //'selected_items',
                   'create_date',
                   'price',
                   [
                       'label' => 'Order Items',
                       'format' => 'html',
                       'value' =>  $orders_html ,
                   ],
                   [
                       'label' => 'Status',
                       'value' => $order->getOrder_status_title(   $order->order_status  ),
                   ],
               ],
           ]);
            $html .= ' </ul> <p>Price: '.$order->price.'</p><p><a href="' . $url . '">Click here to view</a></p><p>' . $url . '</p>';
            $txt .= ' Price: '.$order->price.' Click here to view: ' . $url;

            Yii::$app->mailer->compose()
                ->setFrom('noreply@digicareapp.com')
                ->setTo(explode(',', $provider->email_alerts_orders))
                ->setSubject('DigiCare - New order for '.$order->patient->first_name.' '.$order->patient->last_name.': '.$order->order_title)
                ->setTextBody($txt)
                ->setHtmlBody($html)
                ->send();
        }
    }
}
