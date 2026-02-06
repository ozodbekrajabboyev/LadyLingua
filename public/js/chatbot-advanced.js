/**
 * Advanced Chatbot Functionality
 * LladyLingua Chatbot Enhancement
 */

class LadyLingoChatbot {
    constructor() {
        this.isOpen = false;
        this.messageHistory = [];
        this.currentSession = {
            startTime: new Date(),
            messageCount: 0,
            userSatisfaction: null
        };
        this.typingSpeed = 50; // ms per character
        this.responses = this.initializeResponses();
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadChatHistory();
        this.setupPeriodicEngagement();
    }

    initializeResponses() {
        return {
            // Greeting patterns
            greetings: {
                patterns: ['salom', 'hello', 'assalom', 'hi', 'hey', 'good morning', 'good afternoon'],
                responses: [
                    "Salom! LladyLingua platformasiga xush kelibsiz! 🌟 Men sizga qanday yordam bera olaman?",
                    "Assalomu alaykum! Men LladyLingua yordamchisiman. Bugun sizga qanday xizmat ko'rsata olaman?",
                    "Salom! Tarjima xizmatlarimiz haqida biror narsani bilmoqchimisiz? 😊"
                ],
                quickActions: ['Tarjimonlar', 'Narxlar', 'Buyurtma berish']
            },

            // Translation services
            translation: {
                patterns: ['tarjimon', 'translation', 'translate', 'tarjima', 'interpreter'],
                responses: [
                    "Bizda 50+ professional tarjimonlarimiz mavjud! 📚 Har bir tarjimon o'z sohasida mutaxassis va yuqori reytingga ega. Qaysi til juftligini qidiryapsiz?",
                    "Professional tarjima xizmatlarimiz 24/7 mavjud. Bizning tarjimonlarimiz 15+ tilda ishlashadi. Ko'proq ma'lumot olishni xohlaysizmi?"
                ],
                quickActions: ['Tarjimonlar ro\'yxati', 'Til juftliklari', 'Reytinglar']
            },

            // Pricing
            pricing: {
                patterns: ['narx', 'price', 'cost', 'pul', 'to\'lov', 'payment'],
                responses: [
                    "Narxlarimiz raqobatbardosh! 💰 Odatda:\n• Oddiy matn: 15,000-25,000 so'm/sahifa\n• Texnik hujjat: 25,000-35,000 so'm/sahifa\n• Adabiy asar: 20,000-40,000 so'm/sahifa\n\nAniq narx matn murakkabligiga bog'liq.",
                    "Bizda shaffof narxlar tizimi mavjud! Narx quyidagilarga bog'liq:\n• Matn turi va murakkabligi\n• Til juftligi\n• Muddatlar\n• Hajmi\n\nBepul baholash xizmati ham mavjud! 📊"
                ],
                quickActions: ['Bepul baholash', 'Narxlar jadvali', 'Chegirmalar']
            },

            // Orders
            orders: {
                patterns: ['buyurtma', 'order', 'zakazat', 'yuklash', 'upload'],
                responses: [
                    "Buyurtma berish juda oson! 🚀 Qadamlar:\n1. Tizimga kiring\n2. Hujjatni yuklang\n3. Til juftligini tanlang\n4. Muddatni belgilang\n5. To'lovni amalga oshiring\n\nBarcha jarayon 5 daqiqadan kam vaqt oladi!",
                    "Buyurtma berish jarayonida yordam kerakmi? Men sizga qadamlar bo'yicha yo'l ko'rsata olaman. Qaysi bosqichda qiyinchilik bor?"
                ],
                quickActions: ['Buyurtma berish', 'Yo\'riqnoma', 'Yordam kerak']
            },

            // Support
            support: {
                patterns: ['yordam', 'help', 'support', 'muammo', 'problem', 'savol', 'question'],
                responses: [
                    "Albatta yordam beraman! 🤝 Men quyidagi masalalar bo'yicha yordam bera olaman:\n• Tarjimon tanlash\n• Buyurtma berish\n• To'lov masalalari\n• Texnik masalalar\n\nQaysi masala bo'yicha yordam kerak?",
                    "Qanday yordam kerak? Men doimo sizning xizmatingizdaman! Masalani batafsil aytib bering, eng yaxshi yechimni topamiz. 💪"
                ],
                quickActions: ['Texnik yordam', 'To\'lov masalalari', 'Operator bilan bog\'lanish']
            },

            // Quality assurance
            quality: {
                patterns: ['sifat', 'quality', 'guarantee', 'kafolat', 'tekshirish'],
                responses: [
                    "Bizda 100% sifat kafolati! ✅ Barcha tarjimalar:\n• 2 marta tekshiriladi\n• Professional muharrirlar tomonidan ko'rib chiqiladi\n• Mijoz talablariga moslashtiriladi\n\nAgar natija yoqmasa, bepul qayta ishlash xizmati mavjud!",
                    "Sifat bizning ustuvor yo'nalishimiz! Har bir tarjima 3 bosqichdan o'tadi: tarjima → tekshiruv → sifat nazorati. Kafolat muddati - 6 oy! 🛡️"
                ],
                quickActions: ['Sifat standarti', 'Mijoz fikrlari', 'Kafolat shartlari']
            },

            // Languages
            languages: {
                patterns: ['til', 'language', 'ingliz', 'rus', 'arab', 'forsiy', 'turk'],
                responses: [
                    "Bizda 20+ til juftligi mavjud! 🌍 Eng mashhur yo'nalishlar:\n• O'zbek ↔ Ingliz\n• O'zbek ↔ Rus\n• O'zbek ↔ Arab\n• O'zbek ↔ Turk\n• O'zbek ↔ Forsiy\n\nQaysi til kerak?",
                    "Til juftliklari bo'yicha sizga yordam beray! Bizning tarjimonlarimiz quyidagi tillarda mutaxassis: Ingliz, Rus, Arab, Turk, Forsiy, Nemis, Fransuz va boshqalar."
                ],
                quickActions: ['Barcha tillar', 'Mashhur juftliklar', 'Noyob tillar']
            },

            // Default responses
            default: [
                "Kechirasiz, bu savolni to'liq tushunmadim. 🤔 Iltimos, savolni boshqa usulda yozib ko'ring yoki quyidagi mavzulardan birini tanlang.",
                "Bu savolga aniq javob bera olmayapman. Ammo bizning mutaxassislari sizga yordam berishi mumkin! 📞",
                "Savol aniq emas. Men quyidagi mavzularda yordam bera olaman: tarjima xizmatlari, narxlar, buyurtma berish, sifat kafolati."
            ]
        };
    }

