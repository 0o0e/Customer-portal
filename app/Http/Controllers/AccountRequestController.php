<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountRequestController extends Controller
{
    // Show the account request form
    public function create()
    {
        return view('auth.request-account');
    }

    // Store the account request
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'customer_number' => 'required|string|max:50|unique:users,No|unique:account_requests,customer_number',
            'email' => 'required|email|unique:account_requests,email|unique:users,email',
        ]);

        try {
            AccountRequest::create([
                'company_name' => $validatedData['company_name'],
                'customer_number' => $validatedData['customer_number'],
                'email' => $validatedData['email'],
                'status' => 'pending'
            ]);

            return view('auth.request-success');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to submit request. Please try again.');
        }
    }

    // Approve account request
    public function approve(AccountRequest $accountRequest)
    {
        try {
            // Create the user account with the requested customer number
            $password = Str::random(8);
            
            $user = User::create([
                'name' => $accountRequest->company_name,
                'email' => $accountRequest->email,
                'password' => Hash::make($password),
                'No' => $accountRequest->customer_number, // Use requested customer number
                'usertype' => 'user',
            ]);

            // Update request status
            $accountRequest->update(['status' => 'approved']);

            // Send welcome email
            $this->sendWelcomeEmail($user, $password);

            return back()->with('success', 'Account request approved and user created successfully.');
        } catch (\Exception $e) {
            \Log::error('Account approval failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to approve account request.');
        }
    }

    // Reject account request
    public function reject(AccountRequest $accountRequest)
    {
        try {
            $accountRequest->update(['status' => 'rejected']);
            return back()->with('success', 'Account request rejected.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject account request.');
        }
    }

    // Send welcome email to new user
    private function sendWelcomeEmail($user, $password)
    {
        try {
            Mail::send('emails.credentials', [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
                'client_number' => $user->No,
            ], function($message) use ($user) {
                $message->to($user->email)
                       ->subject('Your Özgazi Account Credentials');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }
    }
}

