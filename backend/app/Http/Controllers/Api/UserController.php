<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendOtpNotification; // Pastikan Anda memiliki notifikasi ini

class UserController extends Controller
{
  // Metode untuk mengirim OTP
  public function sendOtp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->messages()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['error' => 'User not found'], 404);
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    $user->otp = $otp; // Pastikan kolom OTP ada di tabel pengguna
    $user->save();

    // Kirim OTP melalui notifikasi
    Notification::send($user, new SendOtpNotification($otp));

    return response()->json(['message' => 'OTP sent successfully']);
  }

  // Metode untuk memverifikasi OTP
  public function verifyOtp(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email',
      'otp' => 'required|integer',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->messages()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || $user->otp !== $request->otp) {
      return response()->json(['error' => 'Invalid OTP'], 400);
    }

    // OTP valid, lanjutkan ke reset password
    return response()->json(['message' => 'OTP verified, proceed to reset password']);
  }

  // Update resetPassword method
  public function resetPassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email',
      'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->messages()], 422);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['error' => 'User not found'], 404);
    }

    $user->password = bcrypt($request->password);
    $user->save();

    return response()->json(['message' => 'Password reset successfully']);
  }

  public function update(Request $request, User $user)
  {
    $data = $request->only('name', 'email', 'password');

    $validator = Validator::make($data, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|unique:users,email,' . $user->id,
      'password' => 'sometimes|nullable|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->messages()], 422);
    }

    if ($request->has('password')) {
      $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return response()->json(['message' => 'User updated successfully']);
  }

  public function checkEmail(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    return response()->json(['exists' => $user ? true : false]);
  }

  public function findByEmail(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    return response()->json(['user' => $user]);
  }

  public function getAll()
  {
    $users = User::all();

    return response()->json(['users' => $users]);
  }

  public function getById(User $user)
  {
    return response()->json(['user' => $user]);
  }

  public function getByEmail(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    return response()->json(['user' => $user]);
  }

  public function delete(User $user)
  {
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
  }
}
