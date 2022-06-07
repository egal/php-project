<?php

namespace Egal\Core\Rest\Order;

class Parser
{
    public function parse(?string $queryString): array
    {
        $orders = [];

        if ($queryString === '' || $queryString === null) {
            return $orders;
        }

        $ordersRaw = explode(ColumnOrder::ORDERS_DELIMITER, $queryString);

        foreach ($ordersRaw as $order) {
            $orders[] = ColumnOrder::make();
        }

        return $orders;
    }
}
