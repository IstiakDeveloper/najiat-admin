<?php
namespace App\Imports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvoicesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Invoice([
            'invoice_number' => $this->generateInvoiceNumber(),
            'customer_id' => $row['customer_id'], // Assuming 'customer_id' is present in the CSV file
            'discount' => $row['discount'],
            'delivery_charge' => $row['delivery_charge'],
            'note' => $row['note'],
            'total_expense' => $row['total_expense'],
            'total_sale' => $row['total_sale'],
            'net_profit' => $row['net_profit'],
            // Add more fields as needed
        ]);
    }

    // Add the method to generate the invoice number
    public function generateInvoiceNumber() {
        $lastInvoice = Invoice::latest()->first();

        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $lastSerialNumber = intval(substr($lastInvoiceNumber, -4));
            $newSerialNumber = $lastSerialNumber + 1;
        } else {
            $newSerialNumber = 1;
        }

        $newInvoiceNumber = 'INV-' . str_pad($newSerialNumber, 4, '0', STR_PAD_LEFT);

        return $newInvoiceNumber;
    }
}

