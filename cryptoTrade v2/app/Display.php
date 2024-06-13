<?php
namespace CryptoTrade\App;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class Display
{
    private Tasks $cryptos;
    private Wallet $wallet;
    public function __construct(Tasks $cryptos, Wallet $wallet)
    {
        $this->cryptos = $cryptos;
        $this->wallet = $wallet;
    }
    public function getMenu(): void
    {
        echo "[1] See top crypto currencies" . PHP_EOL .
            "[2] Search crypto currency" . PHP_EOL .
            "[3] Purchase crypto currency" . PHP_EOL .
            "[4] Sell crypto currency" . PHP_EOL .
            "[5] Display wallet" . PHP_EOL .
            "[6] Display transaction list" . PHP_EOL .
            "[7] Exit" . PHP_EOL;
    }
    public function getTopCrypto(): void
    {
        $output = new ConsoleOutput();
        $table = new Table($output);

        $table->setHeaders(['Number', 'Name']);

        foreach ($this->cryptos->getLatest() as $crypto) {
            $table->addRow([
                $crypto['number'],
                $crypto['name']
            ]);
        }
        $table->render();
    }
    public function getSearchInfo(): void
    {
        $output = new ConsoleOutput();
        $table = new Table($output);

        $table->setHeaders(['Name', 'Symbol', 'Price $', '1h %', '24h %', '7d %', 'Market Cap $']);

        foreach ($this->cryptos->getSearch() as $search) {
            $table->addRow([
                $search["name"],
                $search["symbol"],
                $search["price"],
                $search["oneHour"],
                $search["twentyFourHour"],
                $search["sevenDays"],
                $search["marketCap"],
            ]);
        }
        $table->render();
    }
    public function getWallet(): string
    {
        return PHP_EOL . "Your wallet: $" . $this->wallet->getMoney() . PHP_EOL . PHP_EOL;
    }
    public function getTransactions(): void
    {
        $output = new ConsoleOutput();
        $table = new Table($output);

        $table->setHeaders(['Trade', 'Crypto name', 'Spent', 'Received']);

        foreach ($this->wallet->getTransaction() as $wallet) {
            $table->addRow([
                $wallet["trade"],
                $wallet["cryptoName"],
                $wallet["spent"],
                $wallet["received"]
            ]);
        }
        $table->render();
    }
    public function getOwned(): void
    {
        $output = new ConsoleOutput();
        $table = new Table($output);

        $table->setHeaders(['Crypto name', 'Value']);

        foreach ($this->wallet->getOwned() as $owned) {
            $table->addRow([
                $owned["cryptoName"],
                $owned["value"]
            ]);
        }
        $table->render();
    }
    public function chooseAction(string $userAction): void
    {
        switch ($userAction) {
            case 1:
                $this->getTopCrypto();
                break;
            case 2:
                $this->getSearchInfo();
                break;
            case 3:
                $this->wallet->purchase();
                break;
            case 4:
                $this->getOwned();
                $this->wallet->sell();
                break;
            case 5:
                echo $this->getWallet();
                break;
            case 6:
                $this->getTransactions();
                break;
            case 7:
                $this->wallet->save("transactions.json");
                exit;
            default:
                echo "Invalid input!" . PHP_EOL;
        }
    }
}