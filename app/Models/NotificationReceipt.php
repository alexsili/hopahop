<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationReceipt extends Model
{
	use SoftDeletes;

	protected $table = 'notifications_receipts';

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
