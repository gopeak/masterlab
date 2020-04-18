<?php
require './app/globals.php';

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class Order
{
    public $no = '';
    public $status = '';
    public function __construct($no, $status)
    {
        $this->no =$no;
        $this->status = $status;
    }

}
/**
* The order.placed event is dispatched each time an order is created
* in the system.
*/
class OrderPlacedEvent extends Event
{
    const NAME = 'order.placed';

    protected $order;

    public function __construct(Order $order)
    {
    $this->order = $order;
    }

    public function getOrder()
    {
    return $this->order;
    }
}

class StoreSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'kernel.response'=> [
                ['onKernelResponsePre', 10],
                ['onKernelResponsePost', -10],
            ],
            OrderPlacedEvent::NAME => 'onStoreOrder',
        ];
    }

    public function onKernelResponsePre(Event $event)
    {
        // ...
        var_dump('onKernelResponsePre');
    }

    public function onKernelResponsePost(Event $event)
    {
        // ...
        var_dump('onKernelResponsePost');
    }

    public function onStoreOrder(OrderPlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onStoreOrder');
    }
}

$dispatcher = new EventDispatcher();
// the order is somehow created or retrieved

// ...
$subscriber = new StoreSubscriber();
$dispatcher->addSubscriber($subscriber);

// creates the OrderPlacedEvent and dispatches it
$order = new Order(time(), mt_rand(1,10));
$event = new OrderPlacedEvent($order);
$dispatcher->dispatch($event, OrderPlacedEvent::NAME);

