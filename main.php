<?php
include 'Core/init.php'; // в файле реализован механизм автозагрузки
/* Создаем товары */
$carAudi = new \Products\Car('Audi', 1000000, 'white');
$carKia = new \Products\Car('Kia', 800000, 'black');
$tvPhilips = new \Products\TelevisionSet('Philips', 10000, 'black');
$tvSony = new \Products\TelevisionSet('Sony', 15000, 'black');
$tvPhilips->turnOn();
$tvPhilips->setChannel(10); // канал изменится, т.к. телевизор включен
$tvSony->setChannel(10); // канал не изменится, т.к. телевизор выключен
for ($i = 1; $i < 10; $i++) {
    $tvPhilips->volumeUp(); // громкость меняться будет, т.к. телевизор включен
    $tvSony->volumeDown(); // громкость меняться не будет, т.к. телевизор выключен
}
$tvPhilips->turnOff();
$tvSony->turnOn();
$whitePen = new \Products\Pen('Pen1', 10, 'white');
$whitePen->setInkLevel(80);
$whitePen->setThickness('0.5');
$blackPen = new \Products\Pen('Pen2', 20, 'black');
$blackPen->setInkLevel();
$blackPen->setThickness('0.7');
for ($i = 0; $i < 150; $i++) {
    if (rand(1, 2) === 1) {
        $whitePen->usePen();
    } else {
        $blackPen->usePen();
    }
}
$brownDuck = new \Products\Duck('FirstDuck', 500, 'brown');
$brownDuck->setWeight(2);
$brownDuck->setAge(2);
$blackDuck = new \Products\Duck('SecondDuck', 600, 'black');
for ($i = 0; $i < 10; $i++) {
    $brownDuck->changeWeight(rand(-1, 1));
    $blackDuck->changeWeight(rand(-1, 1));
    $brownDuck->upAge();
    $blackDuck->upAge();
}
$phoneSamsung = new \Products\Phone('Samsung', 20000, 'Черный');
$phoneApple = new \Products\Phone('Apple', 30000, 'Белый');
$phoneApple->setProductDiscount(10);
$caseSamsung = new \Products\Phone('Samsung', 600, 'Черный');
$caseSamsung->setProductDiscount(15);
$caseSamsung->setProductGroup('Чехол');
$caseApple = new \Products\Phone('Apple', 700, 'Белый');
$caseApple->setProductDiscount(25);
$caseApple->setProductGroup('Чехол');
\Products\Product::setGroupDiscount('Смартфон', 5);
\Products\Product::setGroupDiscount('Чехол', 20);
/* Можно вывести на экран описание созданных товаров */
/*
echo $carAudi->getFullDescription() . '<br>';
echo $carKia->getFullDescription() . '<br>';
echo '<br>';
echo $tvPhilips->getFullDescription() . '<br>';
echo $tvSony->getFullDescription() . '<br>';
echo '<br>';
echo $whitePen->getFullDescription() . '<br>';
echo $blackPen->getFullDescription() . '<br>';
echo '<br>';
echo $brownDuck->getFullDescription() . '<br>';
echo $blackDuck->getFullDescription() . '<br>';
echo '<br>';
echo $phoneSamsung->getFullDescription() . '<br>';
echo $phoneApple->getFullDescription() . '<br>';
echo $caseSamsung->getFullDescription() . '<br>';
echo $caseApple->getFullDescription() . '<br>';
echo '<br>';
*/
$zeroCostProduct = new \Products\Phone('Zero', 0, 'Белый');
$emptyNameProduct = new \Products\Phone('', 5, 'Белый');
/* Работаем с корзиной */
$list = array($carAudi, $carKia, $tvPhilips, $tvSony, $whitePen, $blackPen, $brownDuck, $blackDuck,
    $phoneSamsung, $phoneApple, $caseSamsung, $caseApple, $zeroCostProduct, $emptyNameProduct);
$basket = new \Basket\Basket(); // создаем корзину
for ($i = 1; $i < rand(1, 50); $i++) {
    try {
        $operation = rand(1, 3);
        switch ($operation) {
            case 1:
                $basket->addProduct($list[rand(0, count($list) - 1)], rand(-2, 10));
                // добавление товара в корзину
                break;
            case 2:
                $basket->setProductQuantity($list[rand(0, count($list) - 1)], rand(-2, 10));
                // установка количества товара в корзине (при отсутствии товара - он добавляется в корзину)
                break;
            case 3:
                $basket->deleteProduct($list[rand(0, count($list) - 1)]);
                // удаление товара из корзины
                break;
        }
    } catch (\ProductErrorException $e) {
        echo $e->getMessage();
    }
}
$basket->printBasket(); // выводим содержимое корзины на экран
echo '<br>';
/* Работаем с заказом */
try {
    $order = new \Order\Order($basket);
    $order->completeOrder(); // меняем состояние заказа
    echo '<p> Текущее состояние заказа: ' . $order->getOrderState() . '</p>'; // выводим на экран состояние заказа
    $order->printOrder(); // выводим содержимое заказа на экран
    $order->cancelOrder(); // отменяем заказ
    echo '<p> Текущее состояние заказа: ' . $order->getOrderState() . '</p>';
} catch (\ProductErrorException $e) {
    echo $e->getMessage();
}