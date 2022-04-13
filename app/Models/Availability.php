<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 6.4.2022.
 * Time: 21:41
 */

namespace App\Models;

use App\Helpers\Constants;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */
class Availability extends Model
{
    public $timestamps = false;

    protected $dateFormat = Constants::DATE_FORMAT_MYSQL;
    protected $timeFormat = Constants::TIME_FORMAT_MYSQL;

    protected $responseDateFormat = Constants::DATE_FORMAT_PROJECT;
    protected $responseTimeFormat = Constants::TIME_FORMAT_PROJECT;

    protected $table      = 'availabilities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'title',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'availability_status',
        'description',
        'is_recurrences',
        'start_date_recurrences',
        'end_date_recurrences',
        'user_id',
        'timezone'
    ];

    protected $attributes = [
        'timezone' => 'Europe/Belgrade'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'start_date_recurrences',
        'end_date_recurrences'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'start_date',
        'end_date',
        'start_date_recurrences',
        'end_date_recurrences',
        'is_recurrences',
        'user_id'];

    public function getStartDateAttribute()
    {
        $startDate = Carbon::createFromFormat($this->dateFormat, $this->attributes['start_date']);
        return $startDate->format($this->responseDateFormat);
    }

    public function getEndDateAttribute()
    {
        $endDate = Carbon::createFromFormat($this->dateFormat, $this->attributes['end_date']);
        return $endDate->format($this->responseDateFormat);
    }

    public function getStartDateRecurringAttribute()
    {
        $startDate = Carbon::createFromFormat($this->dateFormat, $this->attributes['start_date_recurrences']);
        return $startDate->format($this->responseDateFormat);
    }

    public function getEndDateRecurringAttribute()
    {
        $startDate = Carbon::createFromFormat($this->dateFormat, $this->attributes['end_date_recurrences']);
        return $startDate->format($this->responseDateFormat);
    }

    public function getStartTimeAttribute()
    {
        $startTime= Carbon::createFromFormat($this->timeFormat, $this->attributes['start_time']);
        return $startTime->format($this->responseTimeFormat);
    }

    public function getEndTimeAttribute()
    {
        $endTime = Carbon::createFromFormat($this->timeFormat, $this->attributes['end_time']);
        return $endTime->format($this->responseTimeFormat);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}