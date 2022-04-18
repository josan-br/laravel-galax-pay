<?php

namespace JosanBr\GalaxPay\Commands;

use Illuminate\Console\Command;

class Publish extends Command
{
    private $configPath;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'galax-pay:publish';

    /**
     * The console command <description class=""></description>
     *
     * @var string
     */
    protected $description = 'Publish config and migrations from galax pay';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->configPath = app()->basePath('config/galax_pay.php');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $chosen = $this->choice('What will be published?', ['config', 'migrations']);

        switch ($chosen) {
            case 'config':
                $this->publishConfig();
                break;
            case 'migrations':
                $this->publishMigrations();
                break;

            default:
                $this->error('Invalid option!');
        }
    }

    private function publishConfig()
    {
        try {
            if (file_exists($this->configPath)) {
                $this->error('There is already a galax_pay.php in the config folder');
                return;
            } else {
                copy(__DIR__ . '/../../config/galax_pay.php', $this->configPath);
            }

            $this->info('Published configuration!');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }

    private function publishMigrations()
    {
        if (!file_exists($this->configPath)) {
            if ($this->confirm('To publish the migrations you must have published the config before. Publish now?', 'yes'))
                $this->publishConfig();
            else return;
        }

        $migrations = [
            ['create_galax_pay_clients_table.php.stub', 'create_galax_pay_clients_table.php'],
            ['create_galax_pay_sessions_table.php.stub', 'create_galax_pay_sessions_table.php'],
        ];

        if ($this->handleMigrationsAlreadyPublished($migrations)) return;

        foreach ($migrations as $migration) {
            list($from, $to) = $migration;
            copy(__DIR__ . "/../../database/migrations/${from}", $this->getMigrationPath($to));
        }

        $this->info('Publishing migrations!');
    }

    private function getMigrationPath($migrationSuffix, $prefix = null)
    {
        $date = $prefix ?: date('Y_m_d_His');
        return app()->basePath("database/migrations/${date}_{$migrationSuffix}");
    }

    /**
     * Handle migrations already published
     *
     * @return bool
     */
    private function handleMigrationsAlreadyPublished($migrations)
    {
        $message = 'Migrations that have already been published:';

        $paths = [];

        foreach ($migrations as $migration) {
            $matchingFiles = glob($this->getMigrationPath($migration[1], '*'));

            if ($matchingFiles && count($matchingFiles) > 0) {
                list($migrationPath) = $matchingFiles;
                $message .= PHP_EOL . "> ${migrationPath}";
                array_push($paths, $migrationPath);
            }
        }

        if (count($paths) == 0) return false;

        $this->warn($message);

        if ($this->confirm('Want to remove and publish again?', 'yes')) {
            foreach ($paths as $path) unlink($path);
            return false;
        } else return true;
    }
}
