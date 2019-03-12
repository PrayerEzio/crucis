<?php

namespace App\Console\Commands;

use App\Http\Services\SwooleService;
use Illuminate\Console\Command;

class SwooleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swoole command';

    protected $serv;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SwooleService $swooleService)
    {
        $argument = $this->argument('action');
        switch ($argument)
        {
            case 'start':
                $this->info('swoole websocket server started.');
                $this->serv = $swooleService->httpServer();
                break;
            case 'stop':
                break;
            case 'restart':
                break;
        }
    }
}