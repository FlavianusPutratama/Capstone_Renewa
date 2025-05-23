<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewa - Solusi Energi Terbarukan</title>
    <meta name="description" content="Platform Renewable Energy Certificate untuk mendukung energi bersih di Indonesia">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <a href="/" class="font-bold text-xl text-gray-800">Renewa</a>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-green-500">Beranda</a>
                    <a href="{{ route('generatormap') }}" class="text-gray-600 hover:text-green-500">Peta Pembangkit</a>
                    <a href="#" class="text-gray-600 hover:text-green-500">Beli REC</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    @php
                        date_default_timezone_set('Asia/Bangkok');
                        $currentTime = date('H:i');
                        
                        if ($currentTime >= '01:00' && $currentTime < '10:00') {
                            $greeting = 'Pagi';
                        } elseif ($currentTime >= '10:00' && $currentTime < '14:30') {
                            $greeting = 'Siang';
                        } elseif ($currentTime >= '14:30' && $currentTime < '18:00') {
                            $greeting = 'Sore';
                        } else {
                            $greeting = 'Malam';
                        }
                    @endphp
                    <a href="{{ route('profile.show') }}" class="text-green-600 hover:text-green-700">
                        {{ $greeting }}, {{ Auth::user()->name }}!
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Logout</button>
                    </form>
                @else
                    <a href="{{ route('buyer.login') }}" class="text-green-600 hover:text-green-700">Masuk</a>
                    <a href="{{ route('buyer.register') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-16 bg-[#EAEAEA]">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl font-bold leading-tight mb-4">
                    Buktikan <span class="text-green-500">Energi Hijau</span> Anda, Kurangi <span class="text-green-500">Jejak Karbon</span> Sekarang!
                </h1>
                <p class="text-gray-600 mb-8">Kontribusi nyata dalam upaya mengurangi emisi karbon dan mendukung transisi energi bersih di Indonesia.</p>
                @auth
                    <a href="{{ route('buyer.categoryselect') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block">Beli REC</a>
                @else
                    <a href="{{ route('buyer.login') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block">Beli REC</a>
                @endauth
            </div>
            <div class="md:w-1/2">
                <img src="{{ asset('images/herocontent.svg') }}" alt="Renewable Energy Certificate" class="w-4/5 mx-auto">
            </div>
        </div>
    </section>

    <!-- Klien Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-2">Klien Kami</h2>
            <p class="text-gray-600 mb-8">Terima Kasih Atas Kontribusi Anda Terhadap Pengembangan Energi Terbarukan di Indonesia</p>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-8">
                <div class="flex justify-center items-center"><img src="{{ asset('images/Pertamina Logo.png') }}" alt="Client 1" class="h-10"></div>
                <div class="flex justify-center items-center"><img src="{{ asset('images/Indofood Logo.png') }}" alt="Client 2" class="h-10"></div>
                <div class="flex justify-center items-center"><img src="{{ asset('images/Pama Logo.png') }}" alt="Client 3" class="h-10"></div>
                <div class="flex justify-center items-center"><img src="{{ asset('images/Telkom Logo.png') }}" alt="Client 4" class="h-10"></div>
                <div class="flex justify-center items-center"><img src="{{ asset('images/MRT Jakarta Logo.png') }}" alt="Client 5" class="h-10"></div>
                <div class="flex justify-center items-center"><img src="{{ asset('images/Mandiri Logo.png') }}" alt="Client 6" class="h-10"></div>
            </div>
        </div>
    </section>

    <!-- Peran REC Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Apa Saja Peran REC?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Bukti Nyata Energi Hijau!</h3>
                    <p class="text-gray-600">Sertifikat resmi yang menunjukkan asal energi terbarukan Anda dan kontribusi dalam mengurangi emisi karbon.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <?xml version="1.0" encoding="utf-8"?>
                        <svg fill="#000000" height="45px" width="45px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.801 511.801" xmlns:bx="https://boxy-svg.com"><defs><bx:export><bx:file format="html" href="#object-0" excluded="true"/><bx:file format="html" href="#object-1" path="Untitled 2.html" excluded="true"/><bx:file format="html" href="#object-2" path="Untitled 3.html" excluded="true"/><bx:file format="html" href="#object-3" path="Untitled 4.html" excluded="true"/><bx:file format="html" href="#object-4" path="Untitled 5.html" excluded="true"/><bx:file format="html" href="#object-5" path="Untitled 6.html" excluded="true"/><bx:file format="svg" href="#object-0" excluded="true"/><bx:file format="svg" href="#object-1" path="Untitled 2.svg" excluded="true"/><bx:file format="svg" href="#object-2" path="Untitled 3.svg" excluded="true"/><bx:file format="svg" href="#object-3" path="Untitled 4.svg" excluded="true"/><bx:file format="svg" href="#object-4" path="Untitled 5.svg" excluded="true"/><bx:file format="svg" href="#object-5" path="Untitled 6.svg" excluded="true"/><bx:file format="svg" path="Untitled 7.svg"/><bx:file format="html" path="Untitled 7.html" excluded="true"/></bx:export></defs><g><g><g><path d="M 233.996 445.098 C 223.877 436.924 214.91 427.393 207.345 416.767 C 204.383 412.608 198.65 411.664 194.538 414.662 C 190.428 417.659 189.496 423.46 192.457 427.621 C 200.998 439.616 211.123 450.379 222.548 459.608 C 224.239 460.974 226.259 461.636 228.266 461.636 C 230.961 461.636 233.631 460.441 235.442 458.145 C 238.603 454.138 237.955 448.297 233.996 445.098 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;" id="object-5"/><path d="M 392.674 209.45 C 403.863 215.997 414.128 224.074 423.18 233.457 C 424.977 235.32 427.361 236.256 429.746 236.256 C 432.056 236.256 434.368 235.379 436.153 233.616 C 439.779 230.034 439.849 224.157 436.31 220.487 C 426.088 209.892 414.497 200.772 401.858 193.376 C 397.469 190.811 391.86 192.329 389.323 196.766 C 386.787 201.205 388.289 206.885 392.674 209.45 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;"/><path d="M 459.835 301.452 C 460.804 305.758 464.586 308.677 468.773 308.677 C 469.446 308.677 470.13 308.601 470.816 308.443 C 475.757 307.305 478.85 302.331 477.727 297.331 C 474.484 282.908 469.281 269.002 462.265 256.001 C 459.836 251.501 454.26 249.843 449.817 252.304 C 445.369 254.76 443.731 260.4 446.161 264.898 C 452.366 276.397 456.967 288.696 459.835 301.452 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;" id="object-0"/><path d="M 304.502 475.171 C 291.649 473.56 279.098 470.165 267.194 465.085 C 262.522 463.092 257.143 465.306 255.174 470.03 C 253.204 474.754 255.392 480.198 260.061 482.192 C 273.522 487.937 287.714 491.774 302.244 493.597 C 302.628 493.645 303.009 493.668 303.385 493.668 C 307.948 493.668 311.902 490.226 312.477 485.526 C 313.102 480.438 309.53 475.802 304.502 475.171 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;" id="object-4"/><path d="M 368.047 188.007 C 369.293 183.037 366.32 177.987 361.41 176.727 C 351.48 174.18 341.281 172.621 330.988 172.045 C 326.348 87.159 256.638 19.541 171.607 19.541 C 83.584 19.541 11.972 92 11.972 181.066 C 11.972 267.26 79.042 337.899 163.149 342.362 C 162.902 343.322 162.797 344.336 162.873 345.38 C 163.953 360.171 167.033 374.705 172.026 388.575 C 173.383 392.344 176.9 394.683 180.647 394.683 C 181.69 394.683 182.75 394.502 183.786 394.121 C 188.547 392.365 191 387.039 189.268 382.222 C 184.852 369.955 182.129 357.099 181.172 344.012 C 181.129 343.425 181.027 342.858 180.884 342.31 C 261.366 337.621 326.048 272.332 330.934 190.965 L 330.943 190.973 C 330.95 190.858 330.961 190.743 330.967 190.628 C 339.744 191.181 348.436 192.551 356.901 194.723 C 361.815 195.985 366.802 192.975 368.047 188.007 Z M 181.097 323.705 C 185.788 252.515 242.221 195.414 312.578 190.667 C 307.886 261.857 251.452 318.958 181.097 323.705 Z M 162.719 323.749 L 162.709 323.743 C 88.93 319.086 30.321 256.872 30.321 181.066 C 30.321 102.238 93.701 38.107 171.607 38.107 C 246.526 38.107 308.013 97.41 312.616 172.062 L 312.621 172.073 C 232.106 176.851 167.441 242.28 162.719 323.749 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;"/><path d="M 472.792 331.592 C 467.717 331.33 463.428 335.291 463.181 340.412 C 462.549 353.528 460.145 366.45 456.044 378.821 C 454.432 383.681 457.019 388.943 461.823 390.575 C 462.792 390.904 463.775 391.059 464.744 391.059 C 468.578 391.059 472.152 388.608 473.44 384.727 C 478.079 370.742 480.794 356.135 481.509 341.316 C 481.756 336.197 477.854 331.843 472.792 331.592 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;" id="object-1"/><path d="M 451.593 411.374 C 447.407 408.483 441.699 409.573 438.842 413.806 C 431.55 424.617 422.823 434.372 412.907 442.804 C 409.026 446.103 408.526 451.958 411.786 455.883 C 413.6 458.068 416.198 459.193 418.813 459.193 C 420.897 459.193 422.993 458.479 424.711 457.017 C 435.908 447.496 445.761 436.48 453.996 424.275 C 456.853 420.041 455.776 414.265 451.593 411.374 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;" id="object-2"/><path d="M 380.208 463.64 C 368.425 469.032 355.96 472.747 343.156 474.684 C 338.145 475.442 334.691 480.168 335.441 485.238 C 336.121 489.843 340.035 493.148 344.503 493.148 C 344.954 493.148 345.411 493.114 345.872 493.045 C 360.348 490.855 374.444 486.652 387.768 480.557 C 392.385 478.445 394.436 472.946 392.348 468.274 C 390.26 463.603 384.825 461.532 380.208 463.64 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;" id="object-3"/><path d="M 98.006 87.283 C 69.567 110.16 53.257 144.342 53.257 181.066 C 53.257 186.192 57.365 190.348 62.432 190.348 C 67.497 190.348 71.606 186.193 71.606 181.066 C 71.606 150.035 85.391 121.15 109.426 101.815 C 113.392 98.625 114.051 92.785 110.897 88.772 C 107.745 84.758 101.973 84.091 98.006 87.283 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;"/><path d="M 171.608 61.316 C 160.456 61.316 149.416 62.885 138.793 65.98 C 133.924 67.398 131.114 72.543 132.515 77.47 C 133.672 81.537 137.341 84.186 141.327 84.186 C 142.167 84.186 143.022 84.068 143.872 83.821 C 152.843 81.208 162.175 79.881 171.608 79.881 C 176.674 79.881 180.782 75.725 180.782 70.599 C 180.782 65.472 176.674 61.316 171.608 61.316 Z" style="fill: rgb(34, 197, 94); stroke: rgb(34, 197, 94); stroke-width: 11px;"/></g></g></g></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Transparansi dalam Energi Terbarukan!</h3>
                    <p class="text-gray-600">Platform yang memastikan setiap unit energi terbarukan dapat diverifikasi dan dilacak secara transparan.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <?xml version="1.0" encoding="utf-8"?>
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet" xmlns:bx="https://boxy-svg.com"><defs><bx:export><bx:file format="svg" units="px"/></bx:export></defs><g transform="matrix(0.091467, 0, 0, -0.091466, 20.0052, 489)" fill="#000000" stroke="none" style=""><path d="M4039 5091 c-28 -29 -29 -32 -29 -136 0 -137 18 -174 88 -175 22 0 41 8 57 25 24 23 25 30 25 142 -1 123 -5 139 -47 161 -35 19 -63 14 -94 -17z" style="fill: rgb(34, 197, 94);"/><path d="M3573 4975 c-12 -9 -25 -31 -29 -49 -5 -28 2 -47 42 -117 64 -113 79 -129 123 -129 56 1 99 47 87 95 -7 26 -90 170 -114 198 -19 21 -80 23 -109 2z" style="fill: rgb(34, 197, 94);"/><path d="M4518 4980 c-29 -18 -118 -184 -118 -222 0 -76 94 -107 143 -48 40 47 107 175 107 204 0 57 -80 96 -132 66z" style="fill: rgb(34, 197, 94);"/><path d="M3225 4625 c-25 -24 -32 -65 -19 -100 11 -27 187 -125 226 -125 59 0 97 58 74 113 -10 25 -34 44 -108 85 -106 58 -138 63 -173 27z" style="fill: rgb(34, 197, 94);"/><path d="M4805 4604 c-108 -63 -125 -79 -125 -124 0 -47 33 -80 79 -80 39 0 205 91 221 120 20 36 12 87 -16 109 -39 31 -71 26 -159 -25z" style="fill: rgb(34, 197, 94);"/><path d="M4005 4600 c-269 -54 -453 -305 -415 -569 22 -153 94 -271 218 -355 165 -111 370 -120 542 -23 180 101 285 322 251 524 -48 280 -326 477 -596 423z m241 -200 c186 -90 246 -320 129 -497 -62 -94 -161 -144 -283 -144 -206 0 -364 186 -331 390 37 228 276 352 485 251z" style="fill: rgb(34, 197, 94);"/><path d="M3099 4151 c-17 -18 -29 -40 -29 -56 0 -16 12 -38 29 -56 29 -28 32 -29 136 -29 110 0 156 12 169 45 13 35 6 76 -19 100 -23 24 -30 25 -140 25 -115 0 -117 0 -146 -29z" style="fill: rgb(34, 197, 94);"/><path d="M4805 4155 c-17 -16 -25 -35 -25 -57 1 -70 38 -88 175 -88 104 0 107 1 136 29 31 31 36 59 17 94 -22 42 -38 46 -161 47 -112 0 -119 -1 -142 -25z" style="fill: rgb(34, 197, 94);"/><path d="M3325 3749 c-50 -28 -98 -60 -107 -71 -24 -27 -23 -83 2 -108 36 -36 68 -36 135 -1 141 76 174 112 154 170 -11 30 -52 61 -81 61 -8 0 -54 -23 -103 -51z" style="fill: rgb(34, 197, 94);"/><path d="M4725 3789 c-32 -19 -45 -41 -45 -79 0 -45 16 -60 129 -124 70 -40 89 -47 117 -42 41 8 64 39 64 87 0 43 -9 52 -114 114 -86 51 -121 61 -151 44z" style="fill: rgb(34, 197, 94);"/><path d="M3680 3507 c-48 -24 -147 -198 -136 -240 15 -60 90 -88 134 -49 24 20 122 189 122 210 0 29 -31 70 -61 81 -18 6 -32 11 -33 11 -1 0 -12 -6 -26 -13z" style="fill: rgb(34, 197, 94);"/><path d="M4439 3505 c-32 -17 -52 -66 -40 -98 18 -47 111 -195 127 -201 57 -22 124 16 124 71 0 44 -102 215 -137 230 -36 15 -42 15 -74 -2z" style="fill: rgb(34, 197, 94);"/><path d="M1612 3393 c-70 -34 -109 -129 -84 -201 5 -16 240 -401 521 -856 l511 -826 0 -500 0 -500 -22 0 c-43 0 -102 -43 -125 -90 -19 -37 -23 -60 -23 -147 l0 -103 -470 0 -470 0 0 103 c0 87 -4 110 -22 147 -24 47 -83 90 -125 90 -23 0 -23 0 -23 170 l0 170 443 0 c464 1 491 3 539 47 29 26 58 87 58 123 0 17 -6 46 -14 64 -8 18 -184 303 -391 632 -680 1079 -662 1050 -703 1076 l-37 23 -490 0 c-548 0 -525 3 -582 -72 -24 -31 -28 -46 -28 -97 l0 -61 347 -550 348 -550 0 -486 0 -486 -36 -6 c-20 -3 -51 -17 -69 -31 -52 -40 -65 -79 -65 -200 l0 -106 -265 0 c-280 0 -304 -4 -324 -47 -18 -39 -13 -63 18 -94 l29 -29 2502 0 2502 0 29 29 c42 43 34 106 -18 130 -17 8 -287 11 -928 11 l-905 0 0 106 c0 121 -13 160 -65 200 -18 14 -49 28 -69 31 l-36 6 0 168 0 168 633 3 c605 3 633 4 664 22 18 11 42 33 55 50 29 40 37 130 14 173 -25 49 -1365 2215 -1393 2252 -48 63 -27 61 -745 61 -584 0 -657 -2 -686 -17z m1460 -408 l157 -255 -612 0 -612 0 -112 183 c-62 100 -133 215 -158 255 l-45 72 613 0 612 0 157 -255z m-1942 -350 c7 -8 57 -86 112 -172 l99 -158 -433 -3 c-238 -1 -438 0 -444 2 -13 5 -214 320 -214 336 0 7 140 10 434 10 372 0 435 -2 446 -15z m2385 -366 c99 -160 182 -295 183 -300 2 -5 -262 -9 -606 -9 l-611 0 -44 73 c-24 39 -107 174 -185 300 l-141 227 612 0 612 0 180 -291z m-1933 -344 c70 -110 127 -203 128 -208 0 -4 -199 -6 -442 -5 l-441 3 -129 204 c-70 111 -128 205 -128 207 0 2 199 3 442 2 l442 -3 128 -200z m2464 -515 c128 -206 233 -378 234 -382 0 -5 -274 -8 -608 -8 l-608 0 -224 363 c-123 199 -230 372 -238 385 l-14 22 613 -2 613 -3 232 -375z m-2066 -116 c85 -136 156 -253 158 -260 3 -12 -71 -14 -435 -14 l-438 0 -155 246 c-85 135 -156 252 -158 260 -3 12 64 14 435 14 l438 0 155 -246z m839 -201 l81 -131 0 -226 0 -226 -85 0 -85 0 0 362 c0 199 2 359 4 357 2 -2 40 -63 85 -136z m-1790 -17 l81 -130 0 -218 0 -218 -85 0 -85 0 0 352 c0 193 2 349 4 347 2 -2 40 -62 85 -133z m251 -821 l0 -85 -255 0 -255 0 0 85 0 85 255 0 255 0 0 -85z m1790 0 l0 -85 -255 0 -255 0 0 85 0 85 255 0 255 0 0 -85z" style="fill: rgb(34, 197, 94);"/><path d="M4052 3403 c-29 -12 -42 -62 -42 -168 0 -104 1 -107 29 -136 18 -17 40 -29 56 -29 16 0 38 12 56 29 29 29 29 31 29 146 0 110 -1 117 -25 140 -23 24 -69 32 -103 18z" style="fill: rgb(34, 197, 94);"/></g></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Majukan Energi Bersih!</h3>
                    <p class="text-gray-600">Mendukung pengembangan proyek energi terbarukan dan percepatan transisi energi berkelanjutan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Data dan Peta Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <img src="{{ asset('images\ilustrasi-bagian-peta.png') }}" alt="Data dan Peta Pembangkit" class="w-3/5 mx-auto">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-2xl font-bold mb-4">Lihat data dan peta pembangkit <span class="text-green-500">Energi Baru Terbarukan (EBT)</span> yang tersedia</h2>
                    <p class="text-gray-600 mb-6">Platform ini menyediakan data dan peta interaktif yang menampilkan lokasi pembangkit Energi Baru Terbarukan (EBT) di seluruh wilayah. Informasi yang disajikan mencakup kapasitas, jenis energi, dan kontribusi terhadap pengurangan emisi karbon dari setiap pembangkit.</p>
                    <a href="{{ route('generatormap') }}" class="bg-green-100 hover:bg-green-200 text-green-700 font-medium px-6 py-3 rounded-lg inline-block">Lihat Pembangkit</a>
                </div>
            </div>
        </div>
    </section>

        <!-- Potensi Energi Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-1">Potensi <span class="text-green-500">Energi Baru Terbarukan (EBT)</span> di Indonesia</h2>
            <p class="text-gray-600 mb-12">Kapasitas cadangan besar potensi EBT di Indonesia</p>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Panas Bumi</h3>
                    <p class="text-2xl font-bold">29,544 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Bayu</h3>
                    <p class="text-2xl font-bold">60,647 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Bioenergi</h3>
                    <p class="text-2xl font-bold">207,898 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Surya</h3>
                    <p class="text-2xl font-bold">94,476 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Hidro</h3>
                    <p class="text-2xl font-bold">17,989 MW</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto bg-gray-100 rounded-2xl overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3">
                        <img src="{{ asset('images/testimoni.png') }}" alt="Testimonial" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-2/3 p-8">
                        <svg class="h-8 w-8 text-gray-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <p class="text-gray-600 mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare velit at lorem auctor, ut lacinia dui condimentum. Nunc pulvinar eu mi vitae ornare. Etiam ut ultricies metus. Sed tortor felis, mattis sit amet ex sed, feugiat molestie velit. Mauris lacus tellus, porta at viverra in, venenatis vitae felis. Maecenas nec ultrices sem.</p>
                        <div>
                            <p class="font-bold">Tim Smith</p>
                            <p class="text-sm text-gray-500">Direktur Operasi, Bumi Bersih Association</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Peduli adalah pemasaran baru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8">Bergabunglah dengan komunitas yang peduli terhadap masa depan planet kita. Lihat bagaimana kontribusi Anda dapat membuat perbedaan nyata untuk lingkungan dan masyarakat.</p>
            @auth
                <a href="{{ route('buyer.login') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block">Beli REC Sekarang</a>
            @else
                <a href="{{ route('buyer.register') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block">Daftar Sekarang</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-8 md:mb-0">
                    <div class="flex items-center mb-4">
                        <svg class="h-6 w-6 text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span class="font-bold text-xl">Renewa</span>
                    </div>
                    <p class="text-gray-400 mb-4">Hak Cipta © 2025 Renewa Indonesia.<br>Seluruh hak dilindungi undang-undang.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-white"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-white"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Perusahaan</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Blog</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Hubungi Kami</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Harga</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Testimonial</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Dukungan</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Pusat Bantuan</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Syarat Layanan</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Legal</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white">Status</a></li>
                        </ul>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <h3 class="text-lg font-semibold mb-4">Tetap terhubung</h3>
                        <p class="text-gray-400 mb-4">Dapatkan update dan berita terbaru tentang energi terbarukan</p>
                        <div class="flex">
                            <input type="email" placeholder="Email anda" class="px-4 py-2 w-full rounded-l-lg focus:outline-none text-gray-800">
                            <button class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-r-lg">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>