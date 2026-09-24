<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreBorrowingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === 'user_gedung';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string|object>|string>
     */
    public function rules(): array
    {
        return [
            'origin_building_id' => ['required', 'integer', 'exists:buildings,id'],
            'target_building_id' => [
                'required',
                'integer',
                Rule::in([$this->user()?->building_id]),
            ],
            'item_type' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'borrow_date' => ['required', 'date'],
            'return_date' => ['required', 'date', 'after_or_equal:borrow_date'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny(['origin_building_id', 'item_type'])) {
                    return;
                }

                $availableCount = Asset::query()
                    ->where('building_id', $this->integer('origin_building_id'))
                    ->where('name', $this->string('item_type')->toString())
                    ->where('status', Asset::STATUS_AVAILABLE)
                    ->count();

                if ($availableCount < $this->integer('quantity')) {
                    $validator->errors()->add('quantity', "Jumlah unit yang tersedia hanya {$availableCount}.");
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'target_building_id.in' => 'Gedung tujuan harus sesuai dengan gedung user yang login.',
            'return_date.after_or_equal' => 'Estimasi kembali harus sama atau setelah tanggal pinjam.',
        ];
    }
}
