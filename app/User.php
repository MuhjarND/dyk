<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'whatsapp', 'password', 'account_password', 'role', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'account_password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAuthor()
    {
        return $this->role === 'author';
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/uploads/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=1B7A3D&color=fff';
    }

    public function getNormalizedWhatsappAttribute()
    {
        if (!$this->whatsapp) {
            return null;
        }

        $number = preg_replace('/\D+/', '', $this->whatsapp);

        if (strpos($number, '0') === 0) {
            return '62' . substr($number, 1);
        }

        if (strpos($number, '62') === 0) {
            return $number;
        }

        return $number;
    }

    public function getReadableAccountPasswordAttribute()
    {
        if (!$this->account_password) {
            return null;
        }

        try {
            return Crypt::decryptString($this->account_password);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function getWhatsappAccountMessageAttribute()
    {
        $password = $this->readable_account_password ?: '(silakan hubungi admin untuk password akun)';

        return "Halo {$this->name}, berikut akun Website Dharmayukti Karini Cabang Papua Barat:\n\n"
            . "Email: {$this->email}\n"
            . "Password: {$password}\n"
            . "Link login: " . url('/login') . "\n\n"
            . "Mohon simpan akun ini dengan baik.";
    }

    public function getWhatsappAccountUrlAttribute()
    {
        if (!$this->normalized_whatsapp) {
            return null;
        }

        return 'https://wa.me/' . $this->normalized_whatsapp . '?text=' . rawurlencode($this->whatsapp_account_message);
    }
}
