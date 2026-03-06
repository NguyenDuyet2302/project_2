<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * Các cột được phép lưu vào Database (Mass Assignment)
     * ĐÃ XÓA: 'start_date' để khớp với Database hiện tại
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone',
        'id_card',
        'address',
        'role',
    ];

    // BẢO MẬT: Giấu các cột nhạy cảm đi khi truy xuất dữ liệu
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu để Laravel xử lý chuyên nghiệp hơn
     * ĐÃ XÓA: 'start_date' => 'date'
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Tự động mã hóa mật khẩu
            'role' => 'integer',    // Đảm bảo role luôn là số nguyên
        ];
    }
}
