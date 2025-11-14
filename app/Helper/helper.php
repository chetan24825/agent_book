<?php

use App\Models\Inc\Upload;
use App\Models\Inc\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Orders\CommissionInstallment;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = BusinessSetting::where('type', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}







if (!function_exists('current_guard')) {
    function current_guard()
    {
        $request = request();

        // Check if the user is authenticated with the admin guard or is accessing an admin URL
        if ($request->is('admin/*') && Auth::guard('admin')->check()) {
            return 'admin';
        }

        // Check if the user is authenticated with the agent guard or is accessing an agent URL
        if ($request->is('agent/*') && Auth::guard('agent')->check()) {
            return 'agent';
        }

        // Check if the user is authenticated with the web guard
        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null; // Return null if no guards are authenticated
    }
}




if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = (isHttps() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return $root;
    }
}

if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        return getBaseURL() . 'public/';
    }
}


if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset($path, $secure);
            // return app('url')->asset('public/' . $path, $secure);
        }
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return null;
    }
}


if (!function_exists('order_installment')) {
    function order_installment($id)
    {
        return CommissionInstallment::where('order_id', $id)->where('status', 1)->sum('payment_amount');
    }
}


if (!function_exists('order_installment_pending')) {
    function order_installment_pending($id)
    {
        return CommissionInstallment::where('order_id', $id)->where('status', 0)->count();
    }
}



if (!function_exists('formatUrl')) {
    /**
     * Remove 'http://' or 'https://' from a given URL.
     *
     * @param string $url
     * @return string
     */
    function formatUrl($url)
    {
        // Remove 'http://' or 'https://' from the URL
        return preg_replace('#^https?://#', '', rtrim($url, '/'));
    }
}




if (!function_exists('uploaded_asset_path')) {
    function uploaded_asset_path($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return $asset->file_name;
        }
        return null;
    }
}
