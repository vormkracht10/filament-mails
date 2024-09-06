<?php

namespace Vormkracht10\FilamentMails\Models;

use Vormkracht10\Mails\Models\Mail as BaseModel;

class Mail extends BaseModel
{
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'subject' => 'string',
        'from' => 'string',
        'reply_to' => 'string',
        'to' => 'string',
        'cc' => 'string',
        'bcc' => 'string',
        'opens' => 'integer',
        'clicks' => 'integer',
        'sent_at' => 'datetime',
        'resent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'last_opened_at' => 'datetime',
        'last_clicked_at' => 'datetime',
        'complained_at' => 'datetime',
        'soft_bounced_at' => 'datetime',
        'hard_bounced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getStatusAttribute(): string
    {
        if ($this->hard_bounced_at) {
            return 'Hard Bounced';
        } elseif ($this->soft_bounced_at) {
            return 'Soft Bounced';
        } elseif ($this->complained_at) {
            return 'Complained';
        } elseif ($this->last_clicked_at) {
            return 'Clicked';
        } elseif ($this->last_opened_at) {
            return 'Opened';
        } elseif ($this->delivered_at) {
            return 'Delivered';
        } elseif ($this->resent_at) {
            return 'Resent';
        } elseif ($this->sent_at) {
            return 'Sent';
        } else {
            return 'Unsent';
        }
    }
}