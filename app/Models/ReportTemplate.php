<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'parameter', 'report_of',
        'recipients', 'object', 'important',
        'mailing',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'object' => 'object',
        'recipients' => 'array'
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
