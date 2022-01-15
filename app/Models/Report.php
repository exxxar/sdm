<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'period', 'regularity',
        'parameter', 'report_of', 'recipients',
        'object', 'automatic', 'important',
        'mailing', 'is_active','is_hidden',
        'start_period_date','end_period_date'
    ];

      /**
       * The attributes that should be cast to native types.
       *
       * @var array
       */
    protected $casts = [
        'object' => 'object',
        'recipients' => 'array',
        'start_period_date' => 'datetime',
        'end_period_date' => 'datetime',
    ];

    protected $appends = [
        'recipients_emails'
    ];

    public function getRecipientsEmailsAttribute()
    {
        $emails = [];
        if(!is_null($this->recipients) && count($this->recipients))
        {
            foreach ($this->recipients as $recipient) {

                $user = User::find($recipient);
                if(!is_null($user) && isset($user))
                {
                    array_push($emails, $user->email);
                }

            }
        }
        return $emails;
    }
}
