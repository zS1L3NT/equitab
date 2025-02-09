<?php

namespace App\Events;

abstract class ModelChanged
{
    public ?array $old = null;
    public ?array $new = null;

    public function broadcastWith(): array
    {
        $old_flat = $this->old ? array_map(fn($v) => is_array($v) ? json_encode($v) : $v, $this->old) : null;
        $new_flat = $this->new ? array_map(fn($v) => is_array($v) ? json_encode($v) : $v, $this->new) : null;
        $keys = array_diff($new_flat ?? [], $old_flat ?? []) + array_diff($old_flat ?? [], $new_flat ?? []);

        return [
            'id' => $this->old['id'] ?? $this->new['id'],
            'old' => $this->old ? array_intersect_key($this->old, $keys) : null,
            'new' => $this->new ? array_intersect_key($this->new, $keys) : null,
        ];
    }
}
