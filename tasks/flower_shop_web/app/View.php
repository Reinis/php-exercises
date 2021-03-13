<?php

namespace FlowerShopWeb;

class View
{
    private string $header = <<<EOT
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Flower Shop</title>
        <style>
            form, label, input {
                padding-top: 8px;
                padding-bottom: 8px;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 250px;
            }
            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>

    EOT;


    private string $footer = <<<EOT
    </body>
    </html>

    EOT;

    private string $orderForm = <<<EOT
    <div>
        <form action="/" method="post">
            <label for="name">Flowers:</label>
            <input type="text" id="name" name="name"><br>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" min="1"><br><br>
            <input type="radio" id="female" name="gender" value="female" checked>
            <label for="female">Female</label>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>

    EOT;

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getFooter(): string
    {
        return $this->footer;
    }

    public function getOrderForm(): string
    {
        return $this->orderForm;
    }

    public function getStockingMessages(string ...$messages): string
    {
        $result = "<div>Stocking up the shop...</div>\n";

        foreach ($messages as $message) {
            $result .= sprintf("<div>%s</div>\n", $message);
        }

        return $result . "<hr>\n";
    }

    public function getInventoryTable(array $inventory): string
    {
        $result = "<h3>Inventory:</h3>\n";
        $result .= <<<EOT
        <table>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Price</th>
            </tr>

        EOT;

        $formatString = <<<EOT
            <tr>
                <td>%s</td>
                <td>%d</td>
                <td>%d</td>
            </tr>

        EOT;

        foreach ($inventory as $flower) {
            $result .= sprintf($formatString, $flower['name'], $flower['amount'], $flower['price']);
        }

        return $result . "</table><br>\n";
    }

    public function getInvoiceTable(array $invoice): string
    {
        $result = "<h3>Invoice:</h3>\n<table>\n";
        $formatString = <<<EOT
            <tr>
                <td><strong>%s</strong></td>
                <td>%s</td>
            </tr>

        EOT;

        foreach ($invoice as $key => $value) {
            $result .= sprintf($formatString, ucfirst($key), $value);
        }

        return $result . "</table>\n";
    }

    public function getInvalidAmountMsg(int $amount): string
    {
        return "<strong>Invalid amount:</strong> {$amount}\n";
    }

    public function getInvalidNameMsg(string $name): string
    {
        return "<strong>Flower not found:</strong> {$name}\n";
    }

    public function getInvalidGenderMsg(string $customerGender): string
    {
        return "<strong>Invalid gender:</strong> {$customerGender}\n";
    }
}
