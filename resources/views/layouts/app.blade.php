<!DOCTYPE html>
<html lang="en">
<head>
    {{-- css --}}
   @include('layouts.css')
    {{-- tutup css --}}
</head>
<body>


    {{-- Navbar --}}
   @include('layouts.header')
 {{-- end navbar --}}

    {{-- Wrapper untuk Sidebar + Konten --}}
    <div class="wrapper">
        {{-- Sidebar --}}
       @include('layouts.sidebar')
  {{-- tutup sidebar --}}

        {{-- Konten Utama --}}
        <div class="content">
            @yield('content')
        </div>
    </div>

 {{-- js --}}
   @include('layouts.js')
    {{-- tutup js --}}
</body>
</html>





