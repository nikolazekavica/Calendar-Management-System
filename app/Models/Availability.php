<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 6.4.2022.
 * Time: 21:41
 */

namespace App\Models;

use App\Helpers\Constants;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 */
class Availability extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dateFormat = Constants::DATE_FORMAT_MYSQL;

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
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}