    bindEvents() {
        // Main toggle button
        document.getElementById('chatbot-toggle')?.addEventListener('click', () => this.toggleChat());

        // Close button
        document.getElementById('minimize-chat')?.addEventListener('click', () => this.toggleChat());

        // Send message
        document.getElementById('send-btn')?.addEventListener('click', () => this.handleSendMessage());

        // Enter key for sending
        document.getElementById('chat-input')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.handleSendMessage();
            }
        });

        // Input character counter and validation
        document.getElementById('chat-input')?.addEventListener('input', () => this.updateInputState());

        // Quick action buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('quick-action-btn')) {
                this.handleQuickAction(e.target.textContent.trim());
            }
        });

        // Outside click to close
        document.addEventListener('click', (e) => {
            if (this.isOpen &&
                !document.getElementById('chatbot-window').contains(e.target) &&
                !document.getElementById('chatbot-toggle').contains(e.target)) {
                this.scheduleClose();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.toggleChat();
            }
        });
    }

    toggleChat() {
        const window = document.getElementById('chatbot-window');
        const toggle = document.getElementById('chatbot-toggle');
        const chatIcon = document.getElementById('chatbot-icon');
        const closeIcon = document.getElementById('close-icon');
        const badge = document.getElementById('notification-badge');

        this.isOpen = !this.isOpen;

        if (this.isOpen) {
            window.classList.remove('hidden');
            setTimeout(() => window.classList.add('show'), 10);
            chatIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            badge?.classList.add('hidden');
            toggle.classList.remove('animate-pulse');
            document.getElementById('chat-input')?.focus();
            this.trackEvent('chat_opened');
        } else {
            window.classList.remove('show');
            setTimeout(() => window.classList.add('hidden'), 300);
            chatIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            this.trackEvent('chat_closed');
        }
    }

    handleSendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();

        if (!message) return;

        // Add user message
        this.addMessage(message, true);

        // Clear input and update state
        input.value = '';
        this.updateInputState();

        // Process message and get response
        this.processUserMessage(message);

        // Update session stats
        this.currentSession.messageCount++;
    }

    async processUserMessage(message) {
        // Show typing indicator
        this.showTypingIndicator();

        // Simulate processing delay
        await new Promise(resolve => setTimeout(resolve, 1000 + Math.random() * 1500));

        // Generate response
        const response = this.generateResponse(message.toLowerCase());

        // Remove typing indicator
        this.removeTypingIndicator();

        // Add bot response with typing effect
        await this.addMessageWithTypingEffect(response.text, false);

        // Add quick actions if available
        if (response.quickActions?.length > 0) {
            this.addQuickActions(response.quickActions);
        }
    }

    generateResponse(message) {
        // Check for specific patterns
        for (const [category, data] of Object.entries(this.responses)) {
            if (category === 'default') continue;

            if (data.patterns.some(pattern => message.includes(pattern))) {
                const responses = Array.isArray(data.responses) ? data.responses : [data.responses];
                return {
                    text: responses[Math.floor(Math.random() * responses.length)],
                    quickActions: data.quickActions || []
                };
            }
        }

        // Default response
        return {
            text: this.responses.default[Math.floor(Math.random() * this.responses.default.length)],
            quickActions: ['Tarjimonlar', 'Narxlar', 'Buyurtma', 'Operator bilan bog\'lanish']
        };
    }

    async addMessageWithTypingEffect(message, isUser = false) {
        if (isUser) {
            this.addMessage(message, true);
            return;
        }

        // Create message element
        const messageContainer = this.createMessageElement('', false);
        const textElement = messageContainer.querySelector('.message-text');

        // Type out message character by character
        for (let i = 0; i <= message.length; i++) {
            textElement.textContent = message.substring(0, i);
            await new Promise(resolve => setTimeout(resolve, this.typingSpeed));
        }
    }

    addMessage(message, isUser = false, quickActions = []) {
        const messageContainer = this.createMessageElement(message, isUser);
        const messagesContainer = document.getElementById('chat-messages');

        messagesContainer.appendChild(messageContainer);
        this.scrollToBottom();

        // Store in history
        this.messageHistory.push({
            message,
            isUser,
            timestamp: new Date(),
            quickActions
        });

        // Save to localStorage
        this.saveChatHistory();
    }

    createMessageElement(message, isUser) {
        const div = document.createElement('div');
        div.className = `flex items-start gap-3 message-fade-in ${isUser ? 'justify-end' : ''}`;

        const timestamp = new Date().toLocaleTimeString('uz-UZ', {
            hour: '2-digit',
            minute: '2-digit'
        });

        if (isUser) {
            div.innerHTML = `
                <div class="flex-1 max-w-xs">
                    <div class="message-bubble user p-3 ml-auto">
                        <p class="text-sm message-text">${message}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 text-right">${timestamp}</p>
                </div>
            `;
        } else {
            div.innerHTML = `
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 status-indicator">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 2.98.97 4.29L1 23l6.71-1.97C9.02 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-1.45 0-2.83-.29-4.09-.81L5 19.5l.38-1.91A7.95 7.95 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="message-bubble bot p-3 max-w-xs">
                        <p class="text-sm message-text whitespace-pre-line">${message}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">${timestamp}</p>
                </div>
            `;
        }

        return div;
    }

    addQuickActions(actions) {
        const container = document.createElement('div');
        container.className = 'flex flex-wrap gap-2 ml-11 mt-2';

        actions.forEach(action => {
            const button = document.createElement('button');
            button.className = 'quick-action-btn text-xs px-3 py-2 rounded-full';
            button.textContent = action;
            container.appendChild(button);
        });

        document.getElementById('chat-messages').appendChild(container);
        this.scrollToBottom();
    }

    showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'typing-indicator';
        indicator.className = 'flex items-start gap-3 message-fade-in';
        indicator.innerHTML = `
            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 2.98.97 4.29L1 23l6.71-1.97C9.02 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-1.45 0-2.83-.29-4.09-.81L5 19.5l.38-1.91A7.95 7.95 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-md p-3 max-w-xs">
                    <div class="typing-indicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('chat-messages').appendChild(indicator);
        this.scrollToBottom();
    }

    removeTypingIndicator() {
        const indicator = document.getElementById('typing-indicator');
        indicator?.remove();
    }

    updateInputState() {
        const input = document.getElementById('chat-input');
        const counter = document.getElementById('char-counter');
        const sendBtn = document.getElementById('send-btn');

        const length = input.value.length;
        counter.textContent = length;
        sendBtn.disabled = length === 0;

        // Visual feedback for character limit
        if (length > 450) {
            counter.classList.add('text-red-500');
            input.classList.add('border-red-300');
        } else {
            counter.classList.remove('text-red-500');
            input.classList.remove('border-red-300');
        }
    }

    handleQuickAction(action) {
        const responses = {
            'Tarjimonlar': 'Bizning professional tarjimonlarimizni ko\'rish uchun /translators sahifasiga o\'ting.',
            'Narxlar': 'Narxlar haqida batafsil ma\'lumot olish uchun bepul baholash xizmatidan foydalaning.',
            'Buyurtma berish': 'Buyurtma berish uchun tizimga kirib, hujjatingizni yuklay olasiz.',
            'Operator bilan bog\'lanish': 'Operatorlarimiz 24/7 sizga yordam berish uchun tayyor. Telefon: +998 71 123-45-67'
        };

        if (responses[action]) {
            // Add user message (quick action)
            this.addMessage(action, true);

            // Add bot response
            setTimeout(() => {
                this.addMessage(responses[action], false);
            }, 800);
        }
    }

    scrollToBottom() {
        const container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    }

    scheduleClose() {
        // Close chat after 5 seconds of inactivity if user clicked outside
        setTimeout(() => {
            if (this.isOpen && !document.getElementById('chatbot-window').matches(':hover')) {
                this.toggleChat();
            }
        }, 5000);
    }

    setupPeriodicEngagement() {
        // Show notification after 30 seconds if chat is closed
        setTimeout(() => {
            if (!this.isOpen && this.currentSession.messageCount === 0) {
                this.showEngagementNotification();
            }
        }, 30000);

        // Show proactive help after 2 minutes
        setTimeout(() => {
            if (!this.isOpen) {
                this.showProactiveHelp();
            }
        }, 120000);
    }

    showEngagementNotification() {
        const badge = document.getElementById('notification-badge');
        const toggle = document.getElementById('chatbot-toggle');

        badge?.classList.remove('hidden');
        toggle?.classList.add('animate-pulse');

        this.trackEvent('engagement_notification_shown');
    }

    showProactiveHelp() {
        if (this.isOpen) return;

        // Auto-open chat with helpful message
        this.toggleChat();

        setTimeout(() => {
            this.addMessage(
                "Salom! Ko'rdimki, saytda bir muncha vaqt davomida bo'lgansiz. Biror yordam kerakmi? Men sizga tarjima xizmatlarimiz haqida ma'lumot berishim mumkin! 😊",
                false,
                ['Ha, yordam kerak', 'Yo\'q, rahmat', 'Narxlar haqida']
            );
        }, 1000);

        this.trackEvent('proactive_help_shown');
    }

    saveChatHistory() {
        try {
            localStorage.setItem('ladylingo_chat_history', JSON.stringify(this.messageHistory.slice(-50))); // Keep last 50 messages
        } catch (e) {
            console.warn('Could not save chat history:', e);
        }
    }

    loadChatHistory() {
        try {
            const saved = localStorage.getItem('ladylingo_chat_history');
            if (saved) {
                this.messageHistory = JSON.parse(saved);
                // Don't restore messages on page load for better UX
            }
        } catch (e) {
            console.warn('Could not load chat history:', e);
        }
    }

    trackEvent(eventName, data = {}) {
        // Analytics tracking (placeholder for future integration)
        console.log('Chatbot Event:', eventName, {
            ...data,
            timestamp: new Date().toISOString(),
            sessionDuration: (new Date() - this.currentSession.startTime) / 1000,
            messageCount: this.currentSession.messageCount
        });

        // Send to analytics service when available
        if (typeof gtag !== 'undefined') {
            gtag('event', eventName, {
                event_category: 'chatbot',
                ...data
            });
        }
    }

    // Public API methods
    openChat() {
        if (!this.isOpen) {
            this.toggleChat();
        }
    }

    closeChat() {
        if (this.isOpen) {
            this.toggleChat();
        }
    }

    sendMessage(message) {
        const input = document.getElementById('chat-input');
        input.value = message;
        this.handleSendMessage();
    }

    clearHistory() {
        this.messageHistory = [];
        localStorage.removeItem('ladylingo_chat_history');

        // Clear visual messages except welcome message
        const messages = document.getElementById('chat-messages');
        const children = Array.from(messages.children);
        children.slice(2).forEach(child => child.remove()); // Keep first 2 elements (welcome + quick actions)
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.ladyLingoChatbot = new LadyLingoChatbot();
});

// Export for potential external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LadyLingoChatbot;
}
