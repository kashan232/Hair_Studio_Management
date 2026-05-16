<?php

namespace App\Http\Controllers;

use App\Exports\IrrigationTemplateExport;
use App\Imports\IrrigationBulkImport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class IrrigationImportController extends Controller
{
    protected const IMPORT_TYPES = ['circles', 'divisions', 'sub_divisions'];

    public function index()
    {
        return view('irrigation.import');
    }

    public function template(Request $request)
    {
        $type = $request->query('type', 'sub_divisions');
        if (!in_array($type, self::IMPORT_TYPES)) {
            $type = 'sub_divisions';
        }

        $export = new IrrigationTemplateExport($type);
        $fileName = "irrigation_import_template_{$type}.xlsx";

        return Excel::download($export, $fileName);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'import_type' => ['required', Rule::in(self::IMPORT_TYPES)],
            'file' => ['required', 'file', 'max:40960', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new IrrigationBulkImport($validated['import_type']);
        Excel::import($import, $request->file('file'));

        $errors = $import->errors;
        $hasErrors = count($errors) > 0;

        $message = sprintf(
            'Import finished: %d new record(s) created. %d row(s) already existed. %d empty row(s) skipped.',
            $import->rowsImported,
            $import->rowsDuplicate,
            $import->rowsSkipped
        );

        if ($hasErrors && $import->rowsImported === 0 && $import->rowsDuplicate === 0) {
            return redirect()->route('irrigation.import')
                ->with('error', 'Import failed.')
                ->with('import_errors', $errors);
        }

        $redirect = redirect()->route('irrigation.import')->with('success', $message);

        if ($hasErrors) {
            $redirect->with('warning', 'Some rows had problems.')->with('import_errors', $errors);
        }

        return $redirect;
    }
}
