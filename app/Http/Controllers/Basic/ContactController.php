<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    function toContact()
    {
        return view('agent.contacts.contact');
    }

    function toUserContact()
    {
        return view('user.contacts.contact');
    }
}
