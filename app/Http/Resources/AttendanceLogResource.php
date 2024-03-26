<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type === 1) {
            $type = 'TIME IN';
        }
        else if ($this->type === 0) {
            $type = 'TIME OUT';
        }
        else {
            $type = "UNKNOWN TYPE";
        }

        $roleMapping = [
            0 => 'Admin',
            1 => 'Faculty',
            2 => 'Staff',
            3 => 'Student',
        ];

        $user = User::where('rfid', $this->rfid)
                    ->first();

        return [
            'rfid' => $this->rfid,
            'type' => $type,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => [
                'name' => $user->name,
                'role' => $roleMapping[$user->role],
            ]
        ];
    }
}
