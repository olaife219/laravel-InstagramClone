<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }

            return '/storage/' . $this->image;
        }

        return 'https://res.cloudinary.com/dyen2qt0p/image/upload/v1733917471/uploads/profile-picture/custom-name-1733917440432.png';
        // $imagePath = ($this->image) ? $this->image : '/profile/b40sSzsOJd1ogbwbSEQ1qbiwjh0tvtTGgTig25cj.png';
        // return '/storage/' . $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
