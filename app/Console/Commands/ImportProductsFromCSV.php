<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ImportProductsFromCSV extends Command
{
    protected $signature = 'import:csv {file}';
    protected $description = 'Imports products and categories from a CSV file into the database';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1;
        }

        $this->info("Processing CSV file: $filePath");

        $file = fopen($filePath, 'r');
        $headers = fgetcsv($file);

        if (!$headers) {
            $this->error("No headers found in CSV.");
            fclose($file);
            return 1;
        }

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) != count($headers)) {
                    $this->error("Skipping row due to mismatched columns: " . implode(',', $row));
                    continue;
                }

                $row[count($row) - 1] = implode(';', array_slice($row, count($row) - 1));

                $data = array_combine($headers, $row);

                $category = Category::where('name', $data['category_name'])->first();

                if (!$category) {
                    $category = Category::create([
                       'name' => $data['category_name'],
                       'deparment_name' => $data['deparment_name']
                    ]);
                }

                Product::create([
                    'product_number'   => $data['product_number'],
                    'category_id'      => $category->id,
                    'manufacturer_name' => $data['manufacturer_name'],
                    'upc'              => $data['upc'],
                    'sku'              => $data['sku'],
                    'regular_price'    => $data['regular_price'],
                    'sale_price'       => $data['sale_price'],
                    'description'      => $data['description'] ?? null,
                ]);
            }

            DB::commit();
            $this->info("CSV file successfully imported!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error importing CSV: " . $e->getMessage());
        }

        fclose($file);
        return 0;
    }
}

