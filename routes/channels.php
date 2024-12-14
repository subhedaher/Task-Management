<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('task-created', function ($user) {
    return true;
}, ['guards' => ['member']]);

Broadcast::channel('task-comment', function ($user) {
    return true;
}, ['guards' => ['member']]);
