<?php namespace Worktrial;

use Illuminate\Database\Eloquent\Model;
use Worktrial\User;

class Task extends Model {


    protected $fillable = ['owner', 'performer', 'description', 'state'];

    //
    public function performer() {
        return $this->belongsTo('Worktrial\User', 'performer');
    }

    public function owner() {
        return $this->belongsTo('Worktrial\User', 'owner');
    }
}
