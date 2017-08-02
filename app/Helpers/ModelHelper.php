<?php

namespace HLW\Helpers;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ModelHelper{

    /**
     * @param Model $model
     * @param $description = ['created', 'updated', 'deleted']
     * @return User $causer
     */
    public static function causerOfAction(Model $model, $description)
    {
        $causer = Activity::where([
            ['description', $description],
            ['subject_id', $model->id],
            ['subject_type', 'HLW\\' . class_basename($model)],
        ])->orderBy('updated_at','desc')->first();

        // did we find a log entry?
        if ($causer) {
            // then return the user
            return $causer->causer;
        } else {
            // else return null
            return $causer;
        }
    }
}