<?php

class Sentry_Install {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// create user table
		Schema::table(Config::get('sentry::sentry.table.users'), function($table) {
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('username');
			$table->string('email');
			$table->string('password');
			$table->string('password_reset_hash');
			$table->string('temp_password');
			$table->string('remember_me');
			$table->string('activation_hash');
			$table->string('ip_address');
			$table->integer('last_login');
			$table->integer('updated_at');
			$table->integer('created_at');
			$table->string('status');
			$table->string('activated');
			$table->text('permissions');
		});

		// create user metadata table
		Schema::table(Config::get('sentry::sentry.table.users_metadata'), function($table) {
			$table->create();
			$table->integer('user_id')->primary()->unsigned();
			$table->string('first_name');
			$table->string('last_name');
		});

		// create groups table
		Schema::table(Config::get('sentry::sentry.table.groups'), function($table) {
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->text('permissions');
		});

		// create users group relation table
		Schema::table(Config::get('sentry::sentry.table.users_groups'), function($table) {
			$table->create();
			$table->integer('user_id')->unsigned();
			$table->integer('group_id')->unsigned();
		});

		// create suspension table
		Schema::table(Config::get('sentry::sentry.table.users_suspended'), function($table) {
			$table->create();
			$table->increments('id')->unsigned();
			$table->string('login_id');
			$table->integer('attempts');
			$table->string('ip');
			$table->integer('last_attempt_at');
			$table->integer('suspended_at');
			$table->integer('unsuspend_at');
		});

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// drop all tables
		Schema::drop(Config::get('sentry::sentry.table.users'));
		Schema::drop(Config::get('sentry::sentry.table.users_metadata'));
		Schema::drop(Config::get('sentry::sentry.table.groups'));
		Schema::drop(Config::get('sentry::sentry.table.users_groups'));
		Schema::drop(Config::get('sentry::sentry.table.users_suspended'));
	}

}