<?php

namespace App\Http\Requests;

/**
 * The request for time synchronization endpoint to check the received parameters by some rules
 * PHP version >= 8.0
 *
 * @category Requests
 * @package  Future
 * @author   Hamed Ghasempour <hamedghasempour@gmail.com>
 */
class TimeSynchronizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param array|mixed|null $keys
     *
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data["timestamp"] = $this->route()[2]["timestamp"];
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "timestamp" => "required|integer|digits:10",
        ];
    }
}
