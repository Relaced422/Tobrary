<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if ($_SESSION != null) {
        echo "Persoon is ingelogd";
        echo "<br>";
        echo "vardump UserID: ";
        echo "<br>";
        var_dump($_SESSION);
    } else {
        echo "sessie gestart voor gast";
        echo "<br>";
        echo "vardump Session: ";
        var_dump($_SESSION);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Manrope:wght@200..800&display=swap"
        rel="stylesheet">
</head>

<body class="font-['Manrope',sans-serif]">
    <!-- Fixed Background -->
    <div class="fixed inset-0 bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] -z-10"></div>
    <?php include 'parts/header.php'; ?>
    <script src="js/header.js"></script>
    <main>
        <!-- Hero Section -->
        <div class="bg-[#D9D9D9] w-[70vw] mx-auto rounded-[20px] mt-10 shadow-lg items-center justify-center p-5 flex flex-col">
            <h1 class="text-black text-[50px] pt-20 font-['Lora',serif] font-bold">Tobrary - Your digital library realm.</h1>
            <h2 class="text-black text-2xl">Dive into knowledge from the comfort of your couch.</h2>
            <?php if ($_SESSION == null) { ?>
                <div class="flex justify-evenly items-center">
                    <a href="" class="bg-[#6F6F6F] p-4 h-[20%] rounded-xl text-white flex items-center text-2xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Browse Books
                    </a>
                    <img src="img/book-icon.png" alt="Book image" class="min-w-[200px]">
                    <a href="loginpage.php" class="bg-[#6F6F6F] p-4 rounded-xl text-white flex items-center text-2xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Log in / Join
                    </a>
                </div>
            <?php } else { ?>
                <div class="flex flex-col justify-evenly items-center">
                    <a href="" class="bg-[#6F6F6F] p-4 h-[20%] rounded-xl text-white flex items-center text-2xl mt-10 font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Browse Books
                    </a>
                    <img src="img/book-icon.png" alt="Book image" class="min-w-[200px]">
                </div>
            <?php } ?>
        </div>

        <!-- Navigation Section (Only show when logged in) -->
        <?php if ($_SESSION != null) { ?>
        <div class="w-[70vw] mx-auto mt-16">
            <!-- Navigation Grid -->
            <div class="bg-[#D9D9D9] rounded-[20px] p-8 shadow-lg">
                <div class="grid grid-cols-2 gap-4 relative">
                    <!-- Top Left -->
                    <a href="" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Borrowed Books
                    </a>
                    
                    <!-- Top Right -->
                    <a href="" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Search Catalog
                    </a>
                    
                    <!-- Bottom Left -->
                    <a href="" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Currently Reading
                    </a>
                    
                    <!-- Bottom Right -->
                    <a href="" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Favourites
                    </a>

                    <!-- Center "I" Icon -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#3A3A3A] w-24 h-24 flex items-center justify-center rounded-lg border-4 border-black">
                        <span class="text-white text-6xl font-bold font-['Lora',serif]">I</span>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Newly Added Books Section -->
        <div class="w-[70vw] mx-auto mt-16 pb-16">
            <h2 class="text-white text-4xl font-bold text-center mb-8 font-['Lora',serif]">Nieuw toegevoegd</h2>
            
            <!-- Books Carousel -->
            <div class="relative">
                <!-- Left Arrow -->
                <button onclick="scrollBooks('left')" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 bg-[#D9D9D9] hover:bg-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition z-10">
                    <span class="text-2xl font-bold">‹</span>
                </button>

                <!-- Books Container -->
                <div id="booksContainer" class="flex gap-6 overflow-x-auto scroll-smooth scrollbar-hide">
                    <!-- Book Card 1 -->
                    <div class="bg-[#D9D9D9] rounded-lg shadow-lg flex-shrink-0 w-[500px] p-4 flex gap-4">
                        <!-- Book Cover -->
                        <div class="w-48 h-64 bg-white rounded-lg border-4 border-black flex items-center justify-center relative flex-shrink-0">
                            <div class="absolute inset-4 border-2 border-black">
                                <div class="w-full h-1/3 border-b-2 border-black"></div>
                            </div>
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 -rotate-90 text-xs font-['Lora',serif] font-semibold whitespace-nowrap">
                                Boek title ziet er zo uit hier
                            </span>
                        </div>

                        <!-- Book Details -->
                        <div class="flex-1 flex flex-col">
                            <div class="bg-white rounded-lg p-4 border-2 border-black mb-2">
                                <h3 class="text-2xl font-bold font-['Lora',serif] mb-2">{Titel}</h3>
                                <div class="text-sm space-y-1">
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black flex-1">
                                    <p class="text-xs font-['Lora',serif] font-semibold">Author:</p>
                                    <p class="text-sm">{firstname, lastname}</p>
                                </div>
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black">
                                    <p class="text-sm font-['Lora',serif] font-semibold">{Genre}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 2 -->
                    <div class="bg-[#D9D9D9] rounded-lg shadow-lg flex-shrink-0 w-[500px] p-4 flex gap-4">
                        <div class="w-48 h-64 bg-white rounded-lg border-4 border-black flex items-center justify-center relative flex-shrink-0">
                            <div class="absolute inset-4 border-2 border-black">
                                <div class="w-full h-1/3 border-b-2 border-black"></div>
                            </div>
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 -rotate-90 text-xs font-['Lora',serif] font-semibold whitespace-nowrap">
                                Another book title here
                            </span>
                        </div>
                        <div class="flex-1 flex flex-col">
                            <div class="bg-white rounded-lg p-4 border-2 border-black mb-2">
                                <h3 class="text-2xl font-bold font-['Lora',serif] mb-2">{Titel}</h3>
                                <div class="text-sm space-y-1">
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black flex-1">
                                    <p class="text-xs font-['Lora',serif] font-semibold">Author:</p>
                                    <p class="text-sm">{firstname, lastname}</p>
                                </div>
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black">
                                    <p class="text-sm font-['Lora',serif] font-semibold">{Genre}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 3 -->
                    <div class="bg-[#D9D9D9] rounded-lg shadow-lg flex-shrink-0 w-[500px] p-4 flex gap-4">
                        <div class="w-48 h-64 bg-white rounded-lg border-4 border-black flex items-center justify-center relative flex-shrink-0">
                            <div class="absolute inset-4 border-2 border-black">
                                <div class="w-full h-1/3 border-b-2 border-black"></div>
                            </div>
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 -rotate-90 text-xs font-['Lora',serif] font-semibold whitespace-nowrap">
                                Third book example
                            </span>
                        </div>
                        <div class="flex-1 flex flex-col">
                            <div class="bg-white rounded-lg p-4 border-2 border-black mb-2">
                                <h3 class="text-2xl font-bold font-['Lora',serif] mb-2">{Titel}</h3>
                                <div class="text-sm space-y-1">
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                    <p>Dit is een samenvatting placeholder.</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black flex-1">
                                    <p class="text-xs font-['Lora',serif] font-semibold">Author:</p>
                                    <p class="text-sm">{firstname, lastname}</p>
                                </div>
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black">
                                    <p class="text-sm font-['Lora',serif] font-semibold">{Genre}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Arrow -->
                <button onclick="scrollBooks('right')" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 bg-[#D9D9D9] hover:bg-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition z-10">
                    <span class="text-2xl font-bold">›</span>
                </button>
            </div>
        </div>
    </main>
    
    <footer></footer>

    <!-- JavaScript for carousel -->
    <script>
        function scrollBooks(direction) {
            const container = document.getElementById('booksContainer');
            const scrollAmount = 520; // Card width + gap
            
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    </script>

    <style>
        /* Hide scrollbar but keep functionality */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</body>
</html>