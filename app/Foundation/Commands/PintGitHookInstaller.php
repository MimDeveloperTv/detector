<?php

namespace App\Foundation\Commands;

use Illuminate\Console\Command;

class PintGitHookInstaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pint:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and integrate Pint to git hook';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $installer = new GitHookInstaller();
            $installer->install();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
