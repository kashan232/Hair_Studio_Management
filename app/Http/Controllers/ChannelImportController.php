<?php

namespace App\Http\Controllers;

use App\Exports\ChannelTemplateExport;
use App\Imports\ChannelBulkImport;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ChannelImportController extends Controller
{
    protected const IMPORT_TYPES = [
        'barrages',
        'main_canals',
        'sub_canals',
        'branch_canals',
        'distributaries',
        'minors',
        'watercourses',
    ];

    public function index()
    {
        return view('channels.import');
    }

    public function template(Request $request)
    {
        $type = $request->query('type', 'watercourses');
        if (! in_array($type, self::IMPORT_TYPES, true)) {
            $type = 'watercourses';
        }

        $export = new ChannelTemplateExport($type);
        $fileName = "channel_import_template_{$type}.xlsx";

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
        $import = new ChannelBulkImport($validated['import_type']);

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
                ->route('channels.import')
                ->with('error', 'Import failed — nothing was saved to the database.')
                ->with('import_errors', $errors);
        }

        $redirect = redirect()
            ->route('channels.import')
            ->with('success', $message);

        if ($hasErrors) {
            $redirect->with('warning', 'Some rows had problems. Review the messages below.')
                ->with('import_errors', $errors);
        }

        return $redirect;
    }
}
