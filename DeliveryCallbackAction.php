<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\nexmo;

use Yii;
use yii\base\Action;

/**
 * Class DeliveryCallbackAction handles delivery receipt.
 *
 * @see https://docs.nexmo.com/index.php/sms-api/handle-delivery-receipt
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\nexmo
 */
class DeliveryCallbackAction extends Action
{
    /**
     * Event name
     */
    const EVENT_RECEIPT_RECEIVED = 'receiptReceived';

    /**
     * Runs the action
     */
    public function run()
    {
        // The request parameters are sent via a GET
        $data = Yii::$app->request->getQueryParams();

        if (isset($data['msisdn']) && isset($data['messageId']) && $data['to']) {
            $receipt = new DeliveryReceipt($data);

            $event = new DeliveryCallbackEvent(['receipt' => $receipt]);

            $this->trigger(self::EVENT_RECEIPT_RECEIVED, $event);
        }
    }
}