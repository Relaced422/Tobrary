        // Register Modal Functions
        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Edit Profile Modal Functions
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('registerModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });

        document.getElementById('editProfileModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditProfileModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRegisterModal();
                closeEditProfileModal();
            }
        });