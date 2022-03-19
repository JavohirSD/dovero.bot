<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Messages
 *
 * @method static where(string $string, $chat_id)
 * @property mixed|string $message
 * @property mixed|string $created_date
 * @property mixed|string $receiver
 * @property mixed|string $description
 * @property int|mixed $profile_id
 * @property int|mixed $status
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $updated_date
 * @property int|null $robot_id
 * @method static \Illuminate\Database\Eloquent\Builder|Messages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Messages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Messages query()
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereCreatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereRobotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Messages whereUpdatedDate($value)
 * @mixin \Eloquent
 */
class Messages extends Model
{
    use HasFactory;
    public $timestamps = true;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

}
