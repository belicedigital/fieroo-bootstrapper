<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->default('img/logo.png');
            $table->text('email_pending_admit_exhibitor_it')->nullable();
            $table->text('email_pending_admit_exhibitor_en')->nullable();
            $table->text('email_to_admin_pending_notification_admit')->nullable();
            $table->text('email_admit_exhibitor_it')->nullable();
            $table->text('email_admit_exhibitor_en')->nullable();
            $table->text('email_to_admin_notification_admit')->nullable();
            $table->text('email_confirm_order_it')->nullable();
            $table->text('email_confirm_order_en')->nullable();
            $table->text('email_to_admin_notification_confirm_order')->nullable();
            $table->text('email_event_subscription_it')->nullable();
            $table->text('email_event_subscription_en')->nullable();
            $table->text('email_registration_it')->nullable();
            $table->text('email_registration_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
