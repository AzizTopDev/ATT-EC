<?php

namespace Motocle\Newsletter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Motocle\Email\Models\SystemEmail;
use Motocle\Newsletter\Jobs\SendNewsletter;
use Motocle\Newsletter\Mail\NewsletterEmail;
use Motocle\Newsletter\Models\Newsletter;
use Motocle\Newsletter\Models\NewsletterTemplate;
use Webkul\Core\Models\SubscribersList;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('newsletter::admin.index');
    }

    public function history()
    {
        return view('newsletter::admin.history');
    }

    public function view(Newsletter $newsletter)
    {
        $data = [];
        $data['newsletter'] = $newsletter;

        return view('newsletter::admin.history_view')
            ->with($data);
    }

    public function create()
    {
        return view('newsletter::admin.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'subject' => 'required|string',
            'content' => 'required|string',
        ];

        if ($request->input('nlClickedAction') == 'save' || $request->input('nlClickedAction') == 'send') {
            $rules['name'] = 'required|string|unique:newsletter_templates,name';
        }

        if ($request->input('nlClickedAction') == 'test') {
            $rules['email'] = 'required|string|email';
        }

        $messages = [
            'name.required' => trans('newsletter::app.cms.newsletter.validation.name.required'),
            'name.unique' => trans('newsletter::app.cms.newsletter.validation.name.unique'),
            'subject.required' => trans('newsletter::app.cms.newsletter.validation.subject.required'),
            'content.required' => trans('newsletter::app.cms.newsletter.validation.content.required'),
            'email.required' => trans('newsletter::app.cms.newsletter.validation.email.required'),
            'email.email' => trans('newsletter::app.cms.newsletter.validation.email.email'),

        ];

        $request->validate($rules, $messages);

        if ($request->input('nlClickedAction') == 'save') {
            $this->saveTemplate($request, new NewsletterTemplate);
            return redirect()->route('admin.motocle.cms.dm.index');
        }

        if ($request->input('nlClickedAction') == 'test') {
            $this->sendTest($request);
            return redirect()->back()->withInput();
        }

        if ($request->input('nlClickedAction') == 'send') {
            $this->sendNewsletter($request);
            $this->saveTemplate($request, new NewsletterTemplate);
            return redirect()->back()->withInput();
        }

        return redirect()->back()->withInput();
    }

    public function edit(NewsletterTemplate $newsletterTemplate)
    {
        $data = [];
        $data['template'] = $newsletterTemplate;
        return view('newsletter::admin.edit')
            ->with($data);
    }

    public function update(Request $request, NewsletterTemplate $newsletterTemplate)
    {
        $rules = [
            'name' => 'required|string',
            'subject' => 'required|string',
            'content' => 'required|string',
        ];

        if ($request->input('nlClickedAction') == 'save') {
            $rules['name'] = 'required|string|unique:newsletter_templates,name,' . $newsletterTemplate->id;
        }

        if ($request->input('nlClickedAction') == 'test') {
            $rules['email'] = 'required|string|email';
        }

        $messages = [
            'name.required' => trans('newsletter::app.cms.newsletter.validation.name.required'),
            'name.unique' => trans('newsletter::app.cms.newsletter.validation.name.unique'),
            'subject.required' => trans('newsletter::app.cms.newsletter.validation.subject.required'),
            'content.required' => trans('newsletter::app.cms.newsletter.validation.content.required'),
            'email.required' => trans('newsletter::app.cms.newsletter.validation.email.required'),
            'email.email' => trans('newsletter::app.cms.newsletter.validation.email.email'),

        ];

        $request->validate($rules, $messages);

        if ($request->input('nlClickedAction') == 'save') {
            $this->saveTemplate($request, $newsletterTemplate);
            return redirect()->route('admin.motocle.cms.dm.index');
        }

        if ($request->input('nlClickedAction') == 'test') {
            $this->sendTest($request);
            return redirect()->back()->withInput();
        }

        if ($request->input('nlClickedAction') == 'send') {
            $this->sendNewsletter($request);
            return redirect()->back()->withInput();
        }

        return redirect()->back()->withInput();
    }

    public function destroy(NewsletterTemplate $newsletterTemplate)
    {
        if ($newsletterTemplate->delete()) {
            session()->flash('success', trans('newsletter::app.cms.newsletter.delete_template_success'));

            return response()->json(['message' => true], 200);
        } else {
            session()->flash('success', trans('newsletter::app.cms.newsletter.save_delete_failure'));

            return response()->json(['message' => false], 200);
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,gif,png|max:2000'
        ],
            [
                'image.required' => 'Please select image file',
                'image.max' => 'Image file should be less than 2MB',
                'image.*' => 'Only jpg, gif and png files allowed',
            ]);

        $imagePath = 'newsletter/images';

        $filePath = $request->file('image')
            ->store($imagePath, 'public');

        return response()->json([
            'location' => asset('storage/' . $filePath)
        ]);
    }

    protected function saveTemplate(Request $request, NewsletterTemplate $newsletterTemplate)
    {
        $newsletterTemplate->name = $request->input('name');
        $newsletterTemplate->subject = $request->input('subject');
        $newsletterTemplate->content = $request->input('content');
        $newsletterTemplate->save();

        session()->flash('success', trans('newsletter::app.cms.newsletter.save_template_success'));
    }

    protected function sendTest(Request $request)
    {
        $testEmailData = new \StdClass();
        $testEmailData->subject = $request->input('subject');
        $testEmailData->content = $request->input('content');

        try {
            $newsletter = (new NewsletterEmail($testEmailData));

            Mail::to($request->input('email'))
                ->queue($newsletter);

            session()->flash('success', trans('newsletter::app.cms.newsletter.test_email_success'));
        } catch (\Exception $e) {
            session()->flash('info', trans('newsletter::app.cms.newsletter.test_email_failure'));
        }
    }

    protected function sendNewsletter(Request $request)
    {
        $newsletterData = new \StdClass();
        $newsletterData->subject = $request->input('subject');
        $newsletterData->content = $request->input('content');

        try {
            SendNewsletter::dispatch($newsletterData);

            // Artisan::call('queue:work', ['connection' => 'database', '--queue' => 'newsletter', '--once' => true]);
            //  for test only
            exec(PHP_BINDIR . '/php ' . base_path() . '/artisan queue:work database --queue=newsletter --sansdaemon > /dev/null 2>&1 &');

            $newsletter = new Newsletter;
            $newsletter->name = $request->input('name');
            $newsletter->subject = $request->input('subject');
            $newsletter->content = $request->input('content');
            $newsletter->count = SubscribersList::where('is_subscribed', 1)->count();
            $newsletter->save();

            session()->flash('success', trans('newsletter::app.cms.newsletter.send_success'));
        } catch (\Exception $e) {
            session()->flash('info', trans('newsletter::app.cms.newsletter.send_failure'));
        }
    }
}
