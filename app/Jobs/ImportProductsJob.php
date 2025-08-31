<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\LazyCollection;
class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;
    public $userId;
    public $chunkSize = 1000;

    /**
     * Create a new job instance.
     */
    public function __construct($path, $userId = null)
    {
        $this->path = $path;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fullPath = storage_path('app/public/'.$this->path);

		LazyCollection::make(function () use ($fullPath) {
			$handle = fopen($fullPath, 'r');
			if ($handle === false) return;

			$header = null;
			while (($line = fgetcsv($handle,0,",")) !== false) {
				if (!$header) { $header = $line; continue; }
				yield array_combine($header, $line);
			}
			fclose($handle);
		})->chunk($this->chunkSize)
		  ->each(function ($chunk) {
			  \App\Jobs\ProcessProductChunk::dispatch($chunk->all());
		  });
    }
}
