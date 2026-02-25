<?php
session_start();
include 'logic-php/connection.php';

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);

    $success = true;
}

$prefillName  = $_SESSION['userName']  ?? '';
$prefillEmail = $_SESSION['userEmail'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tobrary</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"">
</head>

<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">

    <?php include 'parts/header.php'; ?>

    <section class="hero-pattern text-center py-20 px-8 border-b border-red-500/20">
        <h1 class="text-5xl mb-4 hero-gradient-text font-black tracking-widest">CONTACT US</h1>
        <p class="text-xl text-gray-400 tracking-widest">We'd love to hear from you</p>
    </section>

    <main class="py-16 px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- LEFT COLUMN: Contact info cards -->
            <aside class="lg:col-span-1 flex flex-col gap-6">
                <h2 class="section-title text-2xl font-bold text-white tracking-wider">Get In Touch</h2>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Have a question about a book, reservation, or your account? 
                    Fill out the form and we'll get back to you as soon as possible.
                </p>

                <div class="bg-gray-900/80 rounded-xl p-6 border border-red-500/20">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl">📍</span>
                        <h3 class="text-white font-semibold">Visit Us</h3>
                    </div>
                    <div class="flex gap-3">
                        <div class="info-dot mt-1"></div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Tobrary Library<br>
                            123 Knowledge Street<br>
                            Innovation District, 1000 AA
                        </p>
                    </div>
                </div>
                <div class="bg-gray-900/80 rounded-xl p-6 border border-red-500/20">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl">🕐</span>
                        <h3 class="text-white font-semibold">Opening Hours</h3>
                    </div>
                    <div class="flex flex-col gap-2 text-sm text-gray-400">
                        <div class="flex justify-between">
                            <span>Monday – Friday</span>
                            <span class="text-red-400">09:00 – 20:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Saturday</span>
                            <span class="text-red-400">10:00 – 18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sunday</span>
                            <span class="text-gray-600">Closed</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900/80 rounded-xl p-6 border border-red-500/20">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl">📬</span>
                        <h3 class="text-white font-semibold">Reach Out</h3>
                    </div>
                    <div class="flex flex-col gap-3 text-sm">
                        <div class="flex gap-3 items-start">
                            <div class="info-dot"></div>
                            <div>
                                <p class="text-gray-500 text-xs mb-1">Email</p>
                                <p class="text-red-400">info@tobrary.com</p>
                            </div>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div class="info-dot"></div>
                            <div>
                                <p class="text-gray-500 text-xs mb-1">Phone</p>
                                <p class="text-red-400">+31 (0)20 123 4567</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- RIGHT COLUMN: Form -->
            <section class="lg:col-span-2">
                <div class="bg-gray-900/80 rounded-2xl p-8 md:p-10 border border-red-500/20 shadow-xl">

                    <h2 class="section-title text-2xl font-bold text-white tracking-wider mb-8">Send a Message</h2>

                    <?php if ($success): ?>
                        <!-- 
                            PHP shows this block when $success is true.
                            The form below is hidden when success is true.
                        -->
                        <div class="p-5 bg-green-500/10 border border-green-500/30 rounded-xl flex items-start gap-4">
                            <span class="text-2xl">✅</span>
                            <div>
                                <p class="text-green-400 font-semibold mb-1">Message Sent!</p>
                                <p class="text-gray-400 text-sm">Thank you for reaching out. We'll get back to you within 1–2 business days.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!$success): ?>
                        <!-- Hide the form once the message is sent -->
                        <form action="contact.php" method="POST" id="contactForm" class="flex flex-col gap-6">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <!-- Name Field -->
                                <div class="flex flex-col gap-2">
                                    <label for="name" class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <!-- value pre-fills if user is logged in, otherwise empty -->
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        placeholder="Your full name"
                                        value="<?= $prefillName ?>"
                                        required
                                        class="bg-gray-800/60 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 input-focus transition-all duration-200 text-sm"
                                    >
                                    <span class="text-red-400 text-xs hidden" id="nameError">Please enter your full name.</span>
                                </div>

                                <!-- Email Field -->
                                <div class="flex flex-col gap-2">
                                    <label for="email" class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        placeholder="your@email.com"
                                        value="<?= $prefillEmail ?>"
                                        required
                                        class="bg-gray-800/60 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 input-focus transition-all duration-200 text-sm"
                                    >
                                    <span class="text-red-400 text-xs hidden" id="emailError">Please enter a valid email address.</span>
                                </div>

                            </div>

                            <!-- Subject Field -->
                            <div class="flex flex-col gap-2">
                                <label for="subject" class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <select
                                    id="subject"
                                    name="subject"
                                    required
                                    class="bg-gray-800/60 border border-gray-700 rounded-lg px-4 py-3 text-white input-focus transition-all duration-200 text-sm"
                                >
                                    <option value="" class="bg-gray-900">Select a subject...</option>
                                    <option value="reservation" class="bg-gray-900">Book Reservation</option>
                                    <option value="account" class="bg-gray-900">My Account</option>
                                    <option value="general" class="bg-gray-900">General Question</option>
                                    <option value="feedback" class="bg-gray-900">Feedback</option>
                                    <option value="other" class="bg-gray-900">Other</option>
                                </select>
                                <span class="text-red-400 text-xs hidden" id="subjectError">Please select a subject.</span>
                            </div>

                            <!-- Message Field -->
                            <div class="flex flex-col gap-2">
                                <label for="message" class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="6"
                                    placeholder="Write your message here..."
                                    required
                                    class="bg-gray-800/60 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-600 input-focus transition-all duration-200 text-sm resize-none leading-relaxed"
                                ></textarea>
                                <div class="flex justify-between items-center">
                                    <span class="text-red-400 text-xs hidden" id="messageError">Please write a message (at least 10 characters).</span>
                                    <span class="text-gray-600 text-xs ml-auto" id="charCount">0 / 1000</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 pt-2">
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-bold uppercase tracking-wide transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/40 cursor-pointer text-sm"
                                >
                                    Send Message →
                                </button>
                                <p class="text-gray-600 text-xs">
                                    <span class="text-red-500">*</span> Required fields
                                </p>
                            </div>

                        </form>
                    <?php endif; ?>

                </div>
            </section>

        </div>
    </main>

    <?php include 'parts/footer.php'; ?>

    <script>
        const form = document.getElementById('contactForm');

        // If the form doesn't exist (e.g. after success, PHP hides it), stop here
        // Without this check, the JavaScript would crash trying to add events to a null element
        if (form) {
            const nameInput    = document.getElementById('name');
            const emailInput   = document.getElementById('email');
            const subjectInput = document.getElementById('subject');
            const messageInput = document.getElementById('message');

            // Character counter — updates as the user types
            messageInput.addEventListener('input', function () {
                const count = this.value.length;
                const max = 1000;
                const counter = document.getElementById('charCount');
                counter.textContent = count + ' / ' + max;
                counter.classList.toggle('text-red-400', count > max);
                counter.classList.toggle('text-gray-600', count <= max);
            });

            // Helper: show an error under a field
            function showError(errorId, inputEl) {
                document.getElementById(errorId).classList.remove('hidden');
                inputEl.classList.replace('border-gray-700', 'border-red-500');
            }

            // Helper: hide an error under a field
            function clearError(errorId, inputEl) {
                document.getElementById(errorId).classList.add('hidden');
                inputEl.classList.replace('border-red-500', 'border-gray-700');
            }

            // Validate before submitting
            form.addEventListener('submit', function (e) {
                let isValid = true;

                if (nameInput.value.trim() === '') {
                    showError('nameError', nameInput);
                    isValid = false;
                } else {
                    clearError('nameError', nameInput);
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value.trim())) {
                    showError('emailError', emailInput);
                    isValid = false;
                } else {
                    clearError('emailError', emailInput);
                }

                if (subjectInput.value === '') {
                    showError('subjectError', subjectInput);
                    isValid = false;
                } else {
                    clearError('subjectError', subjectInput);
                }

                if (messageInput.value.trim().length < 10) {
                    showError('messageError', messageInput);
                    isValid = false;
                } else {
                    clearError('messageError', messageInput);
                }

                // If invalid, stop the form from submitting so the user can fix the errors
                // If valid, do nothing — the form submits normally to PHP
                if (!isValid) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>