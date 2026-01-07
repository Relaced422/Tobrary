<div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Currently Reading 📖</h2>
    
    <!-- Grid that shows 1 column on mobile, 2 columns on medium screens and up -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <?php if (!empty($readingBooks)): ?>
            <?php 
            // Loop through each book the user is currently reading
            foreach ($readingBooks as $book): 
            ?>
                <!-- Each book card -->
                <div class="bg-white rounded-lg p-4 border-2 border-gray-300 hover:border-black transition">
                    
                    <!-- Book title -->
                    <h3 class="font-bold text-lg font-['Lora',serif]">
                        <?php echo htmlspecialchars($book['title']); ?>
                    </h3>
                    
                    <!-- Author name -->
                    <p class="text-sm text-gray-600">
                        <?php echo htmlspecialchars($book['author']); ?>
                    </p>
                    
                    <!-- Progress bar section -->
                    <div class="mt-2">
                        <!-- Gray background bar (full width) -->
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <!-- Green progress bar inside (width based on reading progress) -->
                            <!-- round() removes decimal places from the percentage -->
                            <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo round($book['progress']); ?>%"></div>
                        </div>
                        
                        <!-- Show percentage as text -->
                        <p class="text-xs text-gray-600 mt-1">
                            <?php echo round($book['progress']); ?>% complete
                        </p>
                    </div>
                    
                </div>
            <?php endforeach; ?>
            
        <?php else: ?>
            <!-- If no books are being read, show this message -->
            <!-- col-span-2 makes it take up both columns -->
            <p class="text-gray-600 col-span-2">You're not currently reading any books. Start exploring!</p>
        <?php endif; ?>
        
    </div>
    
    <!-- Button to browse more books -->
    <button class="mt-4 w-full px-4 py-2 bg-gray-300 text-[#2b2b2b] rounded-lg hover:bg-gray-400 transition font-semibold border-2 border-gray-400">
        + Browse More Books
    </button>
</div>