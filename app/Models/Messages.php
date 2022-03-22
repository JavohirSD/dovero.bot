<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Messages
 *
 * @property mixed|string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property mixed|string $receiver
 * @property mixed|string $receiver_telegram_id
 * @property int|mixed $profile_id
 * @property int|mixed $status
 * @property int $id
 * @property int|null $robot_id
 *
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

    public const WAITING_MESSAGE = 0;
    public const DELIVERED_MESSAGE = 1;
    public const FAILED_MESSAGE = 2;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

}
