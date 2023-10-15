@props(['options', 'select' => 0, 'disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'block w-full p-2 text-md text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']) }}>
    @if($select == 0)
    <option value="{{ $options[0] }}" selected>{{ ucfirst($options[0]) }}</option>
    <?php array_shift($options) ?>
    @foreach ((array) $options as $option)
        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
    @endforeach
    @else
    @foreach ((array) $options as $option)
        <option value="{{ $option }}" {{ ($select == $option) ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
    @endforeach
    @endif
</select>
