<?php
namespace Order;
final class Order
{
    const ORDER_IN_PROGRESS = 'Заказ в процессе оформления';
    const ORDER_CREATED = 'Заказ оформлен';
    const ORDER_CANCELLED = 'Заказ отменен';
    /**
     * @var OrderElementsList $orderElementsList
     */
    private $orderElementsList;
    private $orderState = self::ORDER_IN_PROGRESS;
    public function __construct(\Basket\Basket $basket)
    {
        if (count($basket->getProducts()) === 0) {
            throw new \ProductErrorException('Невозможно оформить заказ! Ваша корзина пуста!<br>');
        }
        $this->updateProductsInOrder($basket);
    }
    /**
     * Обновляет (перезаписывает) содержимое заказа
     * @param \Basket\Basket $basket
     */
    public function updateProductsInOrder(\Basket\Basket $basket)
    {
        if (isset($orderElementsList)) {
            $this->orderElementsList->updateOrderList($basket->getProducts());
        } else {
            $this->orderElementsList = new OrderElementsList($basket->getProducts());
        }
    }
    public function getOrderState()
    {
        return $this->orderState;
    }
    public function completeOrder()
    {
        if ($this->orderElementsList->getProductsTypesQuantity() === 0) {
            throw new \ProductErrorException('Невозможно оформить заказ! Список товаров пуст!<br>');
        }
        $this->orderState = self::ORDER_CREATED;
    }
    public function cancelOrder()
    {
        $this->orderState = self::ORDER_CANCELLED;
    }
    /**
     * Выводит содержимое заказа на экран
     */
    public function printOrder()
    {
        echo '<hr>';
        echo '<h2>Ваш заказ: </h2>';
        if ($this->orderElementsList->getProductsTypesQuantity() !== 0) {
            $this->orderElementsList->printProductsList();
        }
        echo '<hr>';
    }
}