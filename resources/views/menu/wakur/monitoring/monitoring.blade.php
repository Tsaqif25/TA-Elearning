@foreach ($gurus as $guru)
    <tr>
        <td>{{ $guru->name }}</td>

        <td>
            <a href="{{ route('monitoring.guru.detail', $guru->id) }}"
               class="text-blue-600 hover:underline">
               Detail →
            </a>
        </td>
    </tr>
@endforeach
