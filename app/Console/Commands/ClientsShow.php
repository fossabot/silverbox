<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ByteUnits\Binary as ByteUnits;
use Illuminate\Support\Facades\Storage;

class ClientsShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clients:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show list of clients';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $clients = [];

        foreach (Storage::directories() as $directory) {
            $size = ByteUnits::bytes(0);

            foreach (Storage::allFiles($directory) as $file) {
                $size = $size->add(ByteUnits::bytes(Storage::size($file)));
            }

            $clients[] = [
                $directory,
                $size->asMetric()->format(null, ' '),
                Storage::exists($directory . DIRECTORY_SEPARATOR . '.key') ? 'yes' : 'no',
            ];
        }

        $this->table(['client', 'usage', 'key'], $clients);
    }
}
