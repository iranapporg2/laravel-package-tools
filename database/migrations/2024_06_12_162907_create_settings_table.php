<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         */
        public function up(): void {

			Schema::create('settings', function (Blueprint $table) {
                $table->id();
				$table->string('title')->nullable();
				$table->string('key')->unique();
				$table->string('value')->nullable();
                $table->timestamps();
            });

			DB::table('settings')->insert([
				[
					'title' => 'عنوان سایت',
					'key' => 'meta_title',
					'value' => ''
				],
				[
					'title' => 'متن کلیدی در مورد سایت',
					'key' => 'meta_description',
					'value' => ''
				],
				[
					'title' => 'پیج اینستاگرام',
					'key' => 'instagram',
					'value' => ''
				],
				[
					'title' => 'صفحه واتس اپ',
					'key' => 'whatsapp',
					'value' => ''
				],
				[
					'title' => 'آی دی تلگرام',
					'key' => 'telegram',
					'value' => ''
				],
				[
					'title' => 'ایمیل سایت',
					'key' => 'email',
					'value' => ''
				],
				[
					'title' => 'تلفن/شماره تماس',
					'key' => 'telephone',
					'value' => ''
				],
				[
					'title' => 'آدرس پستی',
					'key' => 'address',
					'value' => ''
				],
				[
					'title' => 'درباره سایت (کوتاه)',
					'key' => 'about_short',
					'value' => ''
				],
				[
					'title' => 'درباره سایت(بلند)',
					'key' => 'about_long',
					'value' => ''
				],
			]);

        }

        /**
         * Reverse the migrations.
         */
        public function down(): void {
            Schema::dropIfExists('settings');
        }
    };
