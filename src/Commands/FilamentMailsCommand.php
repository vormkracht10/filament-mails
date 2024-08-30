<?php

namespace Vormkracht10\FilamentMails\Commands;

use Illuminate\Console\Command;

class FilamentMailsCommand extends Command
{
    public $signature = 'filament-mails';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
