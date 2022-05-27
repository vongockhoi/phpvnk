<?php

namespace App\Helpers;

use App\Constants\Globals\Role as RoleConstant;
use App\Models\Device;

class CommonHelper
{
    public static function findDeviceToken($restaurant_id)
    {
        $device_token = Device::where(function($query) use ($restaurant_id) {
            $query->orWhereHas('user', function($q) use ($restaurant_id) {
                $q->whereHas('roles', function($e) {
                    $e->where('roles.id', RoleConstant::ROLE['RESTAURANT_MANAGER']);
                });
                $q->whereHas('restaurants', function($e) use ($restaurant_id) {
                    $e->where('restaurants.id', $restaurant_id);
                });
            });
            $query->orWhereHas('user', function($q) {
                $q->whereHas('roles', function($e) {
                    $e->whereIn('roles.id', [RoleConstant::ROLE['ADMIN_TECH'], RoleConstant::ROLE['SUPER_MANAGER']]);
                });
            });
        })->whereNotNull('device_token')
            ->whereIn('platform', [Device::PLATFORM['Android'], Device::PLATFORM['IOS']])
            ->pluck('device_token')->all();

        return $device_token;
    }
}
