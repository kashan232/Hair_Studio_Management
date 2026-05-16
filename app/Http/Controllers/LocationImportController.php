<?php

namespace App\Http\Controllers;

use App\Exports\LocationTemplateExport;
use App\Imports\LocationBulkImport;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class LocationImportController extends Controller
{
    protected const IMPORT_TYPES = ['districts', 'talukas', 'tehsils', 'dehs'];

    public function index()
    {
        return view('locations.import');
    }

    /** Download example .xlsx template for selected import type. */
    public function template(Request $request)
    {
        $type = $request->query('type', 'dehs');
        if (! in_array($type, self::IMPORT_TYPES, true)) {
            $type = 'dehs';
        }

        $export = new LocationTemplateExport($type);
        $fileName = "location_import_template_{$type}.xlsx";

        return Excel::download($export, $fileName);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'import_type' => ['required', Rule::in(self::IMPORT_TYPES)],
            'file' => ['required', 'file', 'max:40960', 'mimes:xlsx,xls,csv'],
        ]);

        /** @var UploadedFile $file */
        $file = $validated['file'];
        $import = new LocationBulkImport($validated['import_type']);

        Excel::import($import, $file);

        $errors = $import->errors;
        $hasErrors = count($errors) > 0;

        $message = sprintf(
            'Import finished: %d new record(s) created. %d row(s) already existed (unchanged — no duplicates). %d empty row(s) skipped.',
            $import->rowsImported,
            $import->rowsDuplicate,
            $import->rowsSkipped
        );

        if ($hasErrors && $import->rowsImported === 0 && $import->rowsDuplicate === 0) {
            return redirect()
                ->route('locations.import')
                ->with('error', 'Import failed — nothing was saved to the database.')
                ->with('import_errors', $errors);
        }

        $redirect = redirect()
            ->route('locations.import')
            ->with('success', $message);

        if ($hasErrors) {
            $redirect->with('warning', 'Some rows had problems. Review the messages below.')
                ->with('import_errors', $errors);
        }

        return $redirect;
    }
}
