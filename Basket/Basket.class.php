<?php
namespace Basket;
class Basket
{
    private $products = [];
    public function __construct(\BasicInfo $product = null, $quantity = 1)
    {
        if (isset($product)) {
            $this->products[] = new BasketElement($product, $quantity);
        }
    }
    /**
     * Добавляет товар в корзину (если уже есть - увеличивает количество)
     * @param \BasicInfo $product
     * @param int $quantity
     */
    public function addProduct(\BasicInfo $product, $quantity = 1)
    {
        $this->setProductQuantity($product, $this->getProductQuantity($product) + $quantity);
    }
    /**
     * Функция устанавливает число элементов в корзине (если элемента нет - создает его с нужным количеством)
     * @param \BasicInfo $product
     * @param int $quantity
     * @throws \ProductErrorException
     */
    public function setProductQuantity(\BasicInfo $product, $quantity)
    {
        $productInBasket = $this->searchInBasket($product);
        if ($quantity <= 0) {
            throw new \ProductErrorException('Вы указали неверное количество (' . $quantity . ') товара ' . $product->getName() . '!<br>');
        }
        if (isset($productInBasket)) {
            $productInBasket->setQuantity($quantity);
        } else {
            if (empty($product->getCost())) {
                throw new \ProductErrorException('У добавляемого в корзину товара ' . $product->getName() . ' отсутствует цена! Товар не был добавлен!<br>');
            }
            if (empty($product->getProductGroup())) {
                throw new \ProductErrorException('У добавляемого в корзину товара ' . $product->getName() . ' отсутствует группа! Товар не был добавлен!<br>');
            }
            if (empty($product->getName())) {
                throw new \ProductErrorException('У добавляемого в корзину товара отсутствует имя! Товар не был добавлен!<br>');
            }
            $this->products[] = new BasketElement($product, $quantity);
        }
    }
    /**
     * Возвращает null если элемента $item нет в корзине, или сам элемент если есть
     * @param \BasicInfo $item
     * @return BasketElement or null
     */
    private function searchInBasket(\BasicInfo $item)
    {
        foreach ($this->products as $product) {
            if ($product->getElement() === $item) {
                return $product;
            }
        }
        return null;
    }
    /**
     * Возвращает количество элементов в корзине
     * @param \BasicInfo $product
     * @return int
     */
    public function getProductQuantity(\BasicInfo $product)
    {
        $productInBasket = $this->searchInBasket($product);
        if (isset($productInBasket)) {
            return $productInBasket->getQuantity();
        } else {
            return 0;
        }
    }
    /**
     * Удаляет товар из корзины
     * @param \BasicInfo $item
     */
    public function deleteProduct(\BasicInfo $item)
    {
        foreach ($this->products as $id => $product) {
            if ($product->getElement() === $item) {
                unset($this->products[$id]);
            }
        }
    }
    /**
     * Возвращает массив с объектами класса BasketElement
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
    /**
     * Выводит содержимое корзины на экран
     */
    public function printBasket()
    {
        echo '<hr>';
        echo '<h2>Ваша корзина: </h2>';
        if (count($this->products) === 0) {
            echo '<p>Корзина пуста</p>';
        } else {
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
            foreach ($this->products as $product) {
                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $product->getElement()->getProductGroup() . '</td>';
                echo '<td>' . $product->getElement()->getName() . '</td>';
                echo '<td>' . $product->getElement()->getCost() . ' руб.</td>';
                echo '<td>' . $product->getQuantity() . ' шт.</td>';
                echo '<td>' . ($product->getElement()->getCost() * $product->getQuantity()) . ' руб.</td>';
                echo '</tr>';
            }
            echo '<tr><td colspan="6">Итоговая сумма: ' . $this->getProductsCost() . ' руб.</td></tr>';
            echo '</table>';
        }
        echo '<hr>';
    }
    /**
     * Возращает общую стоимость товаров в корзине
     * @return int
     */
    public function getProductsCost()
    {
        $cost = 0;
        foreach ($this->products as $product) {
            $cost += $product->getElement()->getCost() * $product->getQuantity();
        }
        return $cost;
    }
}
