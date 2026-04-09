<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private function ensureIsUser(User $user)
    {
        abort_if($user->role !== 'user', 403, 'Aksi ini hanya berlaku untuk data pengguna biasa.');
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'user')->latest();

        if ($request->filled('search')) {
            $query->search($request->search); 
        }

        $filter = $request->get('filter', 'all');

        match ($filter) {
            'premium'  => $query->where('is_premium', true),
            'free'     => $query->where('is_premium', false),
            'new'      => $query->where('created_at', '>=', now()->subDays(7)),
            'inactive' => $query->where('is_active', false),
            default    => null,
        };

        $users = $query->paginate(10)->withQueryString();

        $stats = User::where('role', 'user')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_premium = 1 THEN 1 ELSE 0 END) as premium')
            ->selectRaw('SUM(CASE WHEN is_premium = 0 THEN 1 ELSE 0 END) as free')
            ->selectRaw('SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as new', [now()->subDays(7)])
            ->selectRaw('SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive')
            ->first();

        $counts = [
            'all'      => (int) $stats->total,
            'premium'  => (int) $stats->premium,
            'free'     => (int) $stats->free,
            'new'      => (int) $stats->new,
            'inactive' => (int) $stats->inactive,
        ];

        return view('admin.users.index', compact('users', 'counts', 'filter'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user'; 

        if ($request->boolean('is_premium')) {
            $data['premium_expires_at'] = now()->addMonth(); 
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->ensureIsUser($user);
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->ensureIsUser($user);

        $data = $request->validated();

        if ($request->boolean('is_premium') && !$user->is_premium) {
            $data['premium_expires_at'] = now()->addMonth();
        } 
        elseif (!$request->boolean('is_premium')) {
            $data['premium_expires_at'] = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        unset($data['password']);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->ensureIsUser($user);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function resetPasswordForm(User $user)
    {
        $this->ensureIsUser($user);

        return view('admin.users.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, User $user)
    {
        $this->ensureIsUser($user);

        $request->validate([
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'password.letters'   => 'Password harus mengandung huruf.',
            'password.mixed'     => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers'   => 'Password harus mengandung angka.',
            'password.symbols'   => 'Password harus mengandung simbol.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', "Password untuk {$user->name} berhasil direset.");
    }

    public function toggleActive(User $user)
    {
        $this->ensureIsUser($user);

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    public function togglePremium(User $user)
    {
        $this->ensureIsUser($user);

        if (!$user->is_premium) {
            $user->activatePremium(); 
            $status = 'diupgrade ke paket PRO (Aktif 1 Bulan)';
        } else {
            $user->update([
                'is_premium' => false,
                'premium_expires_at' => null
            ]);
            $status = 'didowngrade ke paket FREE';
        }

        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }
}