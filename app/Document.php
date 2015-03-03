<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {

	protected $table = 'document';

	protected $fillable = ['name', 'description','photo_path'];

}
