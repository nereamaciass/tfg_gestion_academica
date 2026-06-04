<?php

namespace App\Events;

use App\Models\Mensaje;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MensajeEnviado implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Mensaje enviado
     */
    public $mensaje;

    /**
     * Create a new event instance.
     */
    public function __construct(Mensaje $mensaje)
    {
        $this->mensaje = $mensaje->load('emisor');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->mensaje->receptor_id),
            new PrivateChannel('chat.' . $this->mensaje->emisor_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'mensaje' => [
                'id' => $this->mensaje->id,
                'mensaje' => $this->mensaje->mensaje,
                'archivo' => $this->mensaje->archivo,
                'emisor_id' => $this->mensaje->emisor_id,
                'receptor_id' => $this->mensaje->receptor_id,

                'emisor' => [
                    'id' => $this->mensaje->emisor->id,
                    'name' => $this->mensaje->emisor->name,
                ],
            ]
        ];
    }

}