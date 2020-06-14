<?php

namespace App\Model\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AuctionItem extends Model
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'char_inventory', 'until', 'price', 'price_instead'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getItemInformation()
    {
        return $this->belongsTo(CharInventory::class,'char_inventory', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getItemSortForFilter()
    {
        return $this->belongsTo(CharInventory::class, 'char_inventory', 'id');
    }

    /**
     * Route notifications for the Discord channel.
     *
     * @return string
     */
    public function routeNotificationForDiscord(): string
    {
        return 'https://discordapp.com/api/webhooks/721855978240213054/yBEznLCZ52WZipu6BqWTkwtt4828lfdj4IbFtFyqzi7ITDzvF_xPZjxX-MSMDlnyimzA';
    }
}
