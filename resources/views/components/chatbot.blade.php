<!-- Chatbot Component -->
<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    <!-- Chatbot Toggle Button -->
    <button id="chatbot-toggle"
            class="chatbot-toggle bg-primary hover:bg-primary/90 text-white rounded-full p-4 shadow-2xl transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-primary/30"
            aria-label="Open chat assistant">
        <svg id="chatbot-icon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <svg id="close-icon" class="w-6 h-6 transition-transform duration-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>

        <!-- Notification Badge -->
        <div id="notification-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-pulse hidden">
            1
        </div>
    </button>

    <!-- Chatbot Window -->
    <div id="chatbot-window"
         class="chatbot-window fixed bottom-20 right-6 w-80 sm:w-96 h-96 sm:h-[500px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 hidden overflow-hidden"
         style="transform: translateY(20px) scale(0.95); opacity: 0;">

        <!-- Header -->
        <div class="chatbot-header bg-gradient-to-r from-primary to-purple-600 text-white p-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 2.98.97 4.29L1 23l6.71-1.97C9.02 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-1.45 0-2.83-.29-4.09-.81L5 19.5l.38-1.91A7.95 7.95 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                                <circle cx="9" cy="12" r="1"/>
                                <circle cx="12" cy="12" r="1"/>
                                <circle cx="15" cy="12" r="1"/>
                            </svg>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">LadyLingo Assistant</h3>
                        <p class="text-xs opacity-90">Online • Sizga yordam berish uchun</p>
                    </div>
                </div>
                <button id="minimize-chat" class="p-1 hover:bg-white/20 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 h-72 sm:h-80">
            <!-- Welcome Message -->
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 2.98.97 4.29L1 23l6.71-1.97C9.02 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-1.45 0-2.83-.29-4.09-.81L5 19.5l.38-1.91A7.95 7.95 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-md p-3 max-w-xs">
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Salom! Men LadyLingo yordamchisi. Sizga qanday yordam bera olaman?
                        </p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Hozir</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-2">
                <button class="quick-action-btn bg-primary/10 hover:bg-primary/20 text-primary text-xs px-3 py-2 rounded-full transition-colors">
                    Tarjimon topish
                </button>
                <button class="quick-action-btn bg-primary/10 hover:bg-primary/20 text-primary text-xs px-3 py-2 rounded-full transition-colors">
                    Buyurtma berish
                </button>
                <button class="quick-action-btn bg-primary/10 hover:bg-primary/20 text-primary text-xs px-3 py-2 rounded-full transition-colors">
                    Narxlar haqida
                </button>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2">
                <div class="flex-1 relative">
                    <input type="text"
                           id="chat-input"
                           placeholder="Savolingizni yozing..."
                           class="w-full px-4 py-3 pr-12 bg-gray-100 dark:bg-gray-800 border-none rounded-2xl text-sm focus:ring-2 focus:ring-primary/20 focus:outline-none resize-none transition-all duration-200"
                           maxlength="500">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center gap-1">
                        <button id="emoji-btn" class="p-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-colors">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button id="send-btn"
                        class="bg-primary hover:bg-primary/90 text-white p-3 rounded-2xl transition-all duration-200 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>

            <!-- Character Counter -->
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs text-gray-500">
                    <span id="char-counter">0</span>/500
                </p>
                <p class="text-xs text-gray-400">
                    Enter tugmasini bosing
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Chatbot Styles -->
<style>
.chatbot-toggle {
    animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
}

.chatbot-window {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.chatbot-window.show {
    transform: translateY(0) scale(1) !important;
    opacity: 1 !important;
}

#chat-messages::-webkit-scrollbar {
    width: 6px;
}

#chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

#chat-messages::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.4);
    border-radius: 3px;
}

#chat-messages::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.6);
}

.typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
}

.typing-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background-color: #6b7280;
    animation: typing 1.4s infinite;
}

.typing-dot:nth-child(2) { animation-delay: 0.2s; }
.typing-dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}

.message-fade-in {
    animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile responsiveness */
@media (max-width: 640px) {
    .chatbot-window {
        width: calc(100vw - 2rem) !important;
        height: 400px !important;
        right: 1rem !important;
        bottom: 5rem !important;
    }

    .chatbot-toggle {
        bottom: 1.5rem !important;
        right: 1.5rem !important;
    }
}
</style>

<!-- Chatbot JavaScript -->
<script src="{{ asset('js/chatbot-advanced.js') }}"></script>
