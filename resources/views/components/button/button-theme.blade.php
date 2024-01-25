@props(['class'])

<div>
    <a id="bd-theme" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="bi bi-brightness-high-fill text-warning"></i>
    </a>

    <ul class="{{ $class }}">
        <li>
            <button type="button" class="dropdown-item" data-bs-theme-value="light" aria-pressed="false">
            <i class="bi bi-brightness-high-fill text-warning"></i>
            {{ __('label.light') }}
            </button>
        
        </li>
        <li>
            <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
            <i class="bi bi-moon-stars-fill me-1"></i>
            {{ __('label.dark') }}
            </button>
        </li>
    </ul>
</div>