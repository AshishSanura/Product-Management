<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class ProcessProductChunk implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $rows;

	/**
	 * Create a new job instance.
	 */
	public function __construct(array $rows)
	{
		$this->rows = $rows;
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		$insertData = [];
		foreach ($this->rows as $row) {
			$name  = Arr::get($row, 'name') ?? Arr::get($row, 'Name');
			$price = Arr::get($row, 'price');
			$stock = Arr::get($row, 'stock');
			$category_id = Arr::get($row, 'category_id');
			$image = Arr::get($row, 'image');

			if (
				!$name ||
				!is_numeric($price) ||
				!is_numeric($stock) ||
				!is_numeric($category_id) ||
				$category_id <= 0
			) {
				continue;
			}
			
			$imageFile = null;
			try {
				if ($image) {
					if (filter_var($image, FILTER_VALIDATE_URL)) {
						$content = @file_get_contents($image);
						if ($content !== false) {
							$ext = pathinfo(parse_url($image, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
							$filename = Str::random(20).'.'.$ext;
							Storage::disk('public')->put("products/$filename", $content);
							$imageFile = $filename;
						}
					}
					elseif (Storage::disk('public')->exists("products/$image")) {
						$imageFile = $image;
					}
				}
			} catch (Exception $e) {
				$imageFile = null;
			}
			$insertData[] = [
				'name'        => $name,
				'description' => Arr::get($row, 'description') ?? null,
				'price'       => (float)$price,
				'category_id' => (int)$category_id,
				'stock'       => (int)$stock,
				'image'       => $imageFile,
				'created_at'  => now(),
				'updated_at'  => now(),
			];
		}
		try {
			if (!empty($insertData)) {
				Product::insert($insertData);
			}
		} catch (Exception $e) {
			throw $e;
		}
	}
}