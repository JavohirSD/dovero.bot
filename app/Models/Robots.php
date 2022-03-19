<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Robots
 *
 * @property mixed|string $phone_number
 * @property mixed|string $created_date
 * @property mixed|string $last_response
 * @property int|mixed $status
 * @property int $id
 *
 * @property \Illuminate\Support\Carbon|null $updated_date
 * @method static \Illuminate\Database\Eloquent\Builder|Robots newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Robots newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Robots query()
 * @method static \Illuminate\Database\Eloquent\Builder|Robots whereCreatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Robots whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Robots whereLastResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Robots wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Robots whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Robots whereUpdatedDate($value)
 * @mixin \Eloquent
 */
class Robots extends Model
{
    use HasFactory;
    public $timestamps = true;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    const INACTIVE_ROBOT = 0;
    const ACTIVE_ROBOT = 1;
    const FAILED_ROBOT = 2;
    const SPAMMED_ROBOT = 3;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'robots';

}
