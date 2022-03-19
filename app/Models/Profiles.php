<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Profiles
 *
 * @method static where(string $string, $chat_id)
 * @property mixed|string $tg_id
 * @property mixed|string $last_name
 * @property mixed|string $first_name
 * @property mixed $username
 * @property mixed|string $language
 * @property mixed|string $state
 * @property int|mixed $status
 * @property int $id
 * @property string|null $phone_number
 * @property float $balance
 * @property int|null $parent
 * @property string|null $optional
 * @property int $plan_id
 * @property int $clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereOptional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereTgId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profiles whereUsername($value)
 * @mixin \Eloquent
 */
class Profiles extends Model
{
    use HasFactory;
    public $timestamps = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profiles';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
}
