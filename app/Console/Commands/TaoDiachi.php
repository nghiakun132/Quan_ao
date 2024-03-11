<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TaoDiachi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tao-diachi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //read file excel
        $file = public_path('ward.xls');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheetData as $key => $row) {
            try {
                if ($key == 0) {
                    continue;
                }

                $province = \App\Models\Province::where('name', $row[7])->first();
                if (empty($province)) {
                    $province = new \App\Models\Province();
                    $province->name = $row[7];
                    $province->code = Str::slug($row[7], '-');
                    $province->save();
                }

                $district = \App\Models\District::where('name', $row[5])->first();
                if (empty($district)) {
                    $district = new \App\Models\District();
                    $district->name = $row[5];
                    $district->code = Str::slug($row[5], '-');
                    $district->province_id = $province->id;
                    $district->save();
                }

                $ward = \App\Models\Ward::where('name', $row[1])->first();
                if (empty($ward)) {
                    $ward = new \App\Models\Ward();
                    $ward->name = $row[1];
                    $ward->code = Str::slug($row[1], '-');
                    $ward->province_id = $province->id;
                    $ward->district_id = $district->id;
                    $ward->save();
                }

                $this->info('Imported: ' . $row[1]);

            } catch (\Exception $e) {
                $this->error('Error: ' . $e->getMessage());

                continue;
            }
        }
    }
}
