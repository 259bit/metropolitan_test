<?php

namespace Metropolitan\Test\Agent;

use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use JsonException;
use Metropolitan\Test\ExternalApi\MpdOrder;

class MpdAgent
{
    /**
     * @throws JsonException
     * @throws ObjectNotFoundException
     * @throws ObjectException
     */
    public static function saveOrdersToLeads(): string
    {
        $mpdOrders = new MpdOrder();
        $orders = $mpdOrders->getLasts();

        foreach ($orders as $order) {
            $mpdOrders->saveToLead($order);
        }

        return static::class . '::saveOrdersToLeads();';
    }
}