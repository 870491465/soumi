<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    //

    public function __construct(array $attributes = [])
    {
        $this->initCustomEvents();
        parent::__construct($attributes);
    }

    protected function initCustomEvents()
    {
        foreach ($this->getObservableEvents() as $event) {
            $event_class = '\\App\Events\\' . class_basename($this) . ucfirst($event);
            if (class_exists($event_class)) {
                $this->events[$event] = $event_class;
            }
        }
    }
}
