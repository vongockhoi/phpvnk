<?php

namespace App\Jobs\Product;

use App\Helpers\LoggingHelper;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReUpImageProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = Product::get();

        $shouldDeletes = [];
        foreach ($products as $product) {
            $files = $product->getMedia('avatar');
            if (!empty($files)) {
                foreach ($files as $file) {
                    $path = $file->getPath();
                    try {
                        $product->addMedia($path)->toMediaCollection('avatar');
                        $shouldDeletes[] = $file->id;
                    } catch (\Exception $e) {
                        LoggingHelper::logException($e);
                    }
                }
                foreach ($product->getMedia('avatar') as $file) {
                    if (in_array($file->id, $shouldDeletes)) {
                        $file->delete();
                    }
                }
                print_r($product->id);
                print_r($shouldDeletes);
            }
        }
    }
}
