<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatContent;
use App\Models\ChatImage;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SellProductController extends Controller
{
    public function index()
    {
        $userId = Session::get('user.id'); // Get the logged-in user's ID
        $chats = Chat::where('userId', $userId)->get();
        $contents = ChatContent::all();

        $images = ChatImage::all();


        return view('sellProduct', compact('chats', 'contents'));
    }

    public function closeChat(Request $request)
    {
        $chatId = $request->input('chatId');

        $chat = Chat::find($chatId);

        if ($chat) {
            $chat->delete(); // Soft delete the chat
            return redirect()->back()->with('success', 'Chat closed successfully');
        } else {
            return redirect()->back()->with('error', 'Chat not found');
        }
    }

    
    public function closeChatAdmin(Request $request)
    {
        $chatId = $request->input('chatId');

       
        $chat = Chat::find($chatId); 

        if ($chat) {
            $chat->delete();
            return redirect()->back()->with('success', 'Chat closed successfully');
        } else {
            return redirect()->back()->with('error', 'Chat not found');
        }
    }


    public function getChatContent($chatId)
    {
        $chatContents = ChatContent::where('chatId', $chatId)
            ->orderBy('created_at', 'asc') 
            ->get();

        
        $contents = $chatContents->map(function ($content) {
            return [
                'userId' => $content->userId,
                'content' => $content->content,
                'created_at' => $content->created_at->timezone('Asia/Manila')->toDateTimeString(), 
                'photo' => $content->photo 
            ];
        });

        return response()->json(['contents' => $contents], 200);
    }







    public function getChatContentAdmin($id)
    {
        $contents = ChatContent::where('chatId', $id)->get();

        // Return the contents as a JSON response
        return response()->json(['contents' => $contents]);
    }


    public function newchat(Request $request)
    {

        $userId = Session::get('user.id');

        $chat = new Chat();
        $chat->userId = $userId;
        $chat->subject = $request->input('subject');
        $chat->save();

        return redirect('sellProduct');
    }

    public function chatPost(Request $request)
    {
        // Validate the input data
        $request->validate([
            'content' => 'nullable|required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $userId = Session::get('user.id');
        $chat = Chat::where('id', $request->input('chatId'))->first();

        // Check if the chat belongs to the logged-in user
        if ($chat && $chat->userId == $userId) {
            $chatContent = new ChatContent();
            $chatContent->userId = $userId;
            $chatContent->chatId = $chat->id;
            $chatContent->content = $request->input('content');

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                // Generate a unique file name
                $fileName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                // Store the image
                $path = $request->file('photo')->storeAs('chatimages', $fileName, 'public');
                $chatContent->photo = '/storage/' . $path;
            }

            $chatContent->save();

            // Redirect back to the page with success message
            return redirect()->back();
        }

        // If the chat is invalid, return an error message
        return redirect()->back()->with('error', 'Chat not found or not authorized');
    }






    public function chatPostAdmin(Request $request)
    {
        // Assuming you have the user ID in the session
        $userId = Session::get('user.id');

        $chatContent = new ChatContent();
        $chatContent->userId = Session::get('user.id');
        $chatContent->chatId = $request->input('chatId');
        $chatContent->content = $request->input('content');
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Generate a unique file name
            $fileName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            // Store the image
            $path = $request->file('photo')->storeAs('chatimages', $fileName, 'public');
            $chatContent->photo = '/storage/' . $path;
        }

        $chatContent->save();


        return redirect()->back(); // Redirect after posting the message
    }






    public function messages()
    {
        $userId = Session::get('user.id');
        $chats = Chat::all();
        $contents = ChatContent::all();

        return view('adminPages.messages', compact('chats', 'contents'));
    }
}
