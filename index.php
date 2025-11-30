<?php
require_once __DIR__ . '/api/db.php';

// Preload gallery images for faster rendering
$preloadedGalleryImages = [];
$tableCheck = $conn->query("SHOW TABLES LIKE 'gallery_images'");
if ($tableCheck->num_rows > 0) {
    $sql = 'SELECT id, image_url, alt_text, display_order FROM gallery_images ORDER BY display_order ASC, created_at ASC';
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $preloadedGalleryImages[] = $row;
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Transparency Portal - Barangay San Antonio 1</title>
    <!-- Tailwind config + CDN -->
    <script src="assets/js/tailwind-config.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <script>
        // Preload gallery images from PHP
        window.preloadedGalleryImages = <?php echo json_encode($preloadedGalleryImages); ?>;
    </script>
</head>
<body class="bg-brgy-bg min-h-screen">

    <!-- Navbar -->
    <header class="hero-header bg-brgy-primary shadow-xl sticky top-0 z-20">
        <div class="header-content container mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg tracking-tight">Barangay San Antonio 1</h1>
                <p class="header-tagline text-sm md:text-base">Budget Transparency Portal</p>
            </div>
            <nav class="w-full sm:w-auto flex flex-wrap items-center justify-center sm:justify-end gap-2">
                <a href="#budget-transparency" class="header-nav-link hover:bg-brgy-secondary hover:text-white px-4 py-2 rounded-full transition-all duration-200">Budget Transparency</a>
                <a href="#announcements" class="header-nav-link hover:bg-brgy-secondary hover:text-white px-4 py-2 rounded-full transition-all duration-200">Announcements</a>
                <a href="#barangay-in-action" class="header-nav-link hover:bg-brgy-secondary hover:text-white px-4 py-2 rounded-full transition-all duration-200">Barangay in Action</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="container mx-auto p-4 md:p-8">
        
        <!-- Budget Transparency Section -->
        <section id="budget-transparency" class="bg-white p-6 md:p-10 rounded-xl shadow-2xl mb-12 scroll-mt-20">
            <h2 class="text-4xl font-bold text-brgy-primary mb-6 border-b-4 border-brgy-secondary pb-2">Budget Transparency</h2>
            <p class="text-gray-600 mb-8">View the annual budget allocations, expenditures, and project status for Barangay San Antonio 1, San Pablo City.</p>
            
            <!-- Summary Cards -->
            <div id="summary-cards" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Summary cards will be populated by JavaScript -->
            </div>

            <!-- Budget Table -->
            <div class="table-card bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="budgetTable" class="w-full">
                        <thead class="bg-brgy-primary">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider text-black">Project/Category</th>
                                <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider text-black">Allocated (₱)</th>
                                <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider text-black">Spent (₱)</th>
                                <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider text-black">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider text-black">Progress/Updates</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Table rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Announcements Section -->
        <section id="announcements" class="bg-white p-6 md:p-10 rounded-xl shadow-2xl mb-12 scroll-mt-20">
            <h2 class="text-4xl font-bold text-brgy-primary mb-6 border-b-4 border-brgy-secondary pb-2">Latest Announcements</h2>
            <p class="text-gray-600 mb-8">Stay updated with the latest news, updates, and announcements from Barangay San Antonio 1.</p>
            
            <div id="public-posts" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Posts will be populated by JavaScript -->
            </div>
        </section>

        <!-- Live Projects Gallery Section -->
        <section id="barangay-in-action" class="bg-white p-6 md:p-10 rounded-xl shadow-2xl mb-12 scroll-mt-20">
            <div class="bg-gray-900 text-white rounded-xl shadow-2xl p-6 md:p-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-3xl font-bold">Barangay in Action</h3>
                        <p class="text-gray-300">Ongoing infrastructure and maintenance efforts around San Antonio 1.</p>
                    </div>
                    <span class="text-sm uppercase tracking-widest text-gray-400">Live Project Highlights</span>
                </div>
                <div class="gallery-marquee">
                    <div class="gallery-track" id="gallery-track">
                        <!-- Gallery images will be loaded here -->
                    </div>
                </div>
                <p class="mt-4 text-xs text-gray-400">Tip: Hover to pause the scroll.</p>
            </div>
        </section>

    </main>

    <!-- Chatbot Section (Fixed Position) -->
    <div id="chatbot-container" class="hidden fixed bottom-4 right-4 w-80 md:w-96 bg-white rounded-xl shadow-2xl border-2 border-brgy-primary z-50 flex flex-col max-h-[600px]">
        <div class="bg-brgy-primary text-white p-4 rounded-t-xl flex justify-between items-center">
            <h3 class="font-bold text-lg">💬 Chat with Us</h3>
            <button onclick="toggleChatbot()" class="text-black hover:text-white bg-white hover:bg-gray-700 w-8 h-8 rounded-full flex items-center justify-center text-2xl font-bold transition-colors duration-200">&times;</button>
        </div>
        
        <!-- Message Type Selection -->
        <div id="message-type-selector" class="p-4 border-b border-gray-200 bg-white">
            <p class="text-sm font-medium text-gray-700 mb-2">How would you like to contact us?</p>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="selectMessageType('concern')" class="px-3 py-2 bg-orange-500 text-white text-sm rounded-lg hover:bg-orange-600 transition duration-150">
                    📋 Submit Concern
                </button>
                <button onclick="selectMessageType('message')" class="px-3 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition duration-150">
                    💬 Live Chat
                </button>
            </div>
        </div>
        
        <!-- Concern Form -->
        <div id="concern-form" class="hidden flex-1 overflow-y-auto p-4 bg-gray-50 flex flex-col">
            <div class="flex-1">
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                        <textarea id="concern-message" rows="4" placeholder="Type your message here..." class="w-full p-2 border border-gray-300 rounded-lg focus:ring-brgy-primary focus:border-brgy-primary"></textarea>
                    </div>
                    <button onclick="submitConcern()" class="w-full py-2 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition duration-150">
                        Send Message
                    </button>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                <button onclick="resetChatbot()" class="w-full py-2 bg-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-400 transition duration-150">
                    Close
                </button>
            </div>
        </div>
        
        <!-- Chat Messages -->
        <div id="chatbot-messages" class="hidden flex-1 overflow-y-auto p-4 bg-gray-50 space-y-2">
            <div class="message-box bot">
                Hello! 👋 Welcome to Barangay San Antonio 1's Budget Transparency Portal. How can I help you today? You can ask about the budget, submit concerns, or get information about our services.
            </div>
        </div>
        
        <!-- Chat Input -->
        <div id="chat-input-container" class="hidden p-4 border-t border-gray-200 bg-white rounded-b-xl">
            <div class="flex gap-2">
                <input type="text" id="user-input" placeholder="Type your message..." class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-brgy-primary focus:border-brgy-primary" autocomplete="off">
                <button onclick="handleUserMessage()" class="px-6 py-3 bg-brgy-primary text-white font-bold rounded-lg hover:bg-emerald-700 transition duration-150">Send</button>
            </div>
            <button onclick="resetChatbot()" class="w-full mt-2 py-2 bg-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-400 transition duration-150">
                Back to Options
            </button>
        </div>
    </div>

    <!-- Chatbot Toggle Button -->
    <button onclick="toggleChatbot()" class="fixed bottom-4 right-4 bg-black text-white p-4 rounded-full shadow-2xl hover:bg-gray-800 hover:scale-110 transition-all duration-200 z-40 flex items-center justify-center w-16 h-16">
        <span class="text-2xl">💬</span>
    </button>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6 mt-8">
        <div class="container mx-auto text-center">
            <p>© 2025 Barangay San Antonio 1. Budget Transparency Portal, San Pablo City.</p>
        </div>
    </footer>

    <!-- Main application logic -->
    <script defer src="assets/js/app.js"></script>

</body></html>

