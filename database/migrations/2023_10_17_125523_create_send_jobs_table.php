<?php

use App\Models\EmailList;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmailList::class)->constrained();
            $table->integer('total_recipients');
            $table->integer('progress');
            $table->enum('status',['inprogress', 'completed', 'failed', 'cancelled']);
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
        Schema::dropIfExists('send_jobs');
    }
};
