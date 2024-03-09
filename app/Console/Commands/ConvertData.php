<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Size;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConvertData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-data';

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
        $data = DB::connection('crawl')->table('products');
        $products = $data->where('status', 0)->get();

        $size = Size::all();

        foreach ($products as $item) {
            try {
                //code...

            $category = Category::firstOrCreate(['name' => $item->category], [
                'slug' => Str::slug($item->category, '-'),
                'parent_id' => 1,
            ]);
            $product = new Product();
            $product->name = $item->name;
            $product->slug = Str::slug($item->name, '-');
            $product->price = str_replace([' ₫', '.'], '', $item->price);
            $product->category_id = $category->id;
            $product->brand_id = array_rand([1, 2]);
            $product->image = $this->saveImage($item->image);
            $product->save();

            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->path = $product->image;
            $productImage->save();

            foreach ($size as $s) {
                $productSize = new ProductSize();
                $productSize->product_id = $product->id;
                $productSize->size_id = $s->id;
                $productSize->quantity = 10;
                $productSize->save();
            }

            DB::connection('crawl')->table('products')
            ->where('id', $item->id)->update(['status' => 1]);

            $this->info('Product ' . $item->name . ' has been converted');
        } catch (Exception $exception) {
            $this->error('Product ' . $item->name . ' has been error');

            continue;
        }
        }
    }

    protected function saveImage($url)
    {
        //save image from url

        $name = Str::random(10) . '.jpg';
        $path = public_path('products/' . $name);

        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->get($url);

        $content = $response->getBody()->getContents();

        file_put_contents($path, $content);

        return $name;
    }
}
