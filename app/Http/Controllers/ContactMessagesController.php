<?php

namespace App\Http\Controllers;


use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ContactMessagesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $messages = Contact::where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('contact-messages.index')
            ->with('messages', $messages);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $message = Contact::where('id', $id)->first();

        if ($message == null) {
            return redirect('/messages')->with('error', 'Contact message not found!');
        }

        return view('contact-messages.show')
            ->with('message', $message);
    }


    public function deleteContactMessage($id)
    {
        if (Auth::user()->isAdmin()) { // only admin can delete users
            $message = Contact::findOrFail($id);;

            if ($message) {
                $message->delete();
                return redirect()->route('contactMessagesIndex')
                    ->with('success', 'Contact message deleted successfully');
            }
        } else {
            return redirect()->route('contactMessagesIndex')
                ->with('warning', 'You don\'t have permissions to delete personages');
        }

        return redirect()->route('contactMessagesIndex');

    }
}
