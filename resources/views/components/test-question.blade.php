@props(['number'])

<x-input-label for="question_{{ $number }}" value="Question {{ $number }}" />
<x-text-input class="block mt-1 w-full" type="text" name="question_{{ $number }}" required />
<div class="block mt-1 w-full bg-gray-800 border-0" type="text">
    <input required type="radio" name="answer_{{ $number }}" value="1" checked>
    <input required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" name="option_1[]">
    <input required type="radio" name="answer_{{ $number }}" value="2">
    <input required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" name="option_2[]">
    <input required type="radio" name="answer_{{ $number }}" value="3">
    <input required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" name="option_3[]">
    <input required type="radio" name="answer_{{ $number }}" value="4">
    <input required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" type="text" name="option_4[]">
</div>
<x-input-error :messages="$errors->get('question_{{ $number }}')" class="mt-2" />