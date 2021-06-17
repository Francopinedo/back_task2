<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Timezone extends Model {

		protected $table = 'timezones';
		public $timestamps = true;
		protected $fillable = array('timezone');

	}