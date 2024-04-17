<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use DateTime;

class Transaction extends Model
{
    public function uploadFileToDb($file)
    {
        $csvData = file_get_contents($file);
        $rows = explode("\n", $csvData);

        if (count($rows) > 0) {
            unset($rows[0]);
        }

        foreach ($rows as $row) {
            $data = str_getcsv($row);

            // Periksa apakah jumlah elemen dalam $data cukup
            if (count($data) < 4) {
                continue; // Lewati iterasi jika tidak cukup data
            }

            // Menghapus simbol '$' ',' dari nilai amount dan mengonversi menjadi tipe data float
            $amount = (float) str_replace(['$', ','], '', $data[3]);

            // Konversi format tanggal dari 'dd/mm/yyyy' menjadi 'YYYY-MM-DD'
            $date = DateTime::createFromFormat('m/d/Y', $data[0]);

            // Periksa apakah tanggal valid sebelum membuat objek DateTime
            if ($date instanceof DateTime) {
                $formattedDate = $date->format('Y-m-d');
            } else {
                continue; // Lewati iterasi jika tanggal tidak valid
            }

            // Bind parameter
            $stmt = $this->db->prepare(
                'INSERT INTO transaction (transaction_date, check_number, description, amount) VALUES (?,?,?,?)'
            );
            $stmt->bindParam(1, $formattedDate);
            $stmt->bindParam(2, $data[1]);
            $stmt->bindParam(3, $data[2]);
            $stmt->bindParam(4, $amount);

            // Eksekusi query
            $stmt->execute();
        }

        return true;
    }

    public function getData(): array
    {
        // Mengambil semua data transaksi dari database
        $stmt = $this->db->prepare('SELECT * FROM transaction');
        $stmt->execute();
        $transactions = $stmt->fetchAll();

        return $transactions;
    }

    public function calculateTotal(array $transactions): array
    {
        $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

        foreach ($transactions as $transaction) {
            $totals['netTotal'] += $transaction['amount'];

            if ($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }

        return $totals;
    }
}
