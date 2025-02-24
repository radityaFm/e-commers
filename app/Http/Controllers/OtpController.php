<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OtpService;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $this->otpService->sendOtp($request->email);

        return response()->json(['message' => 'OTP telah dikirim ke email Anda.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string',
        ]);

        if ($this->otpService->verifyOtp($request->email, $request->otp_code)) {
            return response()->json(['message' => 'OTP valid.']);
        }

        return response()->json(['message' => 'OTP tidak valid atau telah kedaluwarsa.'], 400);
    }
}