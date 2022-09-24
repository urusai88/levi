<?php

function logFile (&$log){
    $fileName = 'logs';
    $file = [];
    if (file_exists($fileName)){
        $file = unserialize(file_get_contents($fileName));
        $file[] = $log;
        file_put_contents($fileName, serialize($file));
    } else {
        $file[] = $log;
        file_put_contents($fileName, serialize($file));
    }

}

function calculate(&$logs)
{
    do {
        $a = readline("Первое число");
    } while (is_numeric($a) == false);

    do {
        $sign = readline("Знак");
        $signs = ["+", "-", "*", "/"];
    } while (in_array($sign, $signs) == false);

    do {
        do {
            $b = readline("Второе число");
        } while (($b == 0 && $sign == "/") !== false);
    } while (is_numeric($b) == false);

    $result = null;

    switch ($sign) {
        case "+":
            $result = $a + $b;
            break;
        case "-":
            $result = $a - $b;
            break;
        case "*":
            $result = $a * $b;
            break;
        case "/":
            $result = $a / $b;
            break;
    }
    echo $result;
    $log = "$a $sign $b = $result (" . date("Y-m-d H:i:s") . ")" ;
    logFile($log);
}

function start(&$logs)
{
    $int = readline('Для запуска калькулятора введите 1. Для просмотра истории введите 2. Для вывода истории по операции введите 3. Для выхода введите 4');
    switch ($int) {
        case "1":
            calculate($logs);
            break;
        case "2":

            $file = unserialize(file_get_contents('logs'));
            echo implode(", ", $file);

            break;
        case "3":
            $signs = ["+", "-", "*", "/"];
            $sign = readline("Введите знак для сортировки");
            if (in_array($sign, $signs)) {
                $logsSort = [];
                $logs = unserialize(file_get_contents('logs'));
                foreach ($logs as $log) {
                    $log1 = str_split($log, 1);
                    if (in_array($sign, $log1)) {
                        $logsSort[] = $log;
                    }
                }
                echo(implode(", ", $logsSort));
            } else {
                echo "Нет такого оператора!";
            }
            break;
        case "4":

            return 'end';
    }
}

do {
    $a = start($logs);
} while ($a !== "end");
