<?php
namespace Order;
final class OrderElementsList
{
    private $products = [];
    public function __construct(array $arrayOfBasketElements)
    {
        $this->updateOrderList($arrayOfBasketElements);
    }
    /**
     * Перезаписывает список товаров
     * @param array $arrayOfBasketElements
     */
    public function updateOrderList(array $arrayOfBasketElements)
    {
        if (isset($this->products)) {
            unset($this->products);
        }
        $this->products = [];
        foreach ($arrayOfBasketElements as $BasketElement) {
            $this->products[] = new OrderElement($BasketElement->getElement(), $BasketElement->getQuantity());
        }
    }
    /**
     * Возвращает количество разных видов товаров
     * @return int
     */
    public function getProductsTypesQuantity()
    {
        return count($this->products);
    }
    /**
     * Выводит в виде таблицы список товаров
     */
    public function printProductsList()
    {
        echo '<table>';
        echo '<tr>';
        echo '<th>№</th>';
        echo '<th>Вид товара</th>';
        echo '<th>Название</th>';
        echo '<th>Цена</th>';
        echo '<th>Количество</th>';
        echo '<th>Сумма</th>';
        echo '</tr>';
        $i = 1;
        foreach ($this->getProducts() as $product) {
            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            echo '<td>' . $product->getElement()->getProductGroup() . '</td>';
            echo '<td>' . $product->getElement()->getName() . '</td>';
            echo '<td>' . $product->getElement()->getCost() . ' руб.</td>';
            echo '<td>' . $product->getQuantity() . ' шт.</td>';
            echo '<td>' . ($product->getElement()->getCost() * $product->getQuantity()) . ' руб.</td>';
            echo '</tr>';
        }
        echo '<tr><td colspan="6">Сумма заказа: ' . $this->getProductsCost() . ' руб.</td></tr>';
        echo '</table>';
    }
    public function getProducts()
    {
        return $this->products;
    }
    public function getProductsCost()
    {
        $cost = 0;
        foreach ($this->products as $product) {
            $cost += $product->getElement()->getCost() * $product->getQuantity();
        }
        return $cost;
    }
}