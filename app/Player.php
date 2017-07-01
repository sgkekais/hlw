<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\Traits\LogsActivity;

class Player extends Pivot
{
   use LogsActivity;
}
