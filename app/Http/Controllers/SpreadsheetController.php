<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\User;

class SpreadsheetController extends Controller
{
    public function exportUsersToExcel()
    {
        $users = User::join('customers', 'users.id', '=', 'customers.user_id')
                     ->select('customers.fname as first_name', 'customers.lname as last_name', 'users.email', 'customers.contact', 'customers.address', 'users.is_admin as active_status')
                     ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'First Name');
        $sheet->setCellValue('B1', 'Last Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Contact');
        $sheet->setCellValue('E1', 'Address');
        $sheet->setCellValue('F1', 'Active Status');

        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->first_name);
            $sheet->setCellValue('B' . $row, $user->last_name);
            $sheet->setCellValue('C' . $row, $user->email);
            $sheet->setCellValue('D' . $row, $user->contact);
            $sheet->setCellValue('E' . $row, $user->address);
            $sheet->setCellValue('F' . $row, $user->active_status ? 'Active' : 'Inactive');
            $row++;
        }

        $filename = 'users_export_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
