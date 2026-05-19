<?php

namespace App\Helpers;

use Illuminate\Validation\Rules\Password;
class ValidationHelper
{
    /**
     * function for the validation rule for first name
     *
     * @return string
     */
    public static function descriptionValidationRule(): string
    {
        return 'nullable|string';
    }

    /**
     * function for Image validation rule
     */
    public static function imageValidationRule(): string
    {
        return 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048';
    }

    /**
     * function for Image validation rule
     */
    public static function orderValidationRule(): string
    {
        return 'required|integer';
    }

    /**
     * function for the id validation rule
     *
     * @param string $table
     * @param string $column
     * @return string
     */
    public static function idExistsValidationRule(string $table, string $column = 'id'): string
    {
        return "required|exists:{$table},{$column}";
    }

    /**
     * function for the unique validation rule
     *
     * @param string $table
     * @param string $column
     * @return string
     */
    public static function uniqueNumberValidationRule(string $table, string $column = 'id'): string
    {
        return "required|numeric|unique:{$table},{$column}";
    }

    /**
     * function for the unique validation rule
     *
     * @param string $table
     * @param string $column
     * @return string
     */
    public static function uniqueValidationRule(string $table, string $column = 'id'): string
    {
        return "unique:{$table},{$column}";
    }

    /**
     * function for the validation rule for first name
     *
     * @return string
     */
    public static function firstNameValidationRule(): string
    {
        return 'required|string|max:50';
    }

    /**
     * function for the validation rule for last name
     *
     * @return string
     */
    public static function lastNameValidationRule(): string
    {
        return 'nullable|string|max:50';
    }

    /**
     * function for the validation rule for name
     *
     * @return string
     */
    public static function nameValidationRule(): string
    {
        return 'string|max:50';
    }

    /**
     * function for the validation rule for email
     *
     * @return string
     */
    public static function emailValidationRule(): string
    {
        return 'required|email|unique:users,email';
    }

    /**
     * function for validation related to mobile number
     *
     * @return string
     */
    public static function mobileNoValidationRule(): string
    {
        return 'required|digits_between:10,12|unique:users,mobile_no';
    }

    /**
     * function for the validation rule for password 
     *
     * @return array
     */
    public static function passwordValidationRule(): array
    {
        return ['required', Password::min(8)->mixedCase()];
    }

    /**
     * funtion for the validation rule of url
     *
     * @return string
     */
    public static function urlValidationRule(): string
    {
        return 'url';
    }
}
