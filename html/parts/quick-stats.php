<!-- ========================================
     QUICK STATS CARD
     ========================================
     Shows a summary of the user's reading statistics
-->
<div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
    
    <!-- Card title -->
    <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Quick Stats</h2>
    
    <!-- Statistics list -->
    <div class="space-y-3">
        
        <!-- Books completed count -->
        <div class="flex justify-between items-center">
            <span class="text-gray-700">Books Read</span>
            <span class="text-2xl font-bold text-green-600 font-['Lora',serif]">
                <?php 
                // Show number of completed books
                // ?? 0 means "if $booksCompleted doesn't exist, show 0 instead"
                echo $booksCompleted ?? 0; 
                ?>
            </span>
        </div>
        
        <!-- Currently reading count -->
        <div class="flex justify-between items-center">
            <span class="text-gray-700">Currently Reading</span>
            <span class="text-2xl font-bold text-blue-600 font-['Lora',serif]">
                <?php echo $currentlyReading ?? 0; ?>
            </span>
        </div>
        
        <!-- Favorites count -->
        <div class="flex justify-between items-center">
            <span class="text-gray-700">Favorites</span>
            <span class="text-2xl font-bold text-purple-600 font-['Lora',serif]">
                <?php echo $favoritesCount ?? 0; ?>
            </span>
        </div>
    </div>
</div>