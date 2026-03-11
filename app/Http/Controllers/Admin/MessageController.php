<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        // Get all unique user IDs involved in messages
        $userIds = Message::select('sender_id as user_id')
            ->whereNotNull('sender_id')
            ->union(Message::select('receiver_id as user_id')->whereNotNull('receiver_id'))
            ->get()
            ->pluck('user_id')
            ->unique()
            ->filter(function($id) {
                return $id != Auth::id(); // Exclude admin themselves if they appear
            });

        $users = User::whereIn('id', $userIds)->get()->map(function($user) {
            $user->last_message = Message::where(function($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })->latest()->first();
            return $user;
        })->sortByDesc(function($user) {
            return $user->last_message ? $user->last_message->created_at : 0;
        });

        return view('admin.messages.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $messages = Message::where(function($q) use ($id) {
            $q->where('sender_id', $id)->whereNull('receiver_id');
        })->orWhere(function($q) use ($id) {
            $q->whereNull('sender_id')->where('receiver_id', $id);
        })
        ->orWhere(function($q) use ($id) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $id);
        })
        ->orWhere(function($q) use ($id) {
            $q->where('sender_id', $id)->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark as read
        Message::where('sender_id', $id)->where('receiver_id', null)->update(['is_read' => true]);

        return view('admin.messages.show', compact('user', 'messages'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'Reply sent successfully');
    }
}
