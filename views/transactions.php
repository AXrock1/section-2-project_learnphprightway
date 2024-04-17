<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- TODO -->
            <?php if (!empty($transactionData)) : ?>
                <?php foreach ($transactionData as $transaction) : ?>
                    <tr>
                        <td><?= $format->formatDate($transaction['transaction_date']) ?></td>
                        <td><?= $transaction['check_number'] ?></td>
                        <td><?= $transaction['description'] ?></td>
                        <td>
                            <?php if ($transaction['amount'] > 0) : ?>
                                <span style="color:green;">
                                    <?= $format->formatteDollar($transaction['amount']) ?>
                                </span>
                            <?php elseif ($transaction['amount'] < 0) : ?>
                                <span style="color:red;">
                                    <?= $format->formatteDollar($transaction['amount']) ?>
                                </span>
                            <?php else : ?>
                                <?= $format->formatteDollar($transaction['amount']) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif ?>

        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td><?= $format->formatteDollar($totals['totalIncome'] ?? 0) ?></td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td><?= $format->formatteDollar($totals['totalExpense'] ?? 0) ?> </td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td><?= $format->formatteDollar($totals['netTotal'] ?? 0) ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>