<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Transaction;
use App\View;

class HomeController
{
    public function index(): View
    {
        return View::make('index');
    }

    public function upload(): View
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['csv_file']['name'];
        move_uploaded_file($_FILES['csv_file']['tmp_name'], $filePath);

        echo '<pre>';
        var_dump(pathinfo($filePath));
        echo '</pre>';

        $transactionModel = new Transaction();
        $result = $transactionModel->uploadFileToDb($filePath);

        if ($result) {
            $message = 'berhasil memasukkan data';
        } else {
            $message = 'terjadi kesalahan pada saat memasukkan data';
        }

        return View::make('upload', ['message' => $message]);
    }
}
