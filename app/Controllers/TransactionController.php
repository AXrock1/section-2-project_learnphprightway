<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helper;
use App\Models\Transaction;
use App\View;

class TransactionController
{
    public function index(): View
    {
        $transactionModel = new Transaction();
        $transactionData = $transactionModel->getData();
        $totals = $transactionModel->calculateTotal($transactionData);
        $format = new Helper();

        return View::make('transactions', [
            'transactionData' => $transactionData,
            'totals' => $totals,
            'format' => $format
        ],);
    }
}
