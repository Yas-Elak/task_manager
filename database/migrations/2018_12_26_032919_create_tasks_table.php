<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('description');
            $table->integer('owner_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('priority_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->timestamps();
            $table->date('wanted_start_datetime')->nullable();
            $table->date('real_start_datetime')->nullable();
            $table->date('wanted_end_datetime')->nullable();
            $table->date('real_end_datetime')->nullable();
            $table->boolean('is_active')->default(1);


        });

        Schema::create('priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->boolean('is_active')->default(1);

            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('description');
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('priority_id')->unsigned()->nullable();
            $table->integer('manager_id');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->text('description');
            $table->string('agent_id');
            $table->string('owner_id');
            $table->integer('task_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('status_id')->unsigned();
            $table->integer('priority_id')->unsigned();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('task_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('audits', function (Blueprint $table) {
            $table->increments('id');
            $table->text('operation');
            $table->integer('user_id')->unsigned();
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->integer('task_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('comment_id')->unsigned()->nullable();


            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->boolean('moderate')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('task_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('ticket_id')->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::create('project_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('project_notification')->default(1);
            $table->boolean('project_email')->default(1);
            $table->boolean('task_notification')->default(1);
            $table->boolean('task_email')->default(1);
            $table->boolean('ticket_notification')->default(1);
            $table->boolean('ticket_email')->default(1);
            $table->boolean('comment_notification')->default(1);
            $table->boolean('comment_email')->default(1);
            $table->timestamps();
        });
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('project_id')->unsigned()->default(0);
            $table->integer('task_id')->unsigned()->default(0);
            $table->integer('ticket_id')->unsigned()->default(0);
            $table->integer('comment_id')->unsigned()->default(0);
            $table->string('type');
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
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('priorities');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_user');
        Schema::dropIfExists('audits');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('components');
        Schema::dropIfExists('options');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('notifications');



    }
}
