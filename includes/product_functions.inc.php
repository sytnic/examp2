<?php

// В этом сценарии определяются функции, используемые каталогом
// Сценарий начал разрабатываться в главе 8


// Функция, отображающая состояние доступности
// Принимает один аргумент, stock, имеющий тип integer
// Возвращает строку
function get_stock_status($stock) {
	
	if ($stock > 5) { // достаточно
		return 'В наличии';
	} elseif ($stock > 0) { // мало
		return 'Заканчивается';
	} else { // Отсутствует
		return 'В настоящее время отсутствует';
	}
	
} // завершение определения функции get_stock_status()


// Функция, отображающая цену
// Учитывает потенциальную специальную цену
// Принимает три аргумента: тип товара, обычная цена и специальная цена
// Возвращает строку.
function get_price($type, $regular, $sales) {
	
	// Цены обрабатывается различным образом на основании типа товара
	if ($type === 'coffee') {
		
		// Добавляется специальная цена в том случае, если она > 0 
		// и меньше обычной цены
		if ((0 < $sales) && ($sales < $regular)) {
			return ' Специальная цена: $' . number_format($sales/100, 2) . '!';
		}
		
	} elseif ($type === 'goodies') {
		
		// Отображается специальная цена, если она больше 0
		// и меньше обычной цены:
		if ((0 < $sales) && ($sales < $regular)) {
			return '<strong>Специальная цена:</strong> $' . number_format($sales/100, 2) . '! (обычная цена - $' . number_format($regular/100, 2). ')<br />';
		} else {
			// Иначе отображается обычная цена
			return '<strong>Обычная цена:</strong> $' . number_format($regular/100, 2) . '<br />';			
		}			
	}
	
} // Завершение определения функции get_price()


// Функция, выполняющая отображение цены
// Учитывает потенциальную специальную цену
// Принимает два аргумента: обычная цена и специальная цена
// Возвращает тип float
function get_just_price($regular, $sales) {
	
	// Возвращает специальную цену, если это уместно
	if ((0 < $sales) && ($sales < $regular)) {
		return number_format($sales/100, 2);
	} else {
		return number_format($regular/100, 2);
	}
	
} // Завершение определения функции get_just_price()


// Функция, выполняющая анализ SKU
// Принимает один аргумент: SKU (например, C390 либо G28)
// Возвращает массив
function parse_sku($sku) {
	
	// Берет первый символ
	$type_abbr = substr($sku, 0, 1);
	
	// Берет оставшиеся символы
	$pid = substr($sku, 1);	
	
	// Верифицирует тип
	if ($type_abbr === 'C') {
		$type = 'coffee';
	} elseif ($type_abbr === 'G') {
		$type = 'goodies';
	} else {
		$type = NULL;
	}
	
	// Верифицирует код товара
	$pid = (filter_var($pid, FILTER_VALIDATE_INT, array('min_range' => 1))) ? $pid : NULL;
	// Заметка: В filter_var Проверяется значение $pid с остальными опциями, третья опция - это ассоциативный массив параметров: FILTER_VALIDATE_INT занимается целыми числами, имеет параметры default, min_range и max_range. Минимальное значение, которое мы назначаем: 1. 
	
	// Возвращает значения
	return array($type, $pid);

} // завершение определения функции parse_sku()




// Функция, применяемая для вычисления и обработки стоимости доставки
// Принимает единственный аргумент: итог по текущему заказу
// Возвращает значение типа float
function get_shipping($total = 0) {
	
	// Выбор базовой стоимости обработки заказа
	$shipping = 3;
	
	// Ставка основана на величине итога
	if ($total < 10) {
		$rate = .25;
	} elseif ($total < 20) {
		$rate = .20;
	} elseif ($total < 50) {
		$rate = .18;
	} elseif ($total < 100) {
		$rate = .16;
	} else {
		$rate = .15;
	}
	
	// Вычисление итога по доставке
	$shipping = $shipping + ($total * $rate);

	// Возвращение итога по доставке
	return $shipping;
	
} // завершение определения функции get_shipping()
