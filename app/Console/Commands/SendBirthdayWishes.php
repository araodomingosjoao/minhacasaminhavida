<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\BirthdayWishes;
use App\Models\Client;

class SendBirthdayWishes extends Command
{
    protected $signature = 'send:birthday-wishes';
    protected $description = 'Enviar desejos de aniversário aos usuários no dia do aniversário às 6h da manhã.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            // Verifique se é o dia do aniversário e a hora é 6:00 da manhã
            if ($client->birthdate == now()->format('Y-m-d') && now()->format('H:i') === '06:00') {
                Mail::to($client->email)->send(new BirthdayWishes($client));
            }
        }

        $this->info('Desejos de aniversário enviados com sucesso.');
    }
}
