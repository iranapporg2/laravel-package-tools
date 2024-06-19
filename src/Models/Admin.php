<?php

	namespace iranapp\Tools\Models;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Admin extends Authenticatable {
        use HasFactory;

        protected $guarded = [];

        protected $casts = [
            'password' => 'hashed'
        ];

    }
