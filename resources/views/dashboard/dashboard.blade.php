<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href={{asset('storage/'.$setting->logo)}} type="image/x-icon">
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"  />
<link rel="stylesheet" href="{{asset('dash.css')}}" >

    </head>
<body>
    @if ($setting)
    <style>
         :root {
    --sidebar-color: {{ $setting->sidebar_color}};
}

    </style>

    @else
    <style>
        :root {
    --sidebar-color:#054A91 ;
}

   </style>
    @endif
    <div class="content-dashboard">
        <div class="content-sidebar">@yield('sidebar')</div>
        <div class="dashboard">
            @include('dashboard.topbar')
            <div class="content-dash">
                @include('partials.alerts')
                @yield('content')
            </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <script>
        // هذا الكود يضمن عدم إعادة تنفيذه إلا مرة واحدة
        if (typeof colorPickerSync === 'undefined') {
            const colorPickerSync = () => {
                document.querySelectorAll('.color-picker-group').forEach(group => {
                    const swatch = group.querySelector('.color-picker-swatch');
                    const hexInput = group.querySelector('.color-picker-hex');

                    if (swatch.dataset.initialized) return;

                    swatch.addEventListener('input', () => {
                        hexInput.value = swatch.value.toUpperCase();
                    });

                    hexInput.addEventListener('input', () => {
                        swatch.value = hexInput.value;
                    });

                    swatch.dataset.initialized = 'true';
                });
            };

            document.addEventListener('DOMContentLoaded', colorPickerSync);
        }
     </script>
</body>
</html>