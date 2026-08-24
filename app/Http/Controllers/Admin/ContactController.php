<?php

namespace App\Http\Controllers\Admin;

use App\ContactStatus;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::query()->latest()->paginate(30);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact): View
    {
        if ($contact->read_at === null) {
            $contact->forceFill(['read_at' => now()])->save();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate(['status' => ['required', Rule::enum(ContactStatus::class)]]);
        $contact->update($validated);

        return back()->with('success', 'Đã cập nhật trạng thái liên hệ.');
    }
}
