<?php

declare(strict_types=1);

namespace Common\Utils;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ImportExportHelper
{
    public static function xlsxToCsvString($xlsxString)
    {
        // Create a temporary file to save the xlsx content
        $tempFile = tempnam(sys_get_temp_dir(), 'xlsx');
        file_put_contents($tempFile, $xlsxString);

        // Load the spreadsheet using PhpSpreadsheet
        $spreadsheet = IOFactory::load($tempFile);

        // Start output buffering
        ob_start();

        // Create a CSV writer and save the CSV content to the output buffer
        $writer = new Csv($spreadsheet);
        $writer->save('php://output');

        // Get the CSV content from the output buffer
        $csvString = ob_get_clean();

        // Clean up temporary file
        unlink($tempFile);

        return $csvString;
    }
}
