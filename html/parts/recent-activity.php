<!-- ========================================
     RECENT ACTIVITY CARD
     ========================================
     Shows the user's recent reading activities (finished, started, favorited books)
-->
<div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
    
    <!-- Card title -->
    <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Recent Activity 🕐</h2>
    
    <!-- Activity list -->
    <div class="space-y-3">
        
        <?php if (!empty($recentActivity)): ?>
            <?php 
            // Loop through each activity
            foreach ($recentActivity as $activity): 
                
                // Convert the activity date to a DateTime object
                $actionDate = new DateTime($activity['action_date']);
                
                // Calculate the time difference between now and the activity date
                $interval = (new DateTime())->diff($actionDate);
                
                // Convert the time difference into a readable format
                if ($interval->days == 0) {
                    $timeAgo = "Today";
                } elseif ($interval->days == 1) {
                    $timeAgo = "Yesterday";
                } elseif ($interval->days < 7) {
                    $timeAgo = $interval->days . " days ago";
                } else {
                    // If older than a week, show the actual date
                    $timeAgo = $actionDate->format('M d, Y');
                }
                
                // Choose an emoji based on the activity type
                // The array maps action types to emojis
                // ?? '📝' means "if no match found, use 📝 as default"
                $emoji = ['started' => '📖', 'finished' => '✅', 'favorited' => '⭐'][$activity['action_type']] ?? '📝';
            ?>
                <!-- Single activity item -->
                <div class="flex items-center gap-3 text-gray-700">
                    <!-- Emoji icon -->
                    <span class="text-2xl"><?php echo $emoji; ?></span>
                    
                    <!-- Activity description -->
                    <p>
                        <!-- Action type (capitalize first letter with ucfirst) -->
                        <span class="font-bold"><?php echo ucfirst($activity['action_type']); ?></span> 
                        
                        <!-- Book title -->
                        "<?php echo htmlspecialchars($activity['title']); ?>" - 
                        
                        <!-- Time ago -->
                        <?php echo $timeAgo; ?>
                    </p>
                </div>
            <?php endforeach; ?>
            
        <?php else: ?>
            <!-- If no activities, show this message -->
            <p class="text-gray-600">No recent activity to show. Start reading!</p>
        <?php endif; ?>
    </div>
</div>