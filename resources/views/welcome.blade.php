<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshClean Laundry - Layanan Laundry Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        .gradient-bg {
            background-color: #56C5D0;
        }
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold" style="color: #56C5D0;">FC</span>
                    </div>
                    <span class="text-2xl font-bold">FreshClean Laundry</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="hover:text-gray-200 transition">Beranda</a>
                    <a href="#services" class="hover:text-gray-200 transition">Layanan</a>
                    <a href="#about" class="hover:text-gray-200 transition">Tentang</a>
                    <a href="#contact" class="hover:text-gray-200 transition">Kontak</a>
                </div>
                <button class="md:hidden text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="gradient-bg text-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-5xl font-bold mb-6">Laundry Bersih, Wangi & Rapi dalam 24 Jam!</h1>
                    <p class="text-xl mb-8">Layanan laundry profesional dengan harga terjangkau. Gratis antar jemput!</p>
                    <button onclick="scrollToServices()" class="bg-white px-8 py-4 rounded-full font-semibold transition shadow-lg" style="color: #56C5D0;" onmouseover="this.style.backgroundColor='#AEE4FF'" onmouseout="this.style.backgroundColor='white'">
                        Lihat Layanan
                    </button>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="float-animation">
                        <svg class="w-80 h-80" viewBox="0 0 200 200" fill="none">
                            <circle cx="100" cy="100" r="80" fill="white" opacity="0.2"/>
                            <rect x="60" y="50" width="80" height="100" rx="10" fill="white"/>
                            <circle cx="100" cy="90" r="25" fill="#A8E6CF"/>
                            <path d="M85 90 Q100 100 115 90" stroke="white" stroke-width="3" fill="none"/>
                            <rect x="70" y="130" width="60" height="5" rx="2" fill="#56C5D0"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
            <div style="background-color: #56C5D0; margin-top: -5px;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#E8EBEF" fill-opacity="1" d="M0,96L24,101.3C48,107,96,117,144,117.3C192,117,240,107,288,101.3C336,96,384,96,432,117.3C480,139,528,181,576,192C624,203,672,181,720,165.3C768,149,816,139,864,154.7C912,171,960,213,1008,234.7C1056,256,1104,256,1152,218.7C1200,181,1248,107,1296,90.7C1344,75,1392,117,1416,138.7L1440,160L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z"></path>
        </svg>
    </div>
    </section>

    <!-- Wave Divider -->


    <!-- Services Section -->
    <section id="services" class="py-10" style="background-color: #E8EBEF;">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4" style="color: #56C5D0;">Layanan Kami</h2>
                <p class="text-gray-700 text-lg">Pilih layanan yang sesuai dengan kebutuhan Anda</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="service-card bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #AEE4FF;">
                        <svg class="w-10 h-10" style="color: #56C5D0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: #56C5D0;">Cuci Kering</h3>
                    <p class="text-gray-600 mb-6">Pakaian dicuci bersih dan dikeringkan dengan mesin pengering modern</p>
                    <p class="text-3xl font-bold mb-4" style="color: #56C5D0;">Rp 6.000<span class="text-lg">/kg</span></p>
                    <button class="text-white px-6 py-3 rounded-full transition" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#45a3ad'" onmouseout="this.style.backgroundColor='#56C5D0'">Pesan Sekarang</button>
                </div>

                <!-- Service 2 -->
                <div class="service-card bg-white rounded-xl shadow-lg p-8 text-center border-4 relative" style="border-color: #56C5D0;">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 text-white px-4 py-1 rounded-full text-sm" style="background-color: #56C5D0;">
                        Paling Populer
                    </div>
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #56C5D0;">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: #56C5D0;">Cuci Setrika</h3>
                    <p class="text-gray-600 mb-6">Pakaian dicuci, dikeringkan, dan disetrika rapi siap pakai</p>
                    <p class="text-3xl font-bold mb-4" style="color: #56C5D0;">Rp 8.000<span class="text-lg">/kg</span></p>
                    <button class="text-white px-6 py-3 rounded-full transition" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#45a3ad'" onmouseout="this.style.backgroundColor='#56C5D0'">Pesan Sekarang</button>
                </div>

                <!-- Service 3 -->
                <div class="service-card bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #AEE4FF;">
                        <svg class="w-10 h-10" style="color: #56C5D0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: #56C5D0;">Setrika Saja</h3>
                    <p class="text-gray-600 mb-6">Khusus layanan setrika untuk pakaian yang sudah bersih</p>
                    <p class="text-3xl font-bold mb-4" style="color: #56C5D0;">Rp 4.000<span class="text-lg">/kg</span></p>
                    <button class="text-white px-6 py-3 rounded-full transition" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#45a3ad'" onmouseout="this.style.backgroundColor='#56C5D0'">Pesan Sekarang</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16" style="color: #56C5D0;">Mengapa Memilih Kami?</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #AEE4FF;">
                        <svg class="w-8 h-8" style="color: #56C5D0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #56C5D0;">Cepat 24 Jam</h3>
                    <p class="text-gray-600">Proses cepat dalam 24 jam</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #AEE4FF;">
                        <svg class="w-8 h-8" style="color: #56C5D0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #56C5D0;">Aman & Higienis</h3>
                    <p class="text-gray-600">Dijamin bersih dan wangi</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #AEE4FF;">
                        <svg class="w-8 h-8" style="color: #56C5D0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #56C5D0;">Gratis Antar Jemput</h3>
                    <p class="text-gray-600">Layanan door to door</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #AEE4FF;">
                        <svg class="w-8 h-8" style="color: #56C5D0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="color: #56C5D0;">Harga Terjangkau</h3>
                    <p class="text-gray-600">Kualitas premium harga bersahabat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Galeri Kami</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="rounded-xl overflow-hidden shadow-lg h-64 flex items-center justify-center" style="background: linear-gradient(135deg, #00ADB5 0%, #393E46 100%);">
                    <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="rounded-xl overflow-hidden shadow-lg h-64 flex items-center justify-center" style="background-color: #EEEEEE;">
                    <svg class="w-32 h-32" style="color: #00ADB5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="rounded-xl overflow-hidden shadow-lg h-64 flex items-center justify-center" style="background-color: #393E46;">
                    <svg class="w-32 h-32" style="color: #00ADB5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 gradient-bg text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Hubungi Kami Sekarang!</h2>
            <p class="text-xl mb-8">Siap melayani kebutuhan laundry Anda 24/7</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <button class="bg-white px-8 py-4 rounded-full font-semibold transition shadow-lg" style="color: #56C5D0;" onmouseover="this.style.backgroundColor='#AEE4FF'" onmouseout="this.style.backgroundColor='white'">
                    📱 WhatsApp: 0812-3456-7890
                </button>
                <button class="text-white px-8 py-4 rounded-full font-semibold transition shadow-lg" style="background-color: #A8E6CF;" onmouseover="this.style.backgroundColor='#8fd9b8'" onmouseout="this.style.backgroundColor='#A8E6CF'">
                    📧 Email: info@freshclean.com
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white py-12" style="background-color: #56C5D0;">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">FreshClean Laundry</h3>
                    <p>Layanan laundry profesional terpercaya sejak 2020</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li>Cuci Kering</li>
                        <li>Cuci Setrika</li>
                        <li>Setrika Saja</li>
                        <li>Express Service</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Jam Operasional</h4>
                    <ul class="space-y-2">
                        <li>Senin - Sabtu: 08.00 - 20.00</li>
                        <li>Minggu: 09.00 - 17.00</li>
                        <li>Antar Jemput 24 Jam</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Alamat</h4>
                    <p>Jl. Bersih No. 123<br>Jakarta Selatan<br>Indonesia 12345</p>
                </div>
            </div>
            <div class="border-t mt-8 pt-8 text-center" style="border-color: rgba(255,255,255,0.3);">
                <p>&copy; 2024 FreshClean Laundry. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function scrollToServices() {
            document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
        }

        // Smooth scroll for all navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Add scroll animation
        window.addEventListener('scroll', () => {
            const cards = document.querySelectorAll('.service-card');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight * 0.8) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        });
    </script>
</body>
</html>