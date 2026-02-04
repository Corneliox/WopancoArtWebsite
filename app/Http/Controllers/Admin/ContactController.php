<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;

class ContactController extends Controller
{
    /**
     * Display a list of all contact submissions (For the Admin Sidebar).
     */
    public function index()
    {
        $submissions = ContactSubmission::latest()->paginate(20);
        
        return view('admin.contact.index', [
            'submissions' => $submissions
        ]);
    }

    /**
     * Mark a submission as seen (For the Green Tick).
     */
    public function update(ContactSubmission $submission)
    {
        $submission->update(['is_seen' => true]);
        
        return back()->with('status', 'Message marked as seen.');
    }

        /**

         * Send a reply to the contact submission.

         */

        public function reply(Request $request, ContactSubmission $submission)

        {

            $request->validate([

                'reply_message' => 'required|string|min:5',

            ]);

    

            // Send Email using the 'smtp_admin' configuration

            Mail::mailer('smtp_admin')

                ->to($submission->email)

                ->send(new ContactReplyMail($submission, $request->reply_message));

    

            // Mark as seen if not already

            if (!$submission->is_seen) {

                $submission->update(['is_seen' => true]);

            }

    

            return back()->with('status', 'Reply sent successfully!');

        }

    }

    