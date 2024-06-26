<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         */
        public function up(): void {

			Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('username',255);
                $table->string('password',255);
                $table->string('full_name',255);
                $table->string('avatar',255)->nullable();
                $table->timestamps();
            });

			DB::table('admins')->insert([
				'username' => 'admin',
				'password' => Hash::make('12345'),
				'full_name' => 'مدیریت'
			]);

        }

        /**
         * Reverse the migrations.
         */
        public function down(): void {
            Schema::dropIfExists('admins');
        }
    };
