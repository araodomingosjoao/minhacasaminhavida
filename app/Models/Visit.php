<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'broker_id',
        'client_id',
        'propertie_id',
        'date',
        'type',
    ];

    public function broker()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function propertie()
    {
        return $this->belongsTo(Propertie::class, 'propertie_id');
    }

    public function statusVisita($status)
    {       
        $color     = '';

        switch ($status) {
            case 'Realizado':                
                $color     = 'verde'; 
                break;
            case 'Não realizado':                
                $color     = 'cinza'; 
                break;
            case 'Agendado':               
                $color     = 'azul'; 
                break;
        }

        return [            
            'color'     => $color,
        ];
    }
}
