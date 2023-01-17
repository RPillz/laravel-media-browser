<?php

namespace RPillz\LaravelMediaBrowser\Commands;

use Illuminate\Console\Command;

class LaravelMediaBrowserCommand extends Command
{
    public $signature = 'laravel-media-browser';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
