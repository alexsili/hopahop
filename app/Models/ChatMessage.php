<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = array('*');

    /**
	 * Sender initials.
	 * @return string
	 */
	public function getSenderAttribute()
	{
        $userId = $this->created_by;
        $user = User::findOrFail($userId);

		return ucfirst($user->first_name).' '.ucfirst($user->last_name);
	}
}
