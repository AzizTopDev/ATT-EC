<?php

namespace Webkul\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Webkul\CMS\Contracts\ShopNotification as ShopNotificationContract;

class ShopNotification extends Model implements ShopNotificationContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'shop_notifications';

    protected $fillable = [
        'display_flag', 'admin_name', 'title', 'content', 'deleted_flag', 'deleted_at'
    ];
}