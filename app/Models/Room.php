<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    protected $fillable = ['number','image', 'area', 'price', 'status', 'description', 'max_people'];
    public $timestamps = false;

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        $path = str_replace('\\', '/', $this->image);
        $path = preg_replace('#^(?:/?storage/)+#', '', $path);
        $path = preg_replace('#^(Images/)+#', 'Images/', ltrim($path, '/'));

        return Storage::url($path);
    }
}
