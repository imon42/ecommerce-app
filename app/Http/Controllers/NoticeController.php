<?php

namespace App\Http\Controllers;

use App\Events\StatusLiked;
use App\Models\NoticeFromAdmin;
use App\Models\User;
use App\Notifications\NoticeFromAdmin as NotificationsNoticeFromAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    //create notice
    public function createNotice(Request $request)
    {

        // Validate request
        $request->validate([
            'notice' => 'required|string|max:500',
            'file' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        $filename = null;

        if($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        // Create notice
        $notice = NoticeFromAdmin::create([
            'notice' => $request->input('notice'),
            'file' => $filename,

        ]);

        // Notify all users
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new NotificationsNoticeFromAdmin($notice->notice));
        }

        return response()->json([
            'message' => 'Notice created successfully!',
            'notice' => $notice,
        ], 201);
    }

    //display notice;
    public function displayNotice()
    {

        $notices = NoticeFromAdmin::all();
        return response()->json([
            'notices' => $notices,
        ]);
    }

    //send notification;
    public function sendNotification()
    {
        event(new StatusLiked("notification is send successfully"));
        return response()->json([
            "message" => "notification sent",
        ], );
    }
}
