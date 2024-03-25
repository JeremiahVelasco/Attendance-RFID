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
    // TODO : Fix view because it user details are not being displayed
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

        return [
            'rfid' => $this->rfid,
            'type' => $type,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => User::where('rfid', $this->rfid)
                        ->first()
        ];
    }
}
