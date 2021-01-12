<?php

namespace Motocle\Email\Http\Controllers;

use Illuminate\Http\Request;
use Motocle\Email\Models\SystemEmail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('email::email.admin.index');
    }

    public function create()
    {
        return view('email::email.admin.create');
    }

    public function edit(SystemEmail $systemEmail)
    {
        $systemEmail->variables = !empty($systemEmail->variables) ? unserialize($systemEmail->variables) : [];

        $data = [];
        $data['email'] = $systemEmail;
        return view('email::email.admin.edit')
            ->with($data);
    }

    public function update(Request $request, SystemEmail $systemEmail)
    {
        $request->validate([
            'senderName' => 'required|string',
            'senderEmail' => 'required|string',
            'subject' => 'required|string',
            'senderEmail' => 'required|string|email',
            'mailContent' => 'required|string',
        ]);

        $systemEmail->sender_name = $request->input('senderName');
        $systemEmail->sender_email = $request->input('senderEmail');
        $systemEmail->subject = $request->input('subject');
        $systemEmail->content = $request->input('mailContent');
        $systemEmail->save();

        return redirect()->route('motocle.cms.email.admin.index')->with('success', trans('email::app.cms.email.update-success'));
    }
}
