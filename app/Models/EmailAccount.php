<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAccount extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'incoming_encryption',
        'incoming_port',
        'incoming_server',
        'outgoing_encryption',
        'outgoing_port',
        'outgoing_server',
        'password',
        'username',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
