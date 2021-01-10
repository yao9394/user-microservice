<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserStatus implements ShouldBroadcast
{
    public $user;

    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    /**
	 * Get the channels the event should be broadcast on.
	 *
	 * @return array
	 */
	public function broadcastOn()
	{
		return ['UserStatus.' . $this->user->id];
    }
}
