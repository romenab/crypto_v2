<?php

namespace CryptoTrade;
use CryptoTrade\App\Tasks;
use CryptoTrade\App\Wallet;
use CryptoTrade\App\Display;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ );
$dotenv->load();
$api = $_ENV['MY_API'];
$url= $_ENV['MY_URL'];
$tasks = new Tasks($api, $url);
$wallet = new Wallet($api, $url, 1000);
$wallet->load("transactions.json");
$show = new Display($tasks, $wallet);
while (true) {
    $show->getMenu();
    $userAction = (int)readline("Enter your action: ");
    $show->chooseAction($userAction);
}