<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DatasetController extends Controller
{
    /**
     * Show dataset management page with real data.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Property::query();
        if ($search) {
            $query->where('lokasi', 'like', "%{$search}%");
        }

        $properties = $query->orderByDesc('id')->paginate(10);
        $totalCount = Property::count();

        return view('admin.dataset', compact('properties', 'totalCount', 'search'));
    }

    /**
     * Upload and import an Excel/CSV dataset.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'dataset_file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('dataset_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        $header = array_shift($rows);
        $headerMap = array_flip(array_map('trim', $header));

        $imported = 0;
        foreach ($rows as $row) {
            $hargaCol = $this->getCol($headerMap, 'harga');
            if (empty($row[$hargaCol])) continue;

            Property::create([
                'tahun'         => (int) ($row[$this->getCol($headerMap, 'tahun')] ?? date('Y')),
                'luas_tanah'    => (int) $row[$this->getCol($headerMap, 'luas_tanah')],
                'luas_bangunan' => (int) $row[$this->getCol($headerMap, 'luas_bangunan')],
                'kmr_tidur'     => (int) $row[$this->getCol($headerMap, 'kmr_tidur')],
                'kmr_mandi'     => (int) $row[$this->getCol($headerMap, 'kmr_mandi')],
                'usia'          => (int) ($row[$this->getCol($headerMap, 'usia')] ?? 0),
                'lokasi'        => trim($row[$this->getCol($headerMap, 'lokasi')] ?? ''),
                'tipe_properti' => trim($row[$this->getCol($headerMap, 'tipe_properti')] ?? 'Minimalis'),
                'kondisi'       => trim($row[$this->getCol($headerMap, 'kondisi')] ?? 'Bekas'),
                'ada_garasi'    => (bool) ($row[$this->getCol($headerMap, 'ada_garasi')] ?? 0),
                'harga'         => (int) $row[$hargaCol],
            ]);
            $imported++;
        }

        return redirect()->route('admin.dataset')
            ->with('success', "Berhasil mengimpor {$imported} data properti baru.");
    }

    /**
     * Delete a property record.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.dataset')
            ->with('success', 'Data properti berhasil dihapus.');
    }

    private function getCol(array $headerMap, string $name): string
    {
        return array_search($name, array_flip($headerMap)) ?: 'A';
    }
}
