<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Inc\Notification;
use App\Models\Inc\YoutubeVideo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Packages\Package;

class BasicController extends Controller
{

    function toLogout()
    {
        Auth::guard(current_guard())->logout();
        request()->session()->invalidate(); // Invalidate the session
        request()->session()->regenerateToken(); // Regenerate the CSRF token for security
        return redirect()->route('site.index');
    }


    public function toAdvertiserVideosAdd(Request $request)
    {
        $validatedData = $request->validate([
            'youtubelink' => 'required|url|unique:youtube_videos,links',
        ]);

        $videoLink = new YoutubeVideo();
        $videoLink->user_id = Auth::id();
        $videoLink->guard = current_guard();
        $videoLink->links = $validatedData['youtubelink'];

        if ($videoLink->save()) {
            return redirect()->back()->with('success', 'Video added successfully.');
        }

        return redirect()->back()->with('error', 'Video not added.');
    }

    public function Notifications()
    {
        $guard = null;
        $prefix = null;
        if (Auth::guard(current_guard())->check()) {
            $prefix = 'admin.layouts.app';
            if (current_guard() == 'admin') {
                $prefix = 'admin.layouts.app';
            }
            if (current_guard() == 'advertiser') {
                $prefix = 'advertisers.layouts.app';
            }
            if (current_guard() == 'agent') {
                $prefix = 'agent.layouts.app';
            }
        }
        $notifications = Notification::where('user_id', Auth::id())
            ->where('guard', current_guard())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notification.notification', compact('notifications', 'prefix'));
    }


    public function packageShow(){

         $packages = Package::where('status', 1)->orderByRaw('CAST(price AS DECIMAL(10,2)) ASC')->get();
        return view('package.packages', compact('packages'));
    }
}
