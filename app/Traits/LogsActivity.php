<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            static::logActivity('created', $model);
        });

        static::updated(function ($model) {
            static::logActivity('updated', $model);
        });

        static::deleted(function ($model) {
            static::logActivity('deleted', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'module' => class_basename($model),
                'details' => json_encode($model->getChanges()),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        }
    }
}
