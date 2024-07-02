<?php

namespace App\Http\Controllers;

use App\Helpers\RoleHelper;
use App\Http\Resources\MaintenanceResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UtilityController extends Controller
{
    public function maintenanceShow()
    {
        try {
            return new MaintenanceResource();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function maintenanceToggle()
    {
        try {
            $user = Auth::user();

            if (!$user->hasRole(RoleHelper::ADMINISTRATOR)) {
                return Response::deny("You're not authorized to set maintenance mode");
            }

            app()->maintenanceMode()->active() ? Artisan::call('up') : Artisan::call('down');
            return new MaintenanceResource();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
