<div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Borrowed Books 📚</h2>
    
    <div class="space-y-3">
        <?php if (!empty($borrowedBooks)): ?>
            <?php 
            // Loop through each borrowed book
            foreach ($borrowedBooks as $book): 
                
                // Convert the due date string to a DateTime object so we can work with it
                $dueDate = new DateTime($book['dueDate']);
                
                // Get today's date
                $today = new DateTime();
                
                // Check if the book is overdue (due date has passed)
                $isOverdue = $dueDate < $today;
                
                // Calculate how many days until the book is due
                // diff() compares two dates and returns the difference
                $daysUntilDue = $today->diff($dueDate)->days;
                
                // Choose the text color based on how soon the book is due
                // Red if overdue, orange if due in 3 days or less, green otherwise
                if ($isOverdue) {
                    $colorClass = 'text-red-600';
                } elseif ($daysUntilDue <= 3) {
                    $colorClass = 'text-orange-600';
                } else {
                    $colorClass = 'text-green-600';
                }
            ?>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-300 flex justify-between items-center">
                    <div>
                        <!-- Show the book title -->
                        <h3 class="font-bold"><?php echo htmlspecialchars($book['title']); ?></h3>
                        <!-- Show the author name -->
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($book['author']); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Due Date</p>
                        <!-- Show the due date with the appropriate color -->
                        <p class="font-bold <?php echo $colorClass; ?>">
                            <?php echo $dueDate->format('M d, Y'); ?>
                            <!-- If overdue, show "Overdue!" text -->
                            <?php if ($isOverdue): ?>
                                <br><span class="text-xs">(Overdue!)</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- If no borrowed books, show this message -->
            <p class="text-gray-600">No borrowed books at the moment.</p>
        <?php endif; ?>
    </div>
</div>