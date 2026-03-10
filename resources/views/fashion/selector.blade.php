@extends('fashion.layout')

@section('title', 'Outfit Randomizer - Fashion Week')

@section('content')
    <div class="selector-container">
        <h1 class="selector-title">🎲 Outfit <span>Randomizer</span></h1>
        <p class="selector-subtitle">Can't decide what to wear? Let fate choose for you!</p>

        <div class="randomizer-box">
            <div class="random-icon" id="randomIcon">🎯</div>
            
            <button class="randomize-btn" id="randomizeBtn" onclick="randomize()">
                🎲 RANDOMIZE
            </button>

            <div class="result-box" id="resultBox">
                <div class="result-emoji" id="resultEmoji">👕</div>
                <div class="result-text" id="resultText">TOP</div>
                <p class="result-subtext" id="resultSubtext">Time to show off your best top!</p>
                <a href="{{ route('fashion.upload') }}" class="upload-btn">📸 Upload Your Look</a>
            </div>
        </div>
    </div>

    <script>
        const options = [
            { name: 'TOP', emoji: '👕', subtext: 'Time to show off your best top! 👕' },
            { name: 'BOTTOM', emoji: '👖', subtext: 'Show us your bottom style! 👖' },
            { name: 'FOOTWEAR', emoji: '👟', subtext: 'Step up your shoe game! 👟' },
            { name: 'FULL OUTFIT', emoji: '👔', subtext: 'Rock your full outfit! 👔' }
        ];

        let isAnimating = false;

        function randomize() {
            if (isAnimating) return;
            isAnimating = true;

            const btn = document.getElementById('randomizeBtn');
            const icon = document.getElementById('randomIcon');
            const resultBox = document.getElementById('resultBox');
            
            btn.disabled = true;
            resultBox.classList.remove('show');
            
            // Add animation effect
            icon.classList.add('spin-animation');
            
            // Show random emojis cycling
            let cycles = 0;
            const maxCycles = 10;
            const interval = setInterval(() => {
                const randomIdx = Math.floor(Math.random() * options.length);
                icon.textContent = options[randomIdx].emoji;
                cycles++;
                
                if (cycles >= maxCycles) {
                    clearInterval(interval);
                    showResult();
                }
            }, 150);
        }

        function showResult() {
            const icon = document.getElementById('randomIcon');
            const btn = document.getElementById('randomizeBtn');
            
            icon.classList.remove('spin-animation');
            
            // Pick final random result
            const result = options[Math.floor(Math.random() * options.length)];
            
            document.getElementById('resultEmoji').textContent = result.emoji;
            document.getElementById('resultText').textContent = result.name;
            document.getElementById('resultSubtext').textContent = result.subtext;
            
            const resultBox = document.getElementById('resultBox');
            resultBox.classList.add('show');
            
            // Add animation to emoji
            const emoji = document.getElementById('resultEmoji');
            emoji.style.animation = 'none';
            setTimeout(() => emoji.style.animation = 'pulse 0.5s ease', 10);
            
            isAnimating = false;
            btn.disabled = false;
        }
    </script>
@endsection

