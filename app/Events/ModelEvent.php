<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/10
 * Time: 23:08
 */

namespace App\Events;

use App\Models\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Support\Str;

abstract class ModelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var model
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Model
     */
    public function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function type()
    {
        return Str::snake(class_basename($this), '.');
    }

